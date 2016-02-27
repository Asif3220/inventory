<?php

include('db.php');

function getDataFromDb($get_field, $sku) {
    global $myMySQLPDOCon;
    $ret = array();
    $valueToReturn = "";
	
	if ($get_field == "quantity") {
		$selectInvSql2 = "SELECT * FROM master_inventory WHERE sku=:sku_value";
		$selectInvSqlStatement2 = $myMySQLPDOCon->prepare($selectInvSql2);
		$selectInvSqlParameter2 = array("sku_value" => $sku);
		$selectInvSqlStatement2->execute($selectInvSqlParameter2);
		$inventoryRecords2 = array();
		$inventoryRecords2 = $selectInvSqlStatement2->fetchAll(PDO::FETCH_ASSOC);
		
		$valueToReturn = $inventoryRecords2[0]["stock"];
		$ret = array("quantity" => $valueToReturn);	
        $return["json"] = json_encode($ret);
        return json_encode($return);			
	}	
		
    $selectInvSql = "SELECT * FROM inventory WHERE sku=:sku_value";
    $selectInvSqlStatement = $myMySQLPDOCon->prepare($selectInvSql);
    $selectInvSqlParameter = array("sku_value" => $sku);
    $selectInvSqlStatement->execute($selectInvSqlParameter);
    $inventoryRecords = array();
    $inventoryRecords = $selectInvSqlStatement->fetchAll(PDO::FETCH_ASSOC);
    if (count($inventoryRecords) > 0) {
        if ($get_field == "cost_price") {
            $valueToReturn = $inventoryRecords[0]["cost_price"];
            $ret = array("cost_price" => $valueToReturn);
        } else if ($get_field == "title") {
            $valueToReturn = $inventoryRecords[0]["title"];
            $ret = array("title" => $valueToReturn);
        } else if ($get_field == "supplier") {
            $valueToReturn = $inventoryRecords[0]["supplier"];
            $ret = array("supplier" => $valueToReturn);
        }
        $return["json"] = json_encode($ret);
        return json_encode($return);
    }
}

if (is_ajax()) {
    if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
        $action = $_POST["action"];
        switch ($action) { //Switch case for value of action
            case "cost_price":
                echo getDataFromDb("cost_price", $_REQUEST['sku']);
                break;

            case "quantity":
                echo getDataFromDb("quantity", $_REQUEST['sku']);
                break;

            case "title":
                echo getDataFromDb("title", $_REQUEST['sku']);
                break;

            case "supplier":
                echo getDataFromDb("supplier", $_REQUEST['sku']);
                break;
        }
    }
}

//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

?>
