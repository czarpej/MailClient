<?php

session_start();

$service_error='Sory, service unavailable.';
$delete_ok=true;

if(isset($_POST['delete']))
{
	$which_message=$_POST['which_message'];
	if(!isset($_POST['which_message']) || !isset($_POST['id_message']))
	{
		echo $service_error;
		$delete_ok=false;
	}
	else if(empty($_POST['which_message']) || empty($_POST['id_message']))
	{
		echo $service_error;
		$delete_ok=false;
	}
	else
	{
		require_once 'dbconnect.php';
		try
		{
			if($connect->connect_errno!=0)
			{
				$delete_ok=false;
			}
			else
			{
				$id_message=$connect->real_escape_string($_POST['id_message']);

				if($delete=$connect->prepare("DELETE FROM messages WHERE id=?"))
				{
					$delete->bind_param('i', $id_message);
					if($delete->execute())
						;
					else
					{
						$delete_ok=false;
					}
				}
				else
				{
					$delete_ok=false;
				}
			}
		}
		catch(Exception $e)
		{
			echo $service_error;
			$delete_ok=false;
		}
	}
}
else
{
	echo $service_error;
	$delete_ok=false;
}

?>

<script>

	var delete_ok="<?php echo $delete_ok; ?>";
	var which_message="<?php echo $which_message; ?>";
	var form=$(".messages").find("#"+which_message).parent();

	$(":button").prop("disabled", true);
	form.parent().parent().parent().next().slideUp(1000);

	form.find("button").slideUp(500, function() {
		$(this).prev().html("Deleting..");
		$(this).prev().slideDown(500);
	});

	if(delete_ok==true)
	{
		setTimeout(function() {
			form.parent().parent().slideUp(1000).parent().find(".message-info").html("Message has been deleted.").slideDown(1000);
			setTimeout(function() {
				form.parent().parent().parent().slideUp(1000, function() {
					$(this).next().remove();
					$(this).remove();
				});
			}, 5000);
			$(":button").prop("disabled", false);
		}, 1300);
	}
	else
	{
		setTimeout(function() {
			form.parent().parent().slideUp(1000).parent().find(".message-info").html("Sory, service unavailable.").slideDown(1000);
			setTimeout(function() {
				form.find("span").css({
					"display": "none"
				});
				form.find("button").css({
					"display": "block"
				});
				form.parent().parent().prev().slideUp(1000);
				form.parent().parent().slideDown(1000);
			}, 5000);
			$(":button").prop("disabled", false);
		}, 1300);
	}

</script>