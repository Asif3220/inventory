<?php
require_once('auth.php');
include('db.php');

try 
{
	$isDeleted = 0;
	$id_value = $_GET['id'];
	
	
$product_image = "";
if(!empty($id_value)){
	$selectInvSql = "SELECT product_image FROM inventory WHERE id=:id_value";
	$selectInvSqlStatement = $myMySQLPDOCon->prepare($selectInvSql);
	$selectInvSqlParameter = array("id_value"=>$id_value);
	$selectInvSqlStatement->execute($selectInvSqlParameter);
	$inventoryRecords = array();
	$inventoryRecords = $selectInvSqlStatement->fetchAll();
	
	if(count($inventoryRecords)>0){
		$product_image = $inventoryRecords[0]["product_image"];
		if(!empty($product_image)){
			if (!unlink($product_image))
			{
				//echo ("Error deleting $product_image");
			}
			else
			{
				//echo ("Deleted $product_image");
			}
		}
	
		$deleteInvSql = "UPDATE inventory SET product_image=NULL WHERE id=:id_value";
		$deleteInvSqlStatement = $myMySQLPDOCon->prepare($deleteInvSql);
		$deleteInvSqlParameter = array("id_value"=>$id_value);
		$deleteInvSqlStatement->execute($deleteInvSqlParameter);
		
		$isDeleted = $deleteInvSqlStatement->rowCount();	
	}	

	}else{
		//echo "<br> Invalid input";
		header("location:inventory.php?invalid=1&message=".urlencode("Invalid input"));
		exit;		
	}
	if($isDeleted>0)
	{
		header("location:inventory.php?update=1");
		exit;
	}
}
catch(PDOException $e)
{
	//echo '<br><br>exception : '.$e->getMessage();
	header("location:inventory.php?invalid=1&message=".urlencode("Exception: ".$e->getMessage()));
	exit;		
}
catch (Exception $e) 
{
	//echo "General Error: The inventory record could not be deleted.<br>".$e->getMessage();
	header("location:inventory.php?invalid=1&message=".urlencode("Exception: ".$e->getMessage()));
	exit;	
}
?>