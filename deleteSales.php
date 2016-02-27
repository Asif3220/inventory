<?php
require_once('auth.php');
include('db.php');

try 
{
	$isDeleted = 0;
	$id_value = $_GET['id'];

if(!empty($id_value)){
	$deleteInvSql = "DELETE FROM sales WHERE id=:id_value";
	$deleteInvSqlStatement = $myMySQLPDOCon->prepare($deleteInvSql);
	$deleteInvSqlParameter = array("id_value"=>$id_value);
	$deleteInvSqlStatement->execute($deleteInvSqlParameter);
	
	$isDeleted = $deleteInvSqlStatement->rowCount();
	}else{
		echo "<br> Invalid input";
	}
	if($isDeleted>0)
	{
		header("location:sales.php?delete=1");
		exit;
	}
}
catch(PDOException $e)
{
	echo '<br><br>exception : '.$e->getMessage();
}
catch (Exception $e) 
{
	echo "General Error: The sales record could not be deleted.<br>".$e->getMessage();
}
?>