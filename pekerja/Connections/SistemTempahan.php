<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_SistemTempahan = "localhost";
$database_SistemTempahan = "sistem_e-tempahan_hot_printing";
$username_SistemTempahan = "root";
$password_SistemTempahan = "";
$SistemTempahan = mysql_pconnect($hostname_SistemTempahan, $username_SistemTempahan, $password_SistemTempahan) or trigger_error(mysql_error(),E_USER_ERROR); 
?>