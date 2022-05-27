<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Conexion = "localhost";
$database_Conexion = "db_torneo";
$username_Conexion = "root";
$password_Conexion = "crls-304";
$Conexion = mysql_pconnect($hostname_Conexion, $username_Conexion, $password_Conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
?>