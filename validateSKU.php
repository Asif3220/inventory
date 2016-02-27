<?php
include('db.php');

function getDataFromDb($sku) {
    global $myMySQLPDOCon;
	
	if ($sku != "") {
		$selectInvSql2 = "SELECT * FROM inventory WHERE sku=:sku_value";
		$selectInvSqlStatement2 = $myMySQLPDOCon->prepare($selectInvSql2);
		$selectInvSqlParameter2 = array("sku_value" => $sku);
		$selectInvSqlStatement2->execute($selectInvSqlParameter2);
		$inventoryRecords2 = array();
		$inventoryRecords2 = $selectInvSqlStatement2->fetchAll(PDO::FETCH_ASSOC);
		if(count($inventoryRecords2)>0){
			return "yes";
		}	
        return "no";			
	}
}

if(isset($_REQUEST['sku']) && !empty($_REQUEST['sku'])){
	echo getDataFromDb($_REQUEST['sku']);
}
?>
