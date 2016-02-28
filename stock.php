<?php
require_once('auth.php');
include('db.php');

$limit = 10;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  

					
$qInv = (isset($_REQUEST['searchInventory']))?$_REQUEST['searchInventory']:'';

$from_date = (isset($_REQUEST['from_date']))?urldecode($_REQUEST['from_date']):'';
$to_date = (isset($_REQUEST['to_date']))?urldecode($_REQUEST['to_date']):'';


$selectInvSql = "";
if(!empty($from_date) && !empty($to_date)){
	$from_date_ymd = date("Y-m-d", strtotime($from_date));
	$to_date_ymd = date("Y-m-d", strtotime($to_date));
	$selectInvSql = "SELECT id, sku, stock FROM master_inventory WHERE purchase_date BETWEEN '".$from_date_ymd."' AND '".$to_date_ymd."' LIMIT $start_from, $limit";
}else if(!empty($qInv)){
	//echo "<br>selectInvSql : ".
	$selectInvSql = "SELECT id, sku, stock FROM master_inventory WHERE sku LIKE '%".trim($qInv)."%'  LIMIT $start_from, $limit";
}else{
	$selectInvSql = "SELECT id, sku, stock FROM master_inventory LIMIT $start_from, $limit";
}

if(!empty($selectInvSql)){
	$selectInvSqlStatement = $myMySQLPDOCon->prepare($selectInvSql);
	$selectInvSqlParameter = array();
	$selectInvSqlStatement->execute($selectInvSqlParameter);
	$inventoryRecords = array();
	$inventoryRecords = $selectInvSqlStatement->fetchAll();
}


function getStatForSearchedResult($inputVar, $qInv){
	global $myMySQLPDOCon;
	$qSalesSqlClause = "";
	$selectSaleSearchedSql = "";
	if(!empty($qInv)){
		$qSalesSqlClause = "sku LIKE '%".trim($qInv)."%'";
			//echo "<br>selectSaleSearchedSql : ".
			$selectSaleSearchedSql = "SELECT SUM(stock) AS result_total FROM master_inventory WHERE 1=1 AND ".$qSalesSqlClause;
		}else{
			$selectSaleSearchedSql = "SELECT SUM(stock) AS result_total FROM master_inventory";
		}	
	
	if(!empty($selectSaleSearchedSql)){

		
		if(!empty($selectSaleSearchedSql)){
			$selectSaleSearchedSqlStatement = $myMySQLPDOCon->prepare($selectSaleSearchedSql);
			$selectSaleSearchedSqlStatement->execute();
			$selectSaleSearchedRecords = array();
			$selectSaleSearchedRecords = $selectSaleSearchedSqlStatement->fetchAll();
			if(count($selectSaleSearchedRecords)>0){
				return $selectSaleSearchedRecords[0]["result_total"];
			}
			return 0;
		}
	}
}

function getProductName($sku_value){
	global $myMySQLPDOCon;
	$selectInvSql3 = "SELECT `title` FROM inventory WHERE sku='".$sku_value."'";

	
	$selectInvSqlStatement3 = $myMySQLPDOCon->prepare($selectInvSql3);
	$selectInvSqlParameter3 = array();
	$selectInvSqlStatement3->execute($selectInvSqlParameter3);
	$inventoryRecords3 = array();
	$inventoryRecords3 = $selectInvSqlStatement3->fetchAll();
	if(count($inventoryRecords3)>0){
	 return $inventoryRecords3[0]["title"];
	}
	return "";
}

	$total_records = 0;
	$selectInvSql4 = "SELECT count(*) AS total_record FROM inventory";
	$selectInvSqlStatement4 = $myMySQLPDOCon->prepare($selectInvSql4);
	$selectInvSqlParameter4 = array();
	$selectInvSqlStatement4->execute($selectInvSqlParameter4);
	$inventoryRecords4 = array();
	$inventoryRecords4 = $selectInvSqlStatement4->fetchAll();
	if(count($inventoryRecords4)>0){
		$total_records = $inventoryRecords4[0]["total_record"]; 
	}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Inventory</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script>
	function confirmDelete(id){
		var conf = confirm("Are you sure to delete this record?");
		if(conf){
			location.href = "deleteInventory.php?id="+id;
		}
	}
	
	function findPurchaseByID(purchase_id){
		location.href = "inventory.php?purchase_id="+purchase_id;
	}
	
    function PrintDiv() {    
		var divToPrint = document.getElementById('divToPrint').innerHTML;
		var popupWin = window.open('', '_blank', 'width=1200,height=600');
		popupWin.document.open();
		popupWin.document.write('<html><body onload="window.print()">' + divToPrint + '</html>');
		popupWin.document.close();
    }
	
	function getStockBySKU(sku){
		$.get("getStock.php?sku="+sku, function(data, status){
			//alert("Data: " + data + "\nStatus: " + status);
			$("#stock_display").html(data);
		});
	}
	
	function deleteConfirm(){
		var result = confirm("Are you sure to delete inventory records?");
		if(result){
			return true;
		}else{
			return false;
		}
	}	
	</script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <a class="navbar-brand" href="#">Inventory Management</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php">Log Out</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" id="searchInventory" name="searchInventory" class="form-control input-md" size="15" placeholder="Search By SKU" value="<?php if(isset($qInv)){echo $qInv;}?>">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
		  <br><img src="images/SimplyEezyLogo.png" ><br>
            <li><a href="dashboard.php">Overview <span class="sr-only">(current)</span></a></li>
			<li><a href="inventory.php">Inventory</a></li>
			<li class="active"><a href="stock.php">Stock</a></li> 			
			<li><a href="sales.php">Sales Orders</a></li>
          </ul>
         <div style="position:fixed;bottom:0px;margin-right:right;margin-left:auto; font-style:italic"><footer>Design & developed by Creosoft Systems Team | Inventory Management - Version <strong>1.0</strong> </footer></div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Inventory Stock</h1>

		<div class="well well-lg">
			<div class="row">
				<div style=" text-align:center;">
				
					<div class="col-xs-3">
						<button type="button" class="btn btn-primary btn-lg" onClick='location.href="dashboard.php";'>Overview</button>
					</div>	
						
					<div class="col-xs-3">
						<button type="button" class="btn btn-primary btn-lg" onClick='location.href="inventory.php";'>Inventory</button>
					</div>
					
					<div class="col-xs-3">
						<button type="button" class="btn btn-success btn-lg" onClick='location.href="stock.php";'>Stock</button>
					</div>						
					
					<div class="col-xs-3">
						<button type="button" class="btn btn-primary btn-lg" onClick='location.href="sales.php";'>Sales Order</button>
					</div>
					
				</div>
			</div>
		</div>	
		 	  
		<?php 
		$act = "";
		if(isset($_REQUEST['insert']) && $_REQUEST['insert']==1){$act = "added";}
		elseif(isset($_REQUEST['delete']) && $_REQUEST['delete']==1){$act = "deleted";}
		elseif(isset($_REQUEST['update']) && $_REQUEST['update']==1){$act = "updated";}
		
		if(isset($_REQUEST['insert']) && $_REQUEST['insert']==0){$act = "could not be added";}
		elseif(isset($_REQUEST['delete']) && $_REQUEST['delete']==0){$act = "could not be deleted";}
		elseif(isset($_REQUEST['update']) && $_REQUEST['update']==0){$act = "could not be updated";}
				
		if($act == "added" || $act == "deleted" || $act == "updated"){
		?>	
		<div class="alert alert-success" role="alert">
		<strong>Great!</strong> You have successfully <?php echo $act;?> the inventory record.
		</div>
		<?php }elseif($act == "could not be added" || $act == "could not be deleted" || $act == "could not be updated"){ ?>
		<div class="alert alert-danger" role="alert">
			<strong>Sorry!</strong> The inventory record <?php echo $act;?>, Please try again.
		</div>		
		<?php }elseif(isset($_REQUEST['invalid'])){ ?>
		<div class="alert alert-danger" role="alert">
			<strong>Sorry!</strong> <?php echo (!empty($_REQUEST['message']))?urldecode($_REQUEST['message']):'Please check the input as invalid data were supplied.';?> Please try again.
		</div>				
         <?php } ?>
			
          
			<div class="row">
				<div class="col-sm-12">
				<h2 class="sub-header">Inventory Stock Records</h2>
				</div>	
			</div>	
			<div class="row">	
				<div class="col-sm-12"> 
				
					<form class="navbar-form navbar-right" name="dateRangeForm" id="dateRangeForm">
					<button onClick="PrintDiv();" type="button" class="btn btn-success btn-large">Print</button>
						<button onClick="location.href='exportStock.php?sql=<?php echo base64_encode($selectInvSql);?>';" type="button" class="btn btn-info btn-large">Export</button>
					</form>
					<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
					<script src="//code.jquery.com/jquery-1.10.2.js"></script>
					<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
					<script>
						$(function() {
						$( "#from_date" ).datepicker();
						$( "#to_date" ).datepicker();
							$('#resetButton').click(function(){
								$('#from_date').val("");
								$('#to_date').val("");
								$('#dateRangeForm').submit();
							});
						});
					</script>
				</div>	
			</div>
			
	
		<div class="row">
				<div class="col-sm-12">
				<form class="navbar-form navbar-center" name="dateRangeForm" id="dateRangeForm">
				<div class="well well-lg">
				<?php // if(empty($qInv)){?>
				Total Current Stock : <strong><?php echo getStatForSearchedResult("stock", $qInv); ?></strong>&nbsp;&nbsp;
				<?php // }else{?>
				<?php //}?>
				</div>
				</form>
				</div>	
</div>
			<br><br>
          <div class="table-responsive">
		  <div id="divToPrint" style="display:block;">
            <table class="table table-striped" id="myTable">
              <thead>
                <tr>
                  <th>#</th>
                  <!--<th>Product Title</th>-->
                  <th>SKU</th>
                  <th>Current Stock</th>
                </tr>
              </thead>
			  <tbody>
			  <?php 
			  $indx=1;
			  if(count($inventoryRecords)>0){
			  	foreach($inventoryRecords as $invRow){
				?>
				
					<tr>
					  <td><?php echo $indx;?></td>
					 <!-- <td><?php //echo getProductName($invRow["sku"]);?></td>-->
					  <td><?php echo strtoupper($invRow["sku"]);?></td>
					  <td><?php echo $invRow["stock"];?></td>
					</tr>                
				<?php
				$indx++;
				}
			  }else{
			  ?>
                <tr>
                  <td colspan="9">No record available!</td>		  
                </tr>              
              
			  <?php
			  }
			  ?>
             
			</tbody>
            </table>
			
			</form>
			<br><br>
			<table class="table table-striped">
			<thead>
			<tr>
			<td colspan="9">
				<?php					
					$total_pages = ceil($total_records / $limit);
					if($total_records>10){  
					$pagLink = "<div class='pagination'><ul class='pagination pagination-sm'>";  
					for ($i=1; $i<=$total_pages; $i++) {  
					$pagLink .= "<li><a href='inventory.php?page=".$i."'>".$i."</a></li> ";  
					};  
					echo $pagLink . "</ul></div>"; 
					}
				?>
			</td>		  
			</tr> 
			</tbody>
			</table>
			</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

  <!--  <script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>-->
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	
	<script>
	$(document).ready(function(){	
		
/*		$('#bulk_delete_submit').click(function(){
			var conf2 = confirm("Are you sure to delete the selected record?");
			if(conf2){
				$("form[name='bulk_action_form']").submit();
				return true;	
			}	
		});*/
		
		$('#select_all').on('click',function(){
			if(this.checked){
				$('.checkbox').each(function(){
					this.checked = true;
				});
			}else{
				 $('.checkbox').each(function(){
					this.checked = false;
				});
			}
		});
		
		$('.checkbox').on('click',function(){
			if($('.checkbox:checked').length == $('.checkbox').length){
				$('#select_all').prop('checked',true);
			}else{
				$('#select_all').prop('checked',false);
			}
		});
	});
	</script>
  </body>
</html>
