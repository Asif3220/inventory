<?php
require_once('auth.php');
include('db.php');

$limit = 10;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  

$qInv = (isset($_REQUEST['searchSales']))?$_REQUEST['searchSales']:'';

$from_date = (isset($_REQUEST['from_date']))?urldecode($_REQUEST['from_date']):'';
$to_date = (isset($_REQUEST['to_date']))?urldecode($_REQUEST['to_date']):'';

$sale_id = (isset($_REQUEST['sale_id']))?$_REQUEST['sale_id']:'';

$selectInvSql = "";
if(!empty($from_date) && !empty($to_date)){
	$from_date_ymd = date("Y-m-d", strtotime($from_date));
	$to_date_ymd = date("Y-m-d", strtotime($to_date));
	$selectInvSql = "SELECT id, sale_id, order_id, title, sku, cost_price, quantity_purchased, sale_price, sale_date, supplier, profit_retained FROM sales WHERE sale_date BETWEEN '".$from_date_ymd."' AND '".$to_date_ymd."' LIMIT $start_from, $limit";
}else if(!empty($qInv)){
	//$selectInvSql = "SELECT id, sale_id, order_id, title, sku, cost_price, quantity_purchased, sale_price, sale_date, supplier, profit_retained FROM sales WHERE title LIKE '%".$qInv."%' LIMIT $start_from, $limit";
	$selectInvSql = "SELECT id, sale_id, order_id, title, sku, cost_price, quantity_purchased, sale_price, sale_date, supplier, profit_retained FROM sales WHERE (sku LIKE '%".trim($qInv)."%' OR  order_id LIKE '%".trim($qInv)."%') LIMIT $start_from, $limit";
}else if(!empty($sale_id)){
	$selectInvSql = "SELECT id, sale_id, order_id, title, sku, cost_price, quantity_purchased, sale_price, sale_date, supplier, profit_retained FROM sales WHERE sale_id LIKE '%".$sale_id."%' LIMIT $start_from, $limit";
}else{
	$selectInvSql = "SELECT id, sale_id, order_id, title, sku, cost_price, quantity_purchased, sale_price, sale_date, supplier, profit_retained FROM sales LIMIT $start_from, $limit";
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
	if(!empty($qInv)){
		$qSalesSqlClause = "(sku LIKE '%".trim($qInv)."%' OR  order_id LIKE '%".trim($qInv)."%')";
	}
	$selectSaleSearchedSql = "";
	if(!empty($inputVar)){
		if($inputVar == "totalQuantitySold"){
			//echo "<br>selectSaleSearchedSql : ".
			$selectSaleSearchedSql = "SELECT SUM(quantity_purchased) AS result_total FROM sales WHERE 1=1 AND ".$qSalesSqlClause;

		}else if($inputVar == "totalProfitRetained"){
			//echo "<br>selectSaleSearchedSql : ".
			$selectSaleSearchedSql = "SELECT SUM(profit_retained) AS result_total FROM sales WHERE 1=1 AND ".$qSalesSqlClause;
		}	
		
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

function getSaleCount($field){
	global $myMySQLPDOCon;
	$selectInvSql3 = "SELECT DISTINCT(`".$field."`) FROM sales";
	$selectInvSqlStatement3 = $myMySQLPDOCon->prepare($selectInvSql3);
	$selectInvSqlParameter3 = array();
	$selectInvSqlStatement3->execute($selectInvSqlParameter3);
	$inventoryRecords3 = array();
	$inventoryRecords3 = $selectInvSqlStatement3->fetchAll();
	return count($inventoryRecords3);
}

function getSaleSum($field){
	global $myMySQLPDOCon;
	$selectInvSql3 = "SELECT SUM(`".$field."`) As total FROM sales";
	$selectInvSqlStatement3 = $myMySQLPDOCon->prepare($selectInvSql3);
	$selectInvSqlParameter3 = array();
	$selectInvSqlStatement3->execute($selectInvSqlParameter3);
	$inventoryRecords3 = array();
	$inventoryRecords3 = $selectInvSqlStatement3->fetchAll();
	if(count($inventoryRecords3)>0){
		return $inventoryRecords3[0]["total"];
	}
	return 0;
}

	$total_records = 0;
	$selectInvSql4 = "SELECT count(*) AS total_record FROM sales";
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
	function confirmSalesDelete(id){
		var conf = confirm("Are you sure to delete this record?");
		if(conf){
			location.href = "deleteSales.php?id="+id;
		}
	}
	
	function findSaleByID(sale_id){
		location.href = "sales.php?sale_id="+sale_id;
	}	
	
    function PrintDiv() {    
		$('table tr').find('td:eq(1),th:eq(1)').hide();
		$('table tr').find('td:eq(11),th:eq(11)').hide();
		$("#bulk_delete_submit").hide();
		
		var divToPrint = document.getElementById('divToPrint').innerHTML;
		var popupWin = window.open('', '_blank', 'width=1200,height=600');
		popupWin.document.open();
		popupWin.document.write('<html><body onload="window.print()">' + divToPrint + '</html>');
		popupWin.document.close();
		
		$('table tr').find('td:eq(1),th:eq(1)').show();
		$('table tr').find('td:eq(11),th:eq(11)').show();
		$("#bulk_delete_submit").show();
    }
	
	function deleteConfirm(){
		var result = confirm("Are you sure to delete sales records?");
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
            <input type="text" id="searchSales" name="searchSales" class="form-control" size="25" placeholder="Search By Order Id or SKU" value="<?php if(isset($qInv)){echo $qInv;}?>">
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
			<li><a href="stock.php">Stock</a></li> 				
			<li class="active"><a href="sales.php">Sales Orders</a></li>
          </ul>
         <div style="position:fixed;bottom:0px;margin-right:right;margin-left:auto; font-style:italic"><footer>Design & developed by Creosoft Systems Team | Inventory Management - Version <strong>1.0</strong> </footer></div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Sales Orders</h1>

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
						<button type="button" class="btn btn-primary btn-lg" onClick='location.href="stock.php";'>Stock</button>
					</div>						
					
					<div class="col-xs-3">
						<button type="button" class="btn btn-success btn-lg" onClick='location.href="sales.php";'>Sales Order</button>
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
		<strong>Great!</strong> You have successfully <?php echo $act;?> the sales record.
		</div>
		<?php }elseif($act == "could not be added" || $act == "could not be deleted" || $act == "could not be updated"){ ?>
		<div class="alert alert-danger" role="alert">
			<strong>Sorry!</strong> The sales record <?php echo $act;?>, Please try again.
		</div>		
		<?php }elseif(isset($_REQUEST['invalid'])){ ?>
		<div class="alert alert-danger" role="alert">
			<strong>Sorry!</strong> <?php echo (!empty($_REQUEST['message']))?urldecode($_REQUEST['message']):'Please check the input as invalid data were supplied.';?> Please try again.
		</div>				
         <?php } ?>
		 
			<div class="row">
				<div class="col-sm-12">
				<h2 class="sub-header">Sales Orders Records</h2>
				</div>	
			</div>	
			
			<div class="row">
				<div class="col-sm-12"> 
				
					<form class="navbar-form navbar-right" name="dateRangeForm" id="dateRangeForm">
					<button onClick="PrintDiv();" type="button" class="btn btn-success btn-large">Print</button>
						<button onClick="location.href='exportSales.php?sql=<?php echo base64_encode($selectInvSql);?>';" type="button" class="btn btn-info btn-large">Export</button>
						<button onClick="location.href='addSalesRecord.php';" type="button" class="btn btn-primary btn-large">Create Sale Order</button>
						
						<select name="sale_id" id="sale_id" class="form-control" onChange="findSaleByID(this.value);">
						<option value="">Search By Sales Id</option>
						<?php
							$selectInvSql2 = "SELECT DISTINCT(sale_id) AS sale_id FROM sales";
							
							$selectInvSqlStatement2 = $myMySQLPDOCon->prepare($selectInvSql2);
							$selectInvSqlParameter2 = array();
							$selectInvSqlStatement2->execute($selectInvSqlParameter2);
							$inventoryRecords2 = array();
							$inventoryRecords2 = $selectInvSqlStatement2->fetchAll();
							if(count($inventoryRecords2)>0){
								foreach($inventoryRecords2 as $invpur){
								?>
								<option value="<?php echo $invpur["sale_id"]; ?>" <?php if(isset($_REQUEST['sale_id']) && ($invpur["sale_id"] == $_REQUEST['sale_id'])){echo "selected";} ?> > <?php echo $invpur["sale_id"]; ?></option>
								<?php
								}
							}
						?>
						</select>
												
						<input type="text" name="from_date" id="from_date"  class="form-control" placeholder="From" value="<?php if(isset($_REQUEST['from_date'])){echo $_REQUEST['from_date'];}?>" >
						<input type="text" name="to_date" id="to_date"  class="form-control" placeholder="To" value="<?php if(isset($_REQUEST['to_date'])){echo $_REQUEST['to_date'];}?>" >
						<button type="submit" class="btn btn-success btn-large">Find</button>
						<button id="resetButton" type="reset" class="btn btn-danger btn-large">Cancel</button>
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
					<div class="well well-lg">
						<?php if(empty($qInv)){?>
							Total Unique Sale ID : <strong><?php echo getSaleCount("sale_id"); ?></strong> | Total SKU Sold Count : <strong><?php echo getSaleCount("sku"); ?></strong> | Total Quantity Sold Count : <strong><?php echo getSaleSum("quantity_purchased"); ?></strong> | Total Profit : <strong><?php echo getSaleSum("profit_retained"); ?></strong>
						<?php }else{?>
							Total Product Sold : <?php echo getStatForSearchedResult("totalQuantitySold", $qInv); ?> | Total Profit : <?php echo getStatForSearchedResult("totalProfitRetained", $qInv); ?>
						<?php }?>
					</div>
				</div>	
		</div>
			
			<br><br>
          <div class="table-responsive">
		   <div id="divToPrint" style="display:block;">
		   <form name="bulk_action_form" id="bulk_action_form" action="groupSalesDelete.php" method="post" onSubmit="return deleteConfirm();"/>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
				  <th><input type="checkbox" name="select_all" id="select_all" value=""/></th>   
				 <!-- <th>Sale ID</th>-->
                  <th>Product Title</th>
				  <th>Order ID</th>
                  <th>SKU</th>
                  <th>Cost</th>
                  <th>Quantity Sold</th>
				  <th>Sale Price</th>
				   <th>Profit</th>
			      <th>Sale Date</th>
				  <th>Supplier</th>
				  <th>Action</th>
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
					  <td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $invRow['id']; ?>"/></td>    
					<!--  <td><?php //echo $invRow["sale_id"];?></td>-->
					  <td><?php echo $invRow["title"];?></td>
					  <td><?php echo strtoupper($invRow["order_id"]);?></td>
					  <td><?php echo strtoupper($invRow["sku"]);?></td>
					  <td><?php echo $invRow["cost_price"];?></td>
					  <td><?php echo $invRow["quantity_purchased"];?></td>
					  <td><?php echo $invRow["sale_price"];?></td>
					  <td><?php echo $invRow["profit_retained"];?></td>
					  <td><?php echo $invRow["sale_date"];?></td>
					  <td><?php echo $invRow["supplier"];?></td>
					  <td><a href="addSalesRecord.php?id=<?php echo $invRow["id"];?>">Edit</a>&nbsp;|&nbsp;<a onClick="javascript:confirmSalesDelete('<?php echo $invRow["id"];?>');" href="javascript:void(0)">Delete</a></td>  
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
			 <tr>
                  <td colspan="9">

				</td>		  
                </tr> 			  
			</tbody>
            </table>
			<?php if($total_records>1){?>
			<input type="submit" class="btn btn-danger" name="bulk_delete_submit" id="bulk_delete_submit" value="Delete"/>
			<?php } ?>
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
									 $pagLink .= "<li><a href='sales.php?page=".$i."'>".$i."</a></li> ";  
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
