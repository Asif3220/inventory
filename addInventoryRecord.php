<?php
require_once('auth.php');
include('db.php');

$id_value = (isset($_REQUEST['id']))?$_REQUEST['id']:0;
if(!empty($id_value)){
	$selectInvSql = "SELECT * FROM inventory WHERE id=:id_value";
	$selectInvSqlStatement = $myMySQLPDOCon->prepare($selectInvSql);
	$selectInvSqlParameter = array("id_value"=>$id_value);
	$selectInvSqlStatement->execute($selectInvSqlParameter);
	$inventoryRecords = array();
	$inventoryRecords = $selectInvSqlStatement->fetchAll();
	$product_image = "";
	if(count($inventoryRecords)>0){
		$title = $inventoryRecords[0]["title"];
		$sku = $inventoryRecords[0]["sku"];
		$cost_price = $inventoryRecords[0]["cost_price"];
		$quantity = $inventoryRecords[0]["quantity"];
		$total_cost = $inventoryRecords[0]["total_cost"];
		$purchasedate = $inventoryRecords[0]["purchase_date"];
		$purchase_date = date('m/d/Y', strtotime($purchasedate));
		$supplier = $inventoryRecords[0]["supplier"];
		$product_image = (!empty($inventoryRecords[0]["product_image"]) || $inventoryRecords[0]["product_image"]!=NULL)?$inventoryRecords[0]["product_image"]:"";
	}
}

function getProperPurchaseId(){
	global $myMySQLPDOCon;
	$purchase_id_p = "";
	$today = date('Y-m-d');
	$selectInvSql_p = "SELECT purchase_id FROM inventory WHERE purchase_date=:purchase_date_value ORDER BY id DESC LIMIT 1";
	$selectInvSqlStatement_p = $myMySQLPDOCon->prepare($selectInvSql_p);
	$selectInvSqlParameter_p = array("purchase_date_value"=>$today);
	$selectInvSqlStatement_p->execute($selectInvSqlParameter_p);
	$inventoryRecords_p = array();
	$inventoryRecords_p = $selectInvSqlStatement_p->fetchAll();

	if(count($inventoryRecords_p)>0){
		$purchase_id_p = $inventoryRecords_p[0]["purchase_id"];
	}
	return $purchase_id_p;
}

$purchase_id = "";
$purchase_id = getProperPurchaseId();
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
	<link href="css/style.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>
		<script>
		function confirmProductImageDelete(id){
			var conf = confirm("Are you sure to delete this product image?");
			if(conf){
				location.href = "deleteProductImage.php?id="+id;
			}
		}
		</script>		
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
  
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
		  <br><img src="images/SimplyEezyLogo.png" ><br>
            <li><a href="dashboard.php">Overview <span class="sr-only">(current)</span></a></li>
			<li class="active"><a href="inventory.php">Inventory</a></li>
			<li><a href="sales.php">Sales</a></li>
    <!--        <li><a href="report.php">Reports</a></li>  -->          
            <!-- <li><a href="#">Export</a></li>-->
          </ul>
         
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Inventory</h1>

		<div class="well well-lg">
			<div class="row">
				<div style=" text-align:center;">
				
					<div class="col-xs-4">
						<button type="button" class="btn btn-primary btn-lg" onClick='location.href="dashboard.php";'>Overview</button>
					</div>	
						
					<div class="col-xs-4">
						<button type="button" class="btn btn-success btn-lg" onClick='location.href="inventory.php";'>Inventory</button>
					</div>
					
					<div class="col-xs-4">
						<button type="button" class="btn btn-primary btn-lg" onClick='location.href="sales.php";'>Sales Order</button>
					</div>
					
				</div>
			</div>
		</div>	

          <h2 class="sub-header"><?php echo (!empty($id_value))?'Edit':'Add';?> Inventory Record</h2>
          <div class="table-responsive" style="width:100%">

    <div id="maincontent" class="span8"> 
      <form id="add-inventory-form" class="form-horizontal" method="post" action="insertInventory.php" enctype="multipart/form-data">

		
		<div class="well well-lg">
		<?php 
		if(!empty($product_image))
		{
			echo '<img src="'.$product_image.'" width="150">';
			?>
			<br><a onClick="javascript:confirmProductImageDelete('<?php echo $id_value;?>');" href="javascript:void(0)">Delete Product Image</a>
			<?php
		}
		else
		{
			echo 'No product image available.';
		}		
		?>
		</div>
		
          <div class="form-control-group">
		  <div class="col-xs-4">
            <label class="control-label" for="purchase_id">Purchase ID</label>
            
              <input type="text" class="form-control input-md" id="purchase_id"  name="purchase_id" placeholder="Purchase ID" value="<?php echo (!empty($purchase_id))?$purchase_id:'';?>" <?php if(!empty($purchase_id)){echo 'readonly="true"';}?> >
            </div>
          </div>
		  		
		  <div class="form-control-group">
		  <div class="col-xs-4">
            <label class="control-label" for="purchase_date">Purchase Date</label>

			  
			<input type="text" class="form-control input-md" id="purchase_date" name="purchase_date" placeholder="Purchase Date" data-date-format="yyyy-mm-dd" data-date-autoclose=true value="<?php if(isset($purchase_date)){echo $purchase_date;}?>" >

  					<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
					<script src="//code.jquery.com/jquery-1.10.2.js"></script>
					<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
					<script>
						$(function() {
							$( "#purchase_date" ).datepicker();
						});
					</script>
				
            </div>
          </div>
          
	  
          <div class="form-control-group">
		  <div class="col-xs-4">
            <label class="control-label" for="sku">SKU</label>
            
              <input type="text" class="form-control input-md" id="sku"  name="sku" placeholder="SKU" value="<?php if(isset($sku)){echo $sku;}?>">
            </div>
          </div>
		  
			
          <div class="form-control-group">
		  <div class="col-xs-12">
            <label class="control-label" for="title">Product Description</label> 
              <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php if(isset($title)){echo $title;}?>">
            </div>
          </div>
		  
		  <?php if(empty($product_image)){?>
		  <div class="col-xs-12">
            <label class="control-label" for="title">Product Image</label> 
              <input type="file" class="form-control" id="product_image" name="product_image" placeholder="Upload">           
          </div>		  
		  <?php } ?>
		  
          <div class="form-control-group">
		  <div class="col-xs-12">
            <label class="control-label" for="supplier">Supplier</label>
                  <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Supplier" value="<?php if(isset($supplier)){echo $supplier;}?>">
            </div>
          </div>          

		  
          <div class="form-control-group">
		   <div class="col-xs-4">
            <label class="control-label" for="quantity">Quantity</label>
            
              <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Quantity" value="<?php if(isset($quantity)){echo $quantity;}?>">
            </div>
          </div>
		  		  
          

		  
          <div class="form-control-group">
		   <div class="col-xs-4">
            <label class="control-label" for="cost_price">Cost Price</label>
              <input type="text" class="form-control" id="cost_price" name="cost_price" placeholder="Cost Price" value="<?php if(isset($cost_price)){echo $cost_price;}?>">
            </div>
          </div>		 
		  
	
		  
          <div class="form-control-group">
		  <div class="col-xs-4">
            <label class="control-label" for="total_cost">Total Cost</label>
              <input type="text" class="form-control" id="total_cost" name="total_cost" placeholder="Total Cost" value="<?php if(isset($total_cost)){echo $total_cost;}?>" readonly="true">
            </div>
          </div>			  		   		  
		<div class="row text-center" >
				<div class="form-actions" >
					<div class="col-xs-12" style="padding-top:15px;">			 
						<button type="submit" class="btn btn-success btn-large" id="save_button">Save</button>
						<button type="reset" id="invResetForm" class="btn">Cancel</button>
					</div>
				</div>
		</div>	
			 <input type="hidden" id="id" name="id" value="<?php if(isset($id_value)){echo $id_value;}?>">
      </form>
    </div>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   <!-- <script src="js/ie10-viewport-bug-workaround.js"></script>-->
 </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script>
	//addEventListener('load', prettyPrint, false);
	<!--window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')-->
	
	</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

	<!--<script src="js/jquery-1.7.1.min.js"></script> -->
	
	<script src="js/jquery.validate.js"></script> 
	<script src="js/script.js"></script> 	
	
	<script>
		
		$(document).ready(function(){
			$('pre').addClass('prettyprint linenums');

			$('#purchase_id').focusout(function() {
/*				$.get("validatePurchaseId.php?purchase_id="+$(this).val(), function(data, status){
					if(status == "success" && data==1){
						alert("This purchase id is already exists! Please enter a new one.");
						$('#purchase_id').val("").focus();
						return false;
					}
				});*/
			});
		

			$('#quantity').focusout(function() {
				var a = $('input[name="cost_price"]').val();
				var b = $(this).val();
				$('input[name="total_cost"]').val(a * b);
				if($('#total_cost').val()!="" && $('#total_cost').val()>0){
					var decimalValue = $('#total_cost').val().indexOf("."); 
					if(decimalValue==-1){
						$('#total_cost').val($('#total_cost').val()+".00");
					}
				}
			});
						
			$('#quantity').keyup(function() {
				var a = $('input[name="cost_price"]').val();
				var b = $(this).val();
				$('input[name="total_cost"]').val(a * b);
				if($('#total_cost').val()!="" && $('#total_cost').val()>0){
					var decimalValue = $('#total_cost').val().indexOf("."); 
					if(decimalValue==-1){				
						$('#total_cost').val($('#total_cost').val()+".00");
					}
				}
			});
			
			$('#cost_price').focusout(function() {
			var decimalValue = $('#cost_price').val().indexOf("."); 
			if(decimalValue==-1){
				$('#cost_price').val($('#cost_price').val()+".00");
			}
				var a = $('input[name="quantity"]').val();
				var b = $(this).val();
				$('input[name="total_cost"]').val(a * b);
				if($('#total_cost').val()!="" && $('#total_cost').val()>0){
					var decimalValue = $('#total_cost').val().indexOf("."); 
					if(decimalValue==-1){					
						$('#total_cost').val($('#total_cost').val()+".00");
					}
				}
			});
						
/*			$('#cost_price').keyup(function() {
				var a = $('input[name="quantity"]').val();
				var b = $(this).val();
				$('input[name="total_cost"]').val(a * b);
				if($('#total_cost').val()!="" && $('#total_cost').val()>0){
					$('#total_cost').val($('#total_cost').val()+".00");
				}
			});	*/
			
/*			$('#total_cost').keyup(function() {
				var a = $('input[name="cost_price"]').val();
				var b = $('input[name="quantity"]').val();
				$('input[name="total_cost"]').val(a * b);
				if($('#total_cost').val()!="" && $('#total_cost').val()>0){
					$('#total_cost').val($('#total_cost').val()+".00");
				}
			});	*/
			
/*			$('#total_cost').focusout(function() {
				if($('#total_cost').val()!="" && $('#total_cost').val()>0){
					$('#total_cost').val($('#total_cost').val()+".00");
				}
			});	*/
			
			$('#invResetForm').click(function() {
				$('#add-inventory-form').reset();
			});				
			
								
		});
	</script> 	
  </body>
</html>
