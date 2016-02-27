<?php

require_once('auth.php');
include('db.php');

//echo "<br>_REQUEST<pr>";
//print_r($_REQUEST);

//echo "<br>_FILES<pr>";
//print_r($_FILES);

function updateMasterInventoryStock($sku_value, $quantity_value, $act) {
    global $myMySQLPDOCon;
    $lastMasterInsertId = 0;
    $isMasterUpdated = 0;
    $added_date_value = date('Y-m-d H:i:s');
    if ($act == "insert") {
        //echo "<br>insertInvMasterSql ".
        $insertInvMasterSql = "INSERT INTO master_inventory SET sku=:sku_value, stock=:quantity_value, added_date=:added_date_value";
        $insertInvMasterSqlStatement = $myMySQLPDOCon->prepare($insertInvMasterSql);
        $insertInvMasterSqlParameter = array("sku_value" => $sku_value, "quantity_value" => $quantity_value, "added_date_value" => $added_date_value);
        $insertInvMasterSqlStatement->execute($insertInvMasterSqlParameter);
        
            //echo "<br>insertInvMasterSqlStatement<pre>";
            //print_r($insertInvMasterSqlStatement);        

        //echo "<br>lastMasterInsertId ".
        $lastMasterInsertId = $myMySQLPDOCon->lastInsertId();
        return $lastMasterInsertId;
    } else if ($act == "update") {
        //echo "<br>updateInvMasterSql ".
        $insertInvMasterSql = "UPDATE master_inventory SET stock=:quantity_value, modified_date	=:added_date_value WHERE sku=:sku_value";
        $insertInvMasterSqlStatement = $myMySQLPDOCon->prepare($insertInvMasterSql);
        $insertInvMasterSqlParameter = array("quantity_value" => $quantity_value, "sku_value" => $sku_value, "added_date_value" => $added_date_value);
        $insertInvMasterSqlStatement->execute($insertInvMasterSqlParameter);

        //echo "<br>insertInvMasterSqlStatement<pre>";
        //print_r($insertInvMasterSqlStatement);  
                
        //echo "<br>isMasterUpdated ".
        $isMasterUpdated = ($insertInvMasterSqlStatement->errorCode()>0)?0:1; 
        return $isMasterUpdated;
    }
}

try {
    $id_value = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
    $lastInsertId = 0;
    $isUpdated = 0;
    $purchase_date = (isset($_REQUEST['purchase_date'])) ? $_REQUEST['purchase_date'] : '';
    $purchase_date_value = date("Y-m-d", strtotime($purchase_date));

	$supplier_id_value = $_POST['supplier_id'];
    $purchase_id_value = $_POST['purchase_id'];
    $sku_value = $_POST['sku'];
    $title_value = $_POST['title'];
    $supplier_value = $_POST['supplier'];
    $cost_price_value = $_POST['cost_price'];
    $quantity_value = $_POST['quantity'];
    $total_cost_value = $_POST['total_cost'];
    $status_value = (isset($_POST['status'])) ? $_POST['status'] : 1;
    $date_added_value = date('Y-m-d H:i:s');
    $saved_file = "";

    if (isset($_FILES['product_image']) && $_FILES['product_image']['size']>0) {
        $errors = "";
        $file_name = $_FILES['product_image']['name'];
        $file_size = $_FILES['product_image']['size'];
        $file_tmp = $_FILES['product_image']['tmp_name'];
        $file_type = $_FILES['product_image']['type'];
        //$file_ext = strtolower(end(explode('.', $_FILES['product_image']['name'])));
        $file_ext = "";
        $file_ext_temp = explode(".", strtolower($_FILES['product_image']['name']));
        if(count($file_ext_temp)>0){            
            //echo "<br>file_ext_temp<pre>";
            //print_r($file_ext_temp);
            
            if(count($file_ext_temp)==3){
                $file_ext = $file_ext_temp[2];
            }elseif(count($file_ext_temp)==2){            
                $file_ext = $file_ext_temp[1];
            }
            //echo "<br>file_ext ".$file_ext;
        }
        
        $extensions = array("gif", "jpeg", "jpg", "png", "GIF", "JPG", "JPEG" , "PNG");
        
        //echo "<br>in_array ".in_array($file_ext, $extensions);
        
        if (in_array($file_ext, $extensions) === false) {
            //echo "<br>".
            $errors = "extension not allowed, please choose a GIF, JPEG or PNG file.";
            header("location:inventory.php?invalid=1&message=".urlencode($errors));
            exit;
        }

        if ($file_size > 2097152) {
            //echo "<br>".
            $errors = 'File size must be within 2 MB';
            header("location:inventory.php?invalid=1&message=".urlencode($errors));
            exit;            
        }

        if (empty($errors) == true) {
            $saved_file = "product_images/" . $file_name;
            move_uploaded_file($file_tmp, $saved_file);
            //echo "Success";
        } else {
            //print_r($errors);
        }
    }
    $product_image_value = "";
    if (!empty($saved_file)) {
        $product_image_value = $saved_file;
    }


//echo "<br>_SESSION<pr>";
//print_r($_SESSION);


    if (!empty($purchase_date_value) && !empty($sku_value) && !empty($title_value) && !empty($supplier_value) && !empty($cost_price_value) && !empty($quantity_value) && !empty($total_cost_value)) {
        if (!empty($id_value)) {
            //echo "<br>updateInvSql ".
            $updateInvSql = "UPDATE inventory SET supplier_id =:supplier_id_value, purchase_date=:purchase_date_value, sku=:sku_value, title=:title_value, 	supplier=:supplier_value, cost_price=:cost_price_value, quantity=:quantity_value, total_cost=:total_cost_value, status=:status_value, date_modified=:date_added_value, product_image=:product_image_value WHERE id=:id_value";
            $updateInvSqlStatement = $myMySQLPDOCon->prepare($updateInvSql);
            $updateInvSqlParameter = array("supplier_id_value" => $supplier_id_value, "purchase_date_value" => $purchase_date_value, "sku_value" => $sku_value, "title_value" => $title_value, "supplier_value" => $supplier_value, "cost_price_value" => $cost_price_value, "quantity_value" => $quantity_value, "total_cost_value" => $total_cost_value, "status_value" => $status_value, "date_added_value" => $date_added_value, "product_image_value" => $product_image_value, "id_value" => $id_value);
            $updateInvSqlStatement->execute($updateInvSqlParameter);
            
            //echo "<br>updateInvSqlParameter<pre>";
            //print_r($updateInvSqlParameter);

            //echo "<br>isUpdated ".
            $isUpdated = $updateInvSqlStatement->rowCount();
        } else {
            //echo "<br>insertInvSql ".
            $insertInvSql = "INSERT INTO inventory SET purchase_id=:purchase_id_value, supplier_id =:supplier_id_value, purchase_date=:purchase_date_value, sku=:sku_value, title=:title_value,supplier=:supplier_value, cost_price=:cost_price_value, quantity=:quantity_value, total_cost=:total_cost_value, status=:status_value, date_added=:date_added_value,product_image=:product_image_value";
            $insertInvSqlStatement = $myMySQLPDOCon->prepare($insertInvSql);
            $insertInvSqlParameter = array("purchase_id_value" => $purchase_id_value, "supplier_id_value" => $supplier_id_value, "purchase_date_value" => $purchase_date_value, "sku_value" => $sku_value, "title_value" => $title_value, "supplier_value" => $supplier_value, "cost_price_value" => $cost_price_value, "quantity_value" => $quantity_value, "total_cost_value" => $total_cost_value, "status_value" => $status_value, "date_added_value" => $date_added_value, "product_image_value" => $product_image_value);
            $insertInvSqlStatement->execute($insertInvSqlParameter);

            //echo "<br>insertInvSqlParameter<pre>";
            //print_r($insertInvSqlParameter);
            
            //echo "<br>lastInsertId ".
            $lastInsertId = $myMySQLPDOCon->lastInsertId();
        }
    } else {
        header("location:inventory.php?invalid=1");
        exit;
    }
    $isUpdatedMaster = 0;
    if ($lastInsertId > 0) {
        $isUpdatedMaster = updateMasterInventoryStock($sku_value, $quantity_value, "insert");
        if($isUpdatedMaster>0){
            header("location:inventory.php?insert=1");
            exit;
        }else{
            header("location:inventory.php?invalid=1&message=".urlencode(" Exception :: master inventory stock not inserted!")); 
            exit;
        }

    }
    if ($isUpdated > 0) {
        $isUpdatedMaster = updateMasterInventoryStock($sku_value, $quantity_value, "update");
        if($isUpdatedMaster>0){
            header("location:inventory.php?update=1");
            exit;
        }else{
            header("location:inventory.php?invalid=1&message=".urlencode(" Exception :: master inventory stock not updated!")); 
            exit;
        }
    }
} catch (PDOException $e) {
    //echo '<br><br>exception : ' . $e->getMessage();
    header("location:inventory.php?invalid=1&message=".urlencode(" Exception :: ".$e->getMessage()));
    exit;        
} catch (Exception $e) {
    //echo "General Error: The inventory record could not be added.<br>" . $e->getMessage();
    header("location:inventory.php?invalid=1&message=".urlencode(" Exception :: ".$e->getMessage()));
    exit;      
}
?>