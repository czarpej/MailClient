<?php

session_start(); //brak powoduje przy przełączeniu na new_messages.php warning o undefined _SESSION

$service_info="Sory, service unavailable.";

if(isset($_POST['archive']))
{
	require_once 'dbconnect.php';
	try
	{
		if($connect->connect_errno!=0)
			throw new Exception($connect->error);
		else
		{
			if($messages_old=$connect->query("SELECT `messages`.`id`, `messages`.`from_user`, `messages`.`see`, `messages`.`message`, `messages`.`date`, `login_data`.`login` FROM login_data, messages  WHERE `messages`.`to_user`='".$_SESSION['user_id']."' AND `messages`.`see`=true AND `messages`.`from_user`=`login_data`.`id` ORDER BY date DESC "))
			{
				if($messages_old->num_rows>0)
				{
					$i=0;
					while($messages_old_result=$messages_old->fetch_assoc())
					{
						echo '
						<div class="message">
							<p class="message-info">Answer has been sent.</p>
							<div class="inner-message">
								<div class="message-date">
									<b>Message received:</b><br> '.$messages_old_result['date'].'
								</div>
								<p><b>From:</b> '.$messages_old_result['login'].'</p>
								<div class="message-content"><b>Message:</b><div class="message-content-inner">'.$messages_old_result['message'].'</div></div>
								<div class="message-option">
									<button value="answer">Answer</button>
									<form method="post">
										<input type="hidden" class="next_message" id="which_message'.$i.'" value="This element can not be will remove!"> 
										<input type="hidden" id="message_id" value="'.$messages_old_result['id'].'">
										<span class="delete-info">info</span>
										<button value="delete">Delete</button>
									</form>
									<form method="post">
										<input type="hidden" class="next_message" id="which_message_tag'.$i.'" value="This element can not be will remove!"> 
										<input type="hidden" id="message_id" value="'.$messages_old_result['id'].'">
										<span class="changing-info">info</span>
										<button value="unread" class="changing">Mark as unread</button>
									</form>
								</div>
							</div>
						</div>
						<div class="answer">
							<div class="answer-inner">
								<form method="post" id="form-answer">
									<input type="hidden" class="next" id="which_answer'.$i.'" value="When you remove this element, page engine will not work!">
									<input type="hidden" id="to_user" value="'.$messages_old_result['from_user'].'">
									<input type="hidden" id="reply" value="'.$messages_old_result['id'].'">
									<textarea placeholder="Your answer" id="message"></textarea><br>
									<button id="message-send">Send</button>
									<p class="info">info</p>
								</form>
							</div>
						</div>';
						$i++;
					}
				}
				else
					echo 'You have not got any read message.';
			}
			else
				throw new Exception($connect->error);
		}
	}
	catch(Exception $e)
	{
		echo $service_info;
	}
}
else
	echo $service_info;

require_once 'answer_action.html';
require_once 'buttons_actions.html';

?>

<script>
	
	action("read_messages");

</script>