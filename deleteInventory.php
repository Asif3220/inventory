<?php
require_once('auth.php');
include('db.php');

try 
{
	$isDeleted = 0;
	$id_value = $_GET['id'];

if(!empty($id_value)){
	$product_image_path = "";
	//echo "<br>selectInvSql ".
	$selectInvSql = "SELECT product_image FROM inventory WHERE id=:id_value";
	$selectInvSqlStatement = $myMySQLPDOCon->prepare($selectInvSql);
	$selectInvSqlParameter = array("id_value"=>$id_value);
	
	//echo "<br>selectInvSqlParameter<pre>";
	//print_r($selectInvSqlParameter);
	
	$selectInvSqlStatement->execute($selectInvSqlParameter);
	$inventoryRecords = array();
	$inventoryRecords = $selectInvSqlStatement->fetchAll();
	
	if(count($inventoryRecords)>0){
		//echo "<br>product_image_path ".
		$product_image_path = $inventoryRecords[0]["product_image"];
		if(!empty($product_image_path)){
			unlink($product_image_path);
		}
	}
	
	//echo "<br>deleteInvSql ".
	$deleteInvSql = "DELETE FROM inventory WHERE id=:id_value";
	$deleteInvSqlStatement = $myMySQLPDOCon->prepare($deleteInvSql);
	$deleteInvSqlParameter = array("id_value"=>$id_value);
	
	//echo "<br>deleteInvSqlParameter<pre>";
	//print_r($deleteInvSqlParameter);
		
	$deleteInvSqlStatement->execute($deleteInvSqlParameter);
	
	//echo "<br>isDeleted ".
	$isDeleted = $deleteInvSqlStatement->rowCount();
	
		//echo '<br><br> errorCode : '.$deleteInvSqlStatement->errorCode();

		$errors = $deleteInvSqlStatement->errorInfo();
		//echo '<br><br> errorInfo :<br><pre> ';
		//print_r($errors);
		
		if(count($errors)>0 && count($errors)==3 && (strpos($errors[2], "Cannot delete or update a parent row: a foreign key constraint fails")!==FALSE)){
			header("location:inventory.php?invalid=1&message=".urlencode("Cannot delete as this product is used in the sales order entry! first delete the related sales order entry then delete this product."));
			exit;
		}
		
		
		
	}else{
		//echo "<br> Invalid input";
		header("location:inventory.php?invalid=1&message=".urlencode("Invalid input"));
		exit;
	}
	if($isDeleted>0)
	{
		header("location:inventory.php?delete=1");
		exit;
	}
}
catch(PDOException $e)
{
	//echo '<br><br>exception : '.$e->getMessage();
    header("location:inventory.php?invalid=1&message=".urlencode(" Exception :: ".$e->getMessage()));
    exit;   	
}
catch (Exception $e) 
{
	//echo "General Error: The inventory record could not be deleted.<br>".$e->getMessage();
    header("location:inventory.php?invalid=1&message=".urlencode(" Exception :: ".$e->getMessage()));
    exit;   	
}
?>