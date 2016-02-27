<?php
include('db.php');

function getDataFromDb($purchase_id) {
    global $myMySQLPDOCon;
	$today = date('Y-m-d');
	if ($purchase_id != "") {
		$selectInvSql2 = "SELECT * FROM inventory WHERE purchase_id=:purchase_id_value and purchase_date=:purchase_date_value ";
		$selectInvSqlStatement2 = $myMySQLPDOCon->prepare($selectInvSql2);
		$selectInvSqlParameter2 = array("purchase_id_value" => $purchase_id, "purchase_date_value" => $today);
		$selectInvSqlStatement2->execute($selectInvSqlParameter2);
		$inventoryRecords2 = array();
		$inventoryRecords2 = $selectInvSqlStatement2->fetchAll(PDO::FETCH_ASSOC);
		if(count($inventoryRecords2)>1){
			return 0;
		}	
        //return 1;			
	}
}

if(isset($_REQUEST['purchase_id']) && !empty($_REQUEST['purchase_id'])){
	echo getDataFromDb($_REQUEST['purchase_id']);
}
?>