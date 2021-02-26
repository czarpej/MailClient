<?php

session_start();

if(isset($_POST['log_in']))
{
	if(isset($_POST['login']) && isset($_POST['password']))
	{
		$inputEmpty=false;
		$inputError=false;

		if(!empty($_POST['login']) && !empty($_POST['password']))
		{
			require_once 'dbconnect.php';
			try
			{
				if($connect->connect_errno!=0)
					throw new Exception($connect->error);
				else
				{
					$login=$connect->real_escape_string($_POST['login']);
					$password=$connect->real_escape_string($_POST['password']);
					if($login_ok=$connect->prepare("SELECT id, password FROM login_data WHERE login=?"))
					{
						$login_ok->bind_param('s', $login);
						if($login_ok->execute())
						{
							$result=$login_ok->get_result();
							if($result->num_rows>0)
							{
								$login_ok_results=$result->fetch_assoc();
								if(!password_verify($password, $login_ok_results['password']))
								{
									echo 'Error login data!';
									$inputError=true;
								}
								else
								{
									echo 'Logging..';
									$_SESSION['login_now']=true;
									$_SESSION['user_id']=$login_ok_results['id'];
								}
							}
							else
							{
								echo 'Error login data!';
								$inputError=true;
							}
						}
						else
							throw new Exception($connect->error);
					}
					else
						throw new Exception($connect->error);
				}
			}
			catch(Exception $e)
			{
				echo 'Sory, service unavailable.';
			}
		}
		else
		{
			echo 'You must fill required (<span class="required" style="margin: 0;">*</span>) fields!';
			$inputEmpty=true;
		}
	}
	else
	{
		echo 'Sory, service unavailable.';
		exit();
	}
}
else
{
	echo 'Sory, service unavailable.';
	exit();
}

?>

<script>

	$("#login, #password").removeClass("input-error").on("change", function() {
		$(this).removeClass("input-error");
	}).on("keydown", function() {
		$(this).removeClass("input-error");
	});
	$(".info_message").removeClass("info-error info-ok");

	var inputEmpty="<?php echo $inputEmpty; ?>";
	var inputError="<?php echo $inputError; ?>";

	if(inputEmpty==true)
	{
		if($("#login").val()=='')
			$("#login").addClass("input-error");
		if($("#password").val()=='')
			$("#password").addClass("input-error");
		$(".info_message").addClass("info-error");
	}

	if(inputError==true)
	{
		$(".info_message").addClass("info-error");
	}

	if(inputError==false && inputEmpty==false)
	{
		$("#login, #password").val("");
		$(".info_message").addClass("info-ok");
		return_index("login_ok.php");
	}

</script>