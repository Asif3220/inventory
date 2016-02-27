
function getDataReturned(data1, dtype) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "response.php", //Relative or absolute path to response.php file
        data: data1,
        success: function (data) {
            var jsonDataDecoded = JSON.parse(data["json"]);

            //alert(" dtype  "+dtype+" jsonDataDecoded "+ jsonDataDecoded);

            if (dtype == "cost_price") {
                var dataval = jsonDataDecoded["cost_price"];
                $("#cost_price").val(dataval);
            } else if (dtype == "supplier") {
                var dataval = jsonDataDecoded["supplier"];
                $("#supplier").val(dataval);
            } else if (dtype == "title") {
                var dataval = jsonDataDecoded["title"];
                $("#title").val(dataval);
            } else if (dtype == "quantity") {
                var dataval = jsonDataDecoded["quantity"];
                $("#quantityInHand").val(dataval);
                $("#quantity_purchased").val(dataval);
            }
            // alert("Form submitted successfully.\nReturned json: " + data["json"]);
        }
    });
}


var retVal = "";
$(document).ready(function () {
    $('pre').addClass('prettyprint linenums');
	
	

    $("#sku").focusout(function () {

        /**get  supplier **/
        var data2 = {
            "action": "supplier"
        };
        data2 = $(this).serialize() + "&" + $.param(data2);
        getDataReturned(data2, "supplier");
        /**get  supplier **/

        /**get  title **/
        var data3 = {
            "action": "title"
        };
        data3 = $(this).serialize() + "&" + $.param(data3);
        getDataReturned(data3, "title");
        /**get  title **/

        /**get  cost_price **/
        var data1 = {
            "action": "cost_price"
        };
        data1 = $(this).serialize() + "&" + $.param(data1);
        getDataReturned(data1, "cost_price");
        /**get  cost_price **/

        /**get  quantity **/
        var data4 = {
            "action": "quantity"
        };
        data4 = $(this).serialize() + "&" + $.param(data4);
        getDataReturned(data4, "quantity");
        /**get  quantity **/

    });

    $('#quantity_purchased').focusout(function () {
        var quantityInHand = $('#quantityInHand').val();
        var quantity_purchased = $(this).val();
        var sale_price = $('#sale_price').val();
        var cost_price = $('#cost_price').val();
        //if (quantityInHand != null && quantityInHand != "" && quantityInHand < quantity_purchased) {
		if (quantityInHand != null && quantityInHand != "") {
			//alert(" quantity_purchased "+quantity_purchased+"  quantityInHand "+ quantityInHand );
			if(Number(quantity_purchased)>Number(quantityInHand)){
				$('#quantity_purchased').val(quantityInHand);
				alert("There only " + quantityInHand + " items left in inventory");
				return false;
			}
        }

        if (quantity_purchased != null && quantity_purchased != "" && sale_price != null && sale_price != "" && cost_price != null && cost_price != "") {
            $('#profit_retained').val(quantity_purchased * (parseInt(sale_price) - parseInt(cost_price)));
        }
		if($('#profit_retained').val()>0){
			var decimalValue = $('#profit_retained').val().indexOf("."); 
			if(decimalValue==-1){					
				$('#profit_retained').val($('#profit_retained').val()+".00");
			}				
		}			
    });


    $('#sale_price').focusout(function () {
        var quantity_purchased = $('#quantity_purchased').val();
        var sale_price = $(this).val();
        var cost_price = $('#cost_price').val();
        if (sale_price <= cost_price) {
            $('#sale_price').val("");
            alert("Please set sale price greater than cost price!");
            return false;
        }
		if($('#sale_price').val()>0){
			var decimalValue = $('#sale_price').val().indexOf("."); 
			if(decimalValue==-1){					
				$('#sale_price').val($('#sale_price').val()+".00");
			}				
		}
        if (quantity_purchased != null && quantity_purchased != "" && sale_price != null && sale_price != "" && cost_price != null && cost_price != "") {
            $('#profit_retained').val(quantity_purchased * (parseInt(sale_price) - parseInt(cost_price)));
        }
		if($('#profit_retained').val()>0){
			var decimalValue = $('#profit_retained').val().indexOf("."); 
			if(decimalValue==-1){					
				$('#profit_retained').val($('#profit_retained').val()+".00");
			}			
		}		
    });

    $('#quantity_purchased').keyup(function () {
        var sale_price = $('#sale_price').val();
        var quantity_purchased = $(this).val();
        var cost_price = $('#cost_price').val();
        if (quantity_purchased != null && quantity_purchased != "" && sale_price != null && sale_price != "" && cost_price != null && cost_price != "") {
            $('#profit_retained').val(quantity_purchased * (parseInt(sale_price) - parseInt(cost_price)));
        }
		if($('#profit_retained').val()>0){
			var decimalValue = $('#profit_retained').val().indexOf("."); 
			if(decimalValue==-1){					
				$('#profit_retained').val($('#profit_retained').val()+".00");
			}			
		}			
    });

    $('#total_cost').keyup(function () {
        var cost_price = $('#cost_price').val();
        var quantity_purchased = $('#quantity_purchased').val();
        var sale_price = $('#sale_price').val();
        if (quantity_purchased != null && quantity_purchased != "" && sale_price != null && sale_price != "" && cost_price != null && cost_price != "") {
            $('#profit_retained').val(quantity_purchased * (parseInt(sale_price) - parseInt(cost_price)));
        }
		if($('#profit_retained').val()>0){
		var decimalValue = $('#profit_retained').val().indexOf("."); 
		if(decimalValue==-1){					
			$('#profit_retained').val($('#profit_retained').val()+".00");
		}
			
		}			
    });

    $('#salesSaveButton').click(function () {
        var profit_retained = $('#profit_retained').val();
        if (profit_retained <= 0) {
            $('#profit_retained').val("");
            alert("Please check the profit value went down - seems the sale price set below cost price!");
            return false;
        }
    });

    $('#salesResetForm').click(function () {
        $('#add-salesorder-form').reset();
    });
	
	


});