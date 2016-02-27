<?php

require_once('auth.php');
include('db.php');

try {
    $id_value = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
    $lastInsertId = 0;
    $isUpdated = 0;
    $sale_date = (isset($_REQUEST['sale_date'])) ? $_REQUEST['sale_date'] : '';
    $sale_date_value = date("Y-m-d", strtotime($sale_date));

	$sale_id_value = $_POST['sale_id'];
    $sku_value = $_POST['sku'];
    $title_value = $_POST['title'];
    $supplier_value = $_POST['supplier'];
    $cost_price_value = $_POST['cost_price'];
    $quantity_value = $_POST['quantity_purchased'];
    $sale_price_value = $_POST['sale_price'];
    $profit_retained_value = $_POST['profit_retained'];
    $status_value = (isset($_POST['status'])) ? $_POST['status'] : 1;
    $date_added_value = date('Y-m-d H:i:s');

    if (!empty($sale_date_value) && !empty($sku_value) && !empty($title_value) && !empty($supplier_value) && !empty($cost_price_value) && !empty($quantity_value) && !empty($sale_price_value) && !empty($profit_retained_value)) {

        if (!empty($id_value)) {
            $updateInvSql = "UPDATE sales SET sale_date=:sale_date_value, sku=:sku_value, title=:title_value, 	supplier=:supplier_value, cost_price=:cost_price_value, quantity_purchased=:quantity_value, sale_price=:sale_price_value, profit_retained=:profit_retained_value, status=:status_value, date_modified=:date_modified_value WHERE id=:id_value";
            $updateInvSqlStatement = $myMySQLPDOCon->prepare($updateInvSql);
            $updateInvSqlParameter = array("sale_date_value" => $sale_date_value, "sku_value" => $sku_value, "title_value" => $title_value, "supplier_value" => $supplier_value, "cost_price_value" => $cost_price_value, "quantity_value" => $quantity_value, "sale_price_value" => $sale_price_value, "profit_retained_value" => $profit_retained_value, "status_value" => $status_value, "date_modified_value" => $date_added_value, "id_value" => $id_value);
            $updateInvSqlStatement->execute($updateInvSqlParameter);

            $isUpdated = $updateInvSqlStatement->rowCount();
        } else {
            $insertInvSql = "INSERT INTO sales SET sale_id=:sale_id_value, sale_date=:sale_date_value, sku=:sku_value, title=:title_value, supplier=:supplier_value, cost_price=:cost_price_value, quantity_purchased=:quantity_value, sale_price=:sale_price_value, profit_retained=:profit_retained_value, status=:status_value, date_added=:date_added_value";
            $insertInvSqlStatement = $myMySQLPDOCon->prepare($insertInvSql);
            $insertInvSqlParameter = array("sale_id_value" => $sale_id_value, "sale_date_value" => $sale_date_value, "sku_value" => $sku_value, "title_value" => $title_value, "supplier_value" => $supplier_value, "cost_price_value" => $cost_price_value, "quantity_value" => $quantity_value, "sale_price_value" => $sale_price_value, "profit_retained_value" => $profit_retained_value, "status_value" => $status_value, "date_added_value" => $date_added_value);

            $insertInvSqlStatement->execute($insertInvSqlParameter);
            
            $lastInsertId = $myMySQLPDOCon->lastInsertId();      
        }
    } else {
        //echo "<br> Invalid input";
		header("location:sales.php?invalid=1&message=".urlencode(" Invalid input "));
		exit; 
    }

	if (($lastInsertId > 0) || ($isUpdated > 0)){
		$updateInvSql = "UPDATE master_inventory SET stock=stock-:quantity_value WHERE sku=:sku_value";
		$updateInvSqlStatement = $myMySQLPDOCon->prepare($updateInvSql);
		$updateInvSqlParameter = array("quantity_value"=>$quantity_value, "sku_value"=>$sku_value);
		$updateInvSqlStatement->execute($updateInvSqlParameter);
		$updateInvSqlStatement->rowCount();
	}

    if ($lastInsertId > 0) {
	
        header("location:sales.php?insert=1");
        exit;
    }
    if ($isUpdated > 0) {
        header("location:sales.php?update=1");
        exit;
    }
} catch (PDOException $e) {
    //echo '<br><br>exception : ' . $e->getMessage();
    header("location:sales.php?invalid=1&message=".urlencode(" Exception :: ".$e->getMessage()));
    exit;  		
} catch (Exception $e) {
    //echo "General Error: The sales record could not be added.<br>" . $e->getMessage();
    header("location:sales.php?invalid=1&message=".urlencode(" Exception :: ".$e->getMessage()));
    exit;  	
}
?>