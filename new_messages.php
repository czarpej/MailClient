<?php

@session_start(); //wywala błąd, że sesja aktywna -> poprawić

require_once 'dbconnect.php';
try
{
	if($connect->connect_errno!=0)
		throw new Exception($connect->error);
	else
	{
		if($messages=$connect->query("SELECT `messages`.`id`, `messages`.`from_user`, `messages`.`see`, `messages`.`message`, `messages`.`date`, `login_data`.`login` FROM login_data, messages  WHERE `messages`.`to_user`='".$_SESSION['user_id']."' AND `messages`.`see`=false AND `messages`.`from_user`=`login_data`.`id` ORDER BY date DESC "))
		{
			if($messages->num_rows>0)
			{
				$i=0;
				while($messages_results=$messages->fetch_assoc())
				{
					echo '
					<div class="message">
						<p class="message-info">Answer has been sent.</p>
						<div class="inner-message">
							<div class="message-date">
								<b>Message received:</b><br> '.$messages_results['date'].'
							</div>
							<p><b>From:</b> '.$messages_results['login'].'</p>
							<div class="message-content"><b>Message:</b><div class="message-content-inner">'.$messages_results['message'].'</div></div>
							<div class="message-option">
								<button value="answer" type="button">Answer</button>
								<form method="post">
									<input type="hidden" class="next_message" id="which_message'.$i.'" value="This element can not be will remove!"> 
									<input type="hidden" id="message_id" value="'.$messages_results['id'].'">
									<span class="delete-info">info</span>
									<button value="delete">Delete</button>
								</form>
								<form method="post">
									<input type="hidden" class="next_message" id="which_message_tag'.$i.'" value="This element can not be will remove!"> 
									<input type="hidden" id="message_id" value="'.$messages_results['id'].'">
									<span class="changing-info">info</span>
									<button value="read" class="changing">Mark as read</button>
								</form>
							</div>
						</div>
					</div>
					<div class="answer">
						<div class="answer-inner">
							<form method="post" id="form-answer">
								<input type="hidden" class="next" id="which_answer'.$i.'" value="When you remove this element, page engine will not work!">
								<input type="hidden" id="to_user" value="'.$messages_results['from_user'].'">
								<input type="hidden" id="reply" value="'.$messages_results['id'].'">
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
				echo '<p>You have not got any new messages.</p>';
		}
	}
}
catch(Exception $e)
{
	echo 'Sory, service unavailable.';
}

require_once 'answer_action.html';
require_once 'buttons_actions.html';

?>

<script>
	
	action("new_messages");

</script>