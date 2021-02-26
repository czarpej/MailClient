<?php

session_start();

echo '
<div class="logging_user">
	<div class="logout"><form id="form_logout"><button id="logout">Logout</button></form></div>
	<div class="content">	
		<div class="messages-div">
			<div class="messages-info">
				<h3>Messages to you:</h3>
				<button class="read-messages-button" id="read-messages-button">Read messages</button>
			</div>
			<div id="messages-old" style="display: none;"></div>
			<div class="messages">';
				
				require_once 'new_messages.php';

			echo '</div>
		</div>
		<div class="manage">
			<h3>Your accout:</h3>
			<button type="button" id="change">Change password</button>
			<button type="button" id="remove">Remove account</button>
			<div class="changes">
				<div class="changes2">
					content
				</div>
			</div>
		</div>
	</div>
</div>
';

require_once 'slide_manage_account.html';

?>

<script>
	$("#form_logout").submit(function(event) {
		event.preventDefault();
		$("#logout").load("logout.php", {
			logout: $("#logout").val()
		});
	});
	$(".container").css({
		"padding": "10px 30px"
	});

	var messages="";
	var messages_read=false;
	function change_see_messages(h3_html, button_html)
	{
		$(".messages").animate({
			opacity: 0
		}, 1000, function() {
			$(this).animate({
				opacity: 1
			}, 1000);
		});
		$("#read-messages-button").parent().find("h3").animate({
			opacity: 0
		}, 1000, function() {
			$(this).html(h3_html+":").animate({
				opacity: 1
			}, 1000);
		});
		$("#read-messages-button").animate({
			opacity: 0
		}, 1000, function() {
			$(this).html(button_html).animate({
				opacity: 1
			}, 1000);
		});
	}
	$("#read-messages-button").on("click", function() {
		if(messages_read==false)
		{
			let h3="Read messages";
			let button="New messages";
			change_see_messages(h3, button);
			messages_read=true;
			setTimeout(function() {
				$(".messages").load("read_messages.php", {
					archive: "archive_messages"
				});
			}, 1000);
			
		}
		else
		{
			let h3="Messages to you";
			let button="Read messages";
			change_see_messages(h3, button);
			messages_read=false;
			setTimeout(function() {
				$(".messages").load("new_messages.php", {
					archive: "archive_messages"
				});
			}, 1000); 
		}
	});
</script>