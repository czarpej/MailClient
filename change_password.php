<?php

session_start();

if(isset($_POST['change']))
{
	if(!isset($_POST['actual_password']) || !isset($_POST['new_password']) || !isset($_POST['repeat_password']))
		echo 'Sory, service unavailable.';
	else
	{
		$inputEmpty=false;
		$inputError=false;

		if(empty($_POST['actual_password']) || empty($_POST['new_password']) || empty($_POST['repeat_password']))
		{
			echo 'You must fill all fields!';
			$inputEmpty=true;
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
					$actual_password=$connect->real_escape_string($_POST['actual_password']);
					$new_password=$connect->real_escape_string($_POST['new_password']);
					$repeat_password=$connect->real_escape_string($_POST['repeat_password']);
					if($new_password!==$repeat_password)
					{
						echo 'New passwords do not match!';
						$inputError=true;
					}
					else
					{
						if($pass_to_change=$connect->query("SELECT password FROM login_data WHERE id='".$_SESSION['user_id']."' "))
						{
							if($pass_to_change->num_rows>0)
							{
								$PassToChange=$pass_to_change->fetch_row();
								if(!password_verify($actual_password, $PassToChange[0]))
								{
									echo 'Actual password is not correct!';
									$inputError=true;
								}
								else
								{
									if($changing_pass=$connect->prepare("UPDATE login_data SET password=? WHERE id='".$_SESSION['user_id']."' "))
									{
										$changing_pass->bind_param('s', password_hash($new_password, PASSWORD_DEFAULT));
										if($changing_pass->execute())
										{
											echo 'Password has been changed complite.';
										}
										else
											throw new Exception($connect->error);
									}
									else
										throw new Exception($connect->error);
								}
							}
							else
								throw new Exception($connect->error);
						}
						else
							throw new Exception($connect->error);
					}
				}
			}
			catch(Exception $e)
			{
				echo 'Sory, service unavailable.';
			}
		}
	}
}
else
{
	echo 'Sory, service unavailable.';
	exit();
}

?>

<script>

	var inputError="<?php echo $inputError; ?>";
	var inputEmpty="<?php echo $inputEmpty; ?>";

	$(".info").removeClass("info-ok info-error");
	$("#actual-pass, #new-pass, #repeat-pass").removeClass("input-error").on("change", function() {
		$(this).removeClass("input-error");
	}).on("keydown", function() {
		$(this).removeClass("input-error");
	});

	if(inputEmpty==true)
	{
		if($("#actual-pass").val()=="")
			$("#actual-pass").addClass("input-error");
		if($("#new-pass").val()=="")
			$("#new-pass").addClass("input-error");
		if($("#repeat-pass").val()=="")
			$("#repeat-pass").addClass("input-error");
		$(".info").addClass("info-error");
	}

	if(inputError==true)
	{
		$(".info").addClass("info-error");
	}

	if(inputEmpty==false && inputError==false)
	{
		$(".pass_to_change").val("");
		$(".info").addClass("info-ok");
	}

</script>