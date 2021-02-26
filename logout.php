<?php

session_start();
$logout_exists=false;
if(isset($_POST['logout']))
{
	$logout_exists=true;
	echo 'Logouting..';
	session_destroy();
}
else
	exit();

?>

<script src="return_index.js"></script>
<script>

	var logout_exists="<?php echo $logout_exists; ?>";

	if(logout_exists==true)
	{
		return_index("index_content.html");
	}

</script>