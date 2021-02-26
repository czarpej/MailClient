<?php

$service_error='Sory, service unavailable.';
$change_ok=false;

if(isset($_POST['tag']))
{
	if(empty($_POST['tag']))
		echo $service_error;
	else
	{
		if(!isset($_POST['id_message']) || empty($_POST['id_message']) || !isset($_POST['which_message_tag']) || empty($_POST['which_message_tag']))
			echo $service_error;
		else
		{
			$tag=$_POST['tag'];
			$which_message_tag=$_POST['which_message_tag'];
			$state=0;
			require_once 'dbconnect.php';
			try
			{
				if($connect->connect_errno!=0)
					throw new Exception($connect->error);
				else
				{	
					if($tag=="read")
						$state=1;
					$id_message=$connect->real_escape_string($_POST['id_message']);
					if($change=$connect->prepare("UPDATE messages SET see=? WHERE id=?"))
					{
						$change->bind_param('ii', $state, $id_message);
						if($change->execute())
						{
							$change_ok=true;
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

	var tag="<?php echo $tag; ?>";
	var change_ok="<?php echo $change_ok; ?>";
	var which_message_tag="<?php echo $which_message_tag; ?>";
	var form=$(".messages").find("#"+which_message_tag).parent();

	$(":button").prop("disabled", true);
	form.parent().parent().parent().next().slideUp(1000);

	form.find("button").slideUp(500, function() {
		$(this).prev().html("Changing..");
		$(this).prev().slideDown(500);
	});

	if(change_ok==true)
	{
		setTimeout(function() {
			form.parent().parent().slideUp(1000).parent().find(".message-info").html("Message has been tagged as "+tag+".").slideDown(1000);
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