<?php

session_start();

$service_error='Sory, service unavailable';

if(isset($_POST['send']))
{
	if(!isset($_POST['message']) || !isset($_POST['to_user']) || !isset($_POST['which_answer']) || !isset($_POST['reply']))
		echo $service_error;
	else
	{
		$inputEmpty=false;
		$sendOk=false;
		$which_answer=$_POST['which_answer'];
		$state=$_POST['state'];

		if(empty($_POST['to_user']) || empty($_POST['which_answer']) || empty($_POST['reply']))
			echo $service_error;
		else if(empty($_POST['message']))
		{
			$inputEmpty=true;
			echo 'You will not can send empty message!';
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
					$message=$connect->real_escape_string($_POST['message']);
					$to_user=$connect->real_escape_string($_POST['to_user']);
					$reply=$connect->real_escape_string($_POST['reply']);
					if(($send=$connect->prepare("INSERT INTO messages VALUES('', ?, ?, now(), ?, 0)")) && ($seen=$connect->prepare("UPDATE messages SET see=1 WHERE id=?")))
					{
						$send->bind_param('isi', $_SESSION['user_id'], $message, $to_user);
						$seen->bind_param('i', $reply);
						if($send->execute() && $seen->execute())
						{
							echo 'Sending..';
							$sendOk=true;
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
				echo $service_error;
			}
		}
	}
}
else
	echo $service_error;

?>

<script>

	var inputEmpty="<?php echo $inputEmpty; ?>";
	var sendOk="<?php echo $sendOk; ?>";
	var which_answer="<?php echo $which_answer; ?>";
	var state="<?php echo $state; ?>";
	var form=$(".messages").find("#"+which_answer).parent();

	form.find(".info").removeClass("info-error info-ok");
	form.find("#message").removeClass("input-error").on("keydown", function() {
		$(this).removeClass("input-error");
	}).on("change", function() {
		$(this).removeClass("input-error");
	});

	if(inputEmpty==true)
	{
		form.find("#message").addClass("input-error");
		form.find(".info").addClass("info-error");
	}

	if(sendOk==false)
	{
		form.find(".info").addClass("info-error");
	}

	if(inputEmpty==false && sendOk==true)
	{
		$(":button").prop("disabled", true);
		form.find(".info").addClass("info-ok");
		form.find("#message").removeClass("input-error");
		if(state!="read_messages")
		{
			setTimeout(function() {
				form.parent().parent().slideUp(1000, function() {
					$(this).remove();
				});
				form.parent().parent().prev().find(".inner-message").slideUp(1000, function() {
					$(this).remove();
				});
				form.parent().parent().prev().find(".message-info").slideDown(1000).parent().delay(5000).slideUp(1000, function() {
					$(this).remove();
				});
				$(":button").prop("disabled", false);
			}, 1000);
			
		}
		else
		{
			setTimeout(function() {
				form.find(".info").removeClass('info-ok').html("Answer has been sent.");
				form.find("#message").val("");
				$(":button").prop("disabled", false);
			}, 1200);
			setTimeout(function() {
				form.parent().parent().slideUp(1000);
			}, 5200);
		}
	}

</script>