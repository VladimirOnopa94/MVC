$(function() {
	//get csrf token 
	var csrftoken = $('meta[name=csrf-token]').attr('content');
    
	//set title main page
	/*$( "#main_page" ).on( "click", function() {
		$('.main.container').html('<h2>Main</h2>');
	});*/

	//Ajax request get contacts list 
	//build html phonebook page
	$( "#phonebook_page" ).on( "click", function() {
		$.ajax({
		  url: "/phonebook",
		  type: 'GET',
		  success: function(data){

		  	var data = JSON.parse(data);

		  	$innerText = '\
		  	<h2>' + data.page + '</h2>';
		  		if (data.data) {

				$innerText += '<div class="container-fluid">';

				$.each(data.data,function( e,v ) {
					 $innerText += '<div class="contact_item row">\
				        <div class="col-md-4">\
				          <span>' + e + '.</span>\
				          <span>' + v.name + '</span>\
				          <span>';
				          if (v.phones != '') {
				          	 $innerText += v.phones[0];
				          }
				          $innerText += '</span>\
				          <span class="hide_btn">View details</span>\
				        </div>  \
				        <div class="full_info col-md-12 d-none">\
				            <div class="col-md-4">\
				              <span>Address</span>\
				              <div>\
				                ' + v.address + '<br>\
				                ' + v.city + '<br>\
				                ' + v.country + '\
				              </div>\
				             </div>\
				            <div class="col-md-4 phones">\
				              <span>Phone numbers</span>\
				              <div>';
				              if (v.phones != '') {
			              		$.each(v.phones,function( el,phone ) {
					              	$innerText += '<div>' + phone +'</div>';
								});
				              }else{
				              	$innerText += '<div>No phones</div>';
				              }
					            
				              $innerText += '</div>\
				            </div>\
				            <div class="col-md-4 emails">\
				              <span>Emails</span>\
				              <div>';
				                 if (v.emails != '') {
				              		 $.each(v.emails,function( el,email ) {
						              	$innerText += '<div>' + email +'</div>';
									});
					              }else{
					              	$innerText += '<div>No emails</div>';
					              }
				              $innerText += '</div>\
				            </div>\
				        </div>\
				      </div>';
				});

				$innerText += '</div>';

				}else{
					$innerText += '<span>No contacts</span>';
				}

				$('.main.container').html($innerText);

				//Toggle block show more info
				$( ".contact_item .hide_btn" ).on( "click", function() {
				  var container = $(this).parent().parent().find('.full_info');
				  $(container).toggleClass('d-none');

				  if ($(container).hasClass('d-none')) {
				  	$(this).text('View details');
				  }else{
				  	$(this).text('Hide details');
				  }
				});
		  }
		}); 
	});


	

  

});