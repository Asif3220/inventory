<?php
require_once('auth.php');
include('db.php');

$id_value = (isset($_REQUEST['id']))?$_REQUEST['id']:'';
if(!empty($id_value)){
	$selectInvSql = "SELECT * FROM sales WHERE id=:id_value";
	$selectInvSqlStatement = $myMySQLPDOCon->prepare($selectInvSql);
	$selectInvSqlParameter = array("id_value"=>$id_value);
	$selectInvSqlStatement->execute($selectInvSqlParameter);
	$inventoryRecords = array();
	$inventoryRecords = $selectInvSqlStatement->fetchAll();
	if(count($inventoryRecords)>0){
		$title = $inventoryRecords[0]["title"];
		$sku = $inventoryRecords[0]["sku"];
		$cost_price = $inventoryRecords[0]["cost_price"];
		$quantity_purchased = $inventoryRecords[0]["quantity_purchased"];
		$sale_price = $inventoryRecords[0]["sale_price"];
		$supplier = $inventoryRecords[0]["supplier"];
		$saledate = $inventoryRecords[0]["sale_date"];
		$sale_date = date('m/d/Y', strtotime($saledate));
		$profit_retained = $inventoryRecords[0]["profit_retained"];
	}
}

function getProperSaleId(){
	global $myMySQLPDOCon;
	$sale_id_p = "";
	$today = date('Y-m-d');
	$selectInvSql_p = "SELECT sale_id FROM sales WHERE DATE_FORMAT(date_added, '%Y-%m-%d')=:sale_date_value ORDER BY id DESC LIMIT 1";
	$selectInvSqlStatement_p = $myMySQLPDOCon->prepare($selectInvSql_p);
	$selectInvSqlParameter_p = array("sale_date_value"=>$today);
	$selectInvSqlStatement_p->execute($selectInvSqlParameter_p);
	$inventoryRecords_p = array();
	$inventoryRecords_p = $selectInvSqlStatement_p->fetchAll();

	if(count($inventoryRecords_p)>0){
		$sale_id_p = $inventoryRecords_p[0]["sale_id"];
	}
	return $sale_id_p;
}

$sale_id = "";
$sale_id = getProperSaleId();
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

    <title>Sales Order</title>

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

			<style>
		input#sale_id, input#order_id{    text-transform: uppercase;}
		.myForm
		{
			width: 750px;
			margin-left: auto;
			margin-right: auto;
			float: none;
		}
		</style>	
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
			<li><a href="stock.php">Stock</a></li> 			
			<li><a href="sales.php">Sales Order</a></li>
          </ul>
         
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Sales Order</h1>

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

          <h2 class="sub-header"><?php echo (!empty($id_value))?'Edit':'Add';?> Sales Order Record</h2>
          <div class="table-responsive" style="width:100%">

    <div id="maincontent" class="span8 myForm"> 
      <form id="add-salesorder-form" class="form-horizontal" method="post" action="insertSales.php" >
		  <div class="form-control-group">
		  <div class="col-xs-6">
            <label class="control-label" for="sale_id">Sale ID</label>
            
              <input type="text" class="form-control input-md" id="sale_id"  name="sale_id" placeholder="Sale ID" value="<?php echo (!empty($sale_id))?$sale_id:'';?>"  <?php if(!empty($sale_id)){echo 'readonly="true"';}?> >
            </div>
          </div>
		  
		  <div class="form-control-group">
		  <div class="col-xs-6">
            <label class="control-label" for="sale_id">Order ID</label>
            
              <input type="text" class="form-control input-md" id="order_id"  name="order_id" placeholder="Order ID" value="<?php echo (!empty($order_id))?$order_id:'';?>" >
            </div>
          </div>		  
		  
          <div class="form-control-group">
		   <div class="col-xs-6">
            <label class="control-label" for="sku">SKU</label>
			<input type="text" class="form-control input-md" id="sku"  name="sku" placeholder="SKU" value="<?php echo (!empty($sku))?$sku:'';?>" onBlur="checkSKU();" >
		   <!--<select name="sku" id="sku" class="form-control">
		   <option value="">Select SKU</option>	 -->  
		   <?php
/*			$selectInvSql2 = "SELECT DISTINCT(i.sku) FROM inventory i, master_inventory mi WHERE i.sku = mi.sku AND mi.stock>0";
			$selectInvSqlStatement2 = $myMySQLPDOCon->prepare($selectInvSql2);
			$selectInvSqlParameter2 = array("id_value"=>$id_value);
			$selectInvSqlStatement2->execute($selectInvSqlParameter2);
			$inventoryRecords2 = array();
			$inventoryRecords2 = $selectInvSqlStatement2->fetchAll(PDO::FETCH_ASSOC);
			if(count($inventoryRecords2)>0){
				foreach($inventoryRecords2 as $selVal)
				{
					$option_selected = "";
					$id = (isset($selVal["id"]))?$selVal["id"]:""; 
					$sku_opt = (isset($selVal["sku"]))?$selVal["sku"]:"";
					$cost_price = (isset($selVal["cost_price"]))?$selVal["cost_price"]:"";
					if((isset($_REQUEST['sku'])) &&($sku_opt == $_REQUEST['sku']))
					{
						$option_selected = "selected";
					}
					echo '<option value="'.$sku_opt.'" '.$option_selected.'>'.$sku_opt.'</option>';
				}
			}*/
		   ?>
		  <!--  </select>-->

            </div>
          </div>	
		  
          <div class="form-control-group">
			<div class="col-xs-6">			  
            <label class="control-label" for="sale_date">Sale Date</label>
          
              <!--<input type="text" class="form-control input-md" id="purchase_date" name="purchase_date" placeholder="Purchase Date">-->
			<?php if(!empty($id_value)){?>    
			<input type="text" class="form-control input-md" id="sale_date" name="sale_date" placeholder="Sale Date" data-date-format="yyyy-mm-dd" data-date-autoclose=true value="<?php if(isset($sale_date)){echo $sale_date;}?>" >

  					<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
					<script src="//code.jquery.com/jquery-1.10.2.js"></script>
					<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
					<script>
						$(function() {
							$( "#sale_date" ).datepicker();
						});
					</script>
			<?php }else{?>  	
			<input type="text" class="form-control input-md" id="sale_date" name="sale_date" placeholder="Sale Date" data-date-format="yyyy-mm-dd" data-date-autoclose=true value="<?php echo date('m/d/Y');?>" readonly="true">
			<?php }?> 				
            </div>
          </div>			  	  
		                 
          <div class="form-control-group">
		  <div class="col-xs-12">
            <label class="control-label" for="title">Product Description</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php if(isset($title)){echo $title;}?>" readonly="true">
            </div>
          </div>
		  
          <div class="form-control-group">
		  <div class="col-xs-12">
            <label class="control-label" for="supplier">Supplier</label>
              <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Supplier" value="<?php if(isset($supplier)){echo $supplier;}?>" readonly="true" >
            </div>
          </div>

          <div class="form-control-group">
		  <div class="col-xs-6">
            <label class="control-label" for="cost_price">Cost Price</label>
              <input type="text" class="form-control" id="cost_price" name="cost_price" placeholder="Cost Price" value="<?php if(isset($cost_price)){echo $cost_price;}?>"  readonly="true">
            </div>
          </div>	

          <div class="form-control-group">
			<div class="col-xs-6">		  
            <label class="control-label" for="quantity_purchased">Quantity Sold</label>
              <input type="text" class="form-control" id="quantity_purchased" name="quantity_purchased" placeholder="Quantity Sold" value="<?php if(isset($quantity_purchased)){echo $quantity_purchased;}?>">
            </div>
          </div>
		  		  
          <div class="form-control-group">
		  <div class="col-xs-6">
            <label class="control-label" for="sale_price">Sale Price</label>
              <input type="text" class="form-control" id="sale_price" name="sale_price" placeholder="Sale Price" value="<?php if(isset($sale_price)){echo $sale_price;}?>">
            </div>
          </div>		  	 

	  
		  
          <div class="form-control-group">		  
			<div class="col-xs-6">			  
            <label class="control-label" for="profit_retained">Profit</label>
              <input type="text" class="form-control" id="profit_retained" name="profit_retained" placeholder="Profit" value="<?php if(isset($profit_retained)){echo $profit_retained;}?>" readonly="true">
            </div>
          </div>			  		   		  
			<div class="row text-center" >         
				<div class="form-actions">
					<div class="col-xs-12" style="padding-top:15px;">	
						
						<button type="submit" class="btn btn-success btn-large" id="salesSaveButton">Save</button>
						<button type="reset" id="salesResetForm" class="btn">Cancel</button>
					</div>
				</div>
			</div>
			<input type="hidden" id="id" name="id" value="<?php if(isset($id_value)){echo $id_value;}?>">
			<input type="hidden" id="quantityInHand" name="quantityInHand">
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
	
	<script src="js/salesOrder.js"></script> 	
  </body>
</html>
