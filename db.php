<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "inventory";

//$mysql_hostname = "remote-mysql3.servage.net";
//$mysql_user = "scapewebdb";
//$mysql_password = "prince111x";
//$mysql_database = "scapewebdb";

try {
    $myMySQLPDOCon = new PDO("mysql:host=" . $mysql_hostname . ";dbname=" . $mysql_database, $mysql_user, $mysql_password);
} catch (Exception $e) {
    echo "Database connection error :: " . $e->getMessage();
}
?>