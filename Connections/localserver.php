<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_localserver = "localhost";
$database_localserver = "ikutan";
$username_localserver = "root";
$password_localserver = "";
$localserver = mysql_pconnect($hostname_localserver, $username_localserver, $password_localserver) or trigger_error(mysql_error(),E_USER_ERROR); 
?>