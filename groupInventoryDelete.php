<?php
require_once('auth.php');
include('db.php');

try{
    if(isset($_POST['bulk_delete_submit']) && isset($_POST['checked_id'])){
        $idArr = $_POST['checked_id'];
		$isDeleted = 0;
		$deleteError = 0;
		if(count($idArr)>0){
			foreach($idArr as $id_value){
				//mysqli_query($conn,"DELETE FROM users WHERE id=".$id);
				$deleteInvSql = "DELETE FROM inventory WHERE id=:id_value";
				$deleteInvSqlStatement = $myMySQLPDOCon->prepare($deleteInvSql);
				$deleteInvSqlParameter = array("id_value"=>$id_value);
				$deleteInvSqlStatement->execute($deleteInvSqlParameter);
		
				//echo "<br>isDeleted ".
				$isDeleted += $deleteInvSqlStatement->rowCount();
				$deleteError += $deleteInvSqlStatement->errorCode();			
			}
		}
        //$_SESSION['success_msg'] = 'Users have been deleted successfully.';
		if($isDeleted>0){
        	header("Location:inventory.php?delete=1");
			exit;
		}else{
			if($deleteError>0){
				header("location:inventory.php?invalid=1&message=".urlencode(" Error in deletion - Please ensure the corresponding sales order is deleted also."));
				exit;  
			}
		}
    }
}catch(Exception $e){
	header("location:inventory.php?invalid=1&message=".urlencode(" Exception :: ".$e->getMessage()));
	exit;  
}
?>