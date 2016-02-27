$(document).ready(function(){
		$('#add-inventory-form').validate({
	    rules: {
			
		 purchase_id: {
	        required: true,
			minlength: 10,
			maxlength: 12
	      },
		  
		 supplier_id: {
	        required: true,
			minlength: 10,
			maxlength: 12
	      },
		  
	       purchase_date: {
	        required: true,
	       required: true
	      },
		  
		 sku: {
	        minlength: 6,
	        required: true
	      },
		  
		  title: {
				required: true,
				minlength: 10
			},
			supplier: {
				required: true,
				minlength: 5
			},
		  
		   cost_price: {
	      	minlength: 1,
	        required: true
	      },
		  
	     
		   quantity: {
	      	minlength: 1,
	        required: true
	      },
		  
		  

		  
	    },
		
		messages: {
			purchase_id: "Please enter any alphanumeric string between 10 to 12 characters.",
			supplier_id: "Please enter any alphanumeric string between 10 to 12 characters.",
			purchase_date: "Please select a date from datepicker."
		},
		
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });


		$('#add-salesorder-form').validate({
	    rules: {
			
		 sale_id: {
	        required: true,
			minlength: 10,
			maxlength: 12
	      },

		 order_id: {
	        required: true,
			minlength: 10,
			maxlength: 12
	      },
		  
	       sale_date: {
	       required: true
	      },
		  
		 sku: {
	        required: true
	      },
		  
		  title: {
				required: true,
				minlength: 10
			},
			supplier: {
				required: true,
				minlength: 5
			},
		  
		   cost_price: {
	      	minlength: 1,
	        required: true
	      },
		  
		   sale_price: {
	      	minlength: 1,
	       required: true
	      },		  
		  
	     
		   quantity_purchased: {
	      	minlength: 1,
	        required: true
	      },
		  
		   profit_retained: {
	      	minlength: 1,
	        required: true
	      },		  

		  
	    },
		
		messages: {
			sale_id: "Please enter any alphanumeric string between 10 to 12 characters.",
			order_id: "Please enter any alphanumeric string between 10 to 12 characters.",
			sale_date: "Please select a date from datepicker."
		},
		
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });
}); // end document.ready