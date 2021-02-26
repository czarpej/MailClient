<?php

if(isset($_POST['register']))
{
	if(!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['repeat_password']))
		echo 'Sory, service unavailable.';
	else
	{
		$inputEmpty=false;
		$inputError=false;
		$inputErrorUsername=false;
		$inputErrorEmail=false;
		$inputErrorPassword=false;

		if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['repeat_password']))
		{
			$inputEmpty=true;
			echo 'You must fill required (<span class="required" style="margin: 0;">*</span>) fields!';
		}
		else
		{
			require_once 'dbconnect.php';
			try
			{
				if($connect->connect_errno!=0)
					throw new Exception($connect->error);
				else
				{
					//data to registration
					$username=$connect->real_escape_string($_POST['username']);
					$email=$connect->real_escape_string($_POST['email']);
					$email_sanitize=filter_var($email, FILTER_SANITIZE_EMAIL);
					$password=$connect->real_escape_string($_POST['password']);
					$repeat_password=$connect->real_escape_string($_POST['repeat_password']);

					//reCaptcha
					$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
				    $recaptcha_secret = '6Lcf_4MUAAAAAOk-7WLEYLmK44cib7ZaBR2UtBww';
				    $recaptcha_response = $_POST['recaptcha_response'];

				    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
				    $recaptcha_result = json_decode($recaptcha);
					

					if(!filter_var($email_sanitize, FILTER_SANITIZE_EMAIL) || $email_sanitize!=$email)
					{
						$inputError=true;
						$inputErrorEmail=true;
						echo 'You must enter a vaild e-mail address!';
					}
					else if($password!==$repeat_password)
					{
						$inputError=true;
						$inputErrorPassword=true;
						echo 'Passwords must be consistent!';
					}
					
					else if($recaptcha_result->success==false)
					{
						$inputError=true;
						echo 'Error! You have not passed test reCaptcha.';
					}
					
					else
					{
						if($login_isset=$connect->prepare("SELECT login FROM login_data WHERe login=?"))
						{
							$login_isset->bind_param('s', $username);
							if($login_isset->execute())
							{
								$login_result=$login_isset->get_result();
								if($login_result->num_rows>0)
								{
									$inputError=true;
									$inputErrorUsername=true;
									echo 'This username already in use!';
								}
							}
							else
								throw new Exception($connect->error);
						}
						else
							throw new Exception($connect->error);

						if($email_isset=$connect->prepare("SELECT email FROM login_data WHERE email=?"))
						{
							$email_isset->bind_param('s', $email);
							if($email_isset->execute())
							{
								$email_result=$email_isset->get_result();
								if($email_result->num_rows>0)
								{
									$inputError=true;
									$inputErrorEmail=true;
									echo 'This e-mail already in use!';
								}
							}
							else
								throw new Exception($connect->error);
						}
						else
							throw new Exception($connect->error);

						if($inputError===false && $inputEmpty===false)
						{
							if($insert=$connect->prepare("INSERT INTO login_data VALUES('', ?, ?, ?)"))
							{
								$password_hash=password_hash($password, PASSWORD_DEFAULT);
								$insert->bind_param('sss', $username, $email, $password_hash);
								if($insert->execute())
								{
									if($newUserId=$connect->query("SELECT id FROM login_data"))
									{
										if($newUserId->num_rows>0)
										{
											$idUser='';
											while($newUserIdResults=$newUserId->fetch_row())
												$idUser=$newUserIdResults[0];
											require_once 'registration_messages.php';
											if(($connect->query("INSERT INTO messages VALUES('', 6, '".$message1."', now(), '".$idUser."', 0)")) && ($connect->query("INSERT INTO messages VALUES('', 6, '".$message2."', now(), '".$idUser."', 0)")))
												echo 'Registration has been completed success.';
											else
												throw new Exception($connect->error);
										}
										else
											throw new Exception($connect->error);
									}
									else
										throw new Exception($connect->error);
								}
								else
									throw new Exception($connect->error);
							}
							else
								throw new Exception($connect->error);
						}
					}
				}
			}
			catch(Exception $e)
			{
				echo 'Sory, service unavailable.';
				exit();
			}
		}
	}
}
else
	echo 'Sory, service unavailable.';

?>

<script>

	var inputEmpty="<?php echo $inputEmpty; ?>";
	var inputError="<?php echo $inputError; ?>";
	var inputErrorUsername="<?php echo $inputErrorUsername; ?>";
	var inputErrorEmail="<?php echo $inputErrorEmail; ?>";
	var inputErrorPassword="<?php echo $inputErrorPassword; ?>";

	$(".info_message").removeClass("info-ok info-error");
	$(".input-register").removeClass("input-error").on("change", function() {
		$(this).removeClass("input-error");
	}).on("keydown", function() {
		$(this).removeClass("input-error");
	});

	if(inputEmpty==true)
	{
		$(".info_message").addClass("info-error");
		if($("#username").val()=="")
			$("#username").addClass("input-error");
		if($("#email").val()=="")
			$("#email").addClass("input-error");
		if($("#password").val()=="")
			$("#password").addClass("input-error");
		if($("#repeat_password").val()=="")
			$("#repeat_password").addClass("input-error");
	}

	if(inputError==true)
	{
		$(".info_message").addClass("info-error");
		if(inputErrorUsername==true)
			$("#username").addClass("input-error");
		if(inputErrorEmail==true)
			$("#email").addClass("input-error");
		if(inputErrorPassword==true)
			$("#password, #repeat_password").addClass("input-error");
	}

	if(inputEmpty==false && inputError==false)
	{
		$(".info_message").addClass("info-ok");
		$(".input-register").val("");
		grecaptcha.reset();
	}

</script>