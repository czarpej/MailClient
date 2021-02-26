<?php

$db_addres='localhost';
$db_login='root';
$db_password='';
$db_table='ajax';

$connect=new mysqli($db_addres, $db_login, $db_password, $db_table);
mysqli_report(MYSQLI_REPORT_STRICT);