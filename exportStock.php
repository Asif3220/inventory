<?php
require_once('auth.php');
include('db.php');

$csv_filename = 'export_stock_'.date('Ymd_His').'.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename='.$csv_filename);

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('#', 'SKU', 'Current Stock'));

$selectInvSql = base64_decode($_GET['sql']);
$selectInvSqlStatement = $myMySQLPDOCon->prepare($selectInvSql);
$selectInvSqlParameter = array();
$selectInvSqlStatement->execute($selectInvSqlParameter);
$inventoryRecords = array();
$inventoryRecords = $selectInvSqlStatement->fetchAll(PDO::FETCH_ASSOC);

if(count($inventoryRecords)>0){
	foreach($inventoryRecords as $invRec){
		fputcsv($output, $invRec);
	}
}


?>