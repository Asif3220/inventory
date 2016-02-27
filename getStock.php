<?php

include('db.php');



function getDataFromDb($sku) {
    global $myMySQLPDOCon;
    $ret = array();
    $valueToReturn = "";
	
	if ($sku != "") {
		$selectInvSql2 = "SELECT stock FROM master_inventory WHERE sku=:sku_value";
		$selectInvSqlStatement2 = $myMySQLPDOCon->prepare($selectInvSql2);
		$selectInvSqlParameter2 = array("sku_value" => $sku);
		$selectInvSqlStatement2->execute($selectInvSqlParameter2);
		$inventoryRecords2 = array();
		$inventoryRecords2 = $selectInvSqlStatement2->fetchAll(PDO::FETCH_ASSOC);
		if(count($inventoryRecords2)>0){
			$valueToReturn = $inventoryRecords2[0]["stock"];
		}	
        return $valueToReturn;			
	}
}

if(isset($_REQUEST['sku']) && !empty($_REQUEST['sku'])){
	echo "Total Current Stock : ".getDataFromDb($_REQUEST['sku']);
}else{
echo "Please select one SKU";
}
?>
