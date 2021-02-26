<?php

session_start();

if(isset($_POST['remove']))
{
	if(!isset($_POST['actual_password']))
	{
		echo 'Sory, service unavailable.';
		exit();
	}
	else
	{
		$inputEmpty=false;
		$inputError=false;
		if(empty($_POST['actual_password']))
		{
			echo 'You must fill password field!';
			$inputEmpty=true;
		}
		else
		{
			require_once 'dbconnect.php';
			try
			{
				if($connect->connect_erno!=0)
					throw new Exception($connect->error);
				else
				{
					$pass=$connect->real_escape_string($_POST['actual_password']);
					if($actual_password=$connect->query("SELECT password FROM login_data WHERE id='".$_SESSION['user_id']."' "))
					{
						if($actual_password->num_rows>0)
						{
							$actual_password_results=$actual_password->fetch_row();
							if(!password_verify($pass, $actual_password_results[0]))
							{
								echo 'Password is wrong!';
								$inputError=true;
							}
							else
							{
								if($connect->query("DELETE FROM login_data WHERE id='".$_SESSION['user_id']."' "))
								{
									echo 'Removing..';
									session_destroy();
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

	var inputEmpty="<?php echo $inputEmpty; ?>";
	var inputError="<?php echo $inputError; ?>";

	$(".info").removeClass("info-ok info-error");
	$("#pass-to-confirm").removeClass("input-error");

	if(inputEmpty==true)
	{
		$("#pass-to-confirm").addClass("input-error").on("change", function() {
			$(this).removeClass("input-error");
		}).on("keydown", function() {
			$(this).removeClass("input-error");
		});
		$(".info").addClass("info-error");
	}

	if(inputError==true)
	{
		$(".info").addClass("info-error");
	}

	if(inputEmpty==false && inputError==false)
	{
		$(".info").addClass("info-ok");
		return_index("index_content.html");
	}

</script>