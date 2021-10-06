$(function() {
	//get csrf token 
	var csrftoken = $('meta[name=csrf-token]').attr('content');
    
	//set title main page
	$( "#main_page" ).on( "click", function() {
		$('.main.container').html('<h2>Main</h2>');
	});

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

	//build html mycontact page
	$( "#mycontact_page" ).on( "click", function() {
		$.ajax({
		  url: "/mycontact",
		  type: 'GET',
		  success: function(data){

		  	var data = JSON.parse(data);
		  	var info = data.data;
		  	var countries = data.countries;

		  	$innerText = '\
		  	<h2>' + data.page + '</h2>';
		  		if (info) {
					$innerText = '<form id="mycontact_form" class="container-fluid">\
						<div class="row">\
							<label>\
								Publish my contact';
								var checked = '';
								if (parseInt(info.publish_contact) == 1) {
									checked = 'checked';
								}
								$innerText += '<input type="checkbox" ' + checked + ' name="publish_contact">';
							$innerText += '</label>\
						</div>\
						<div class="row">\
							<div class="col-md-4 main_info">\
								<span>Contact</span>\
								<div>\
									<label for="firstname_inp">Firstname</label>\
									<input type="text" id="firstname_inp" name="firstname" placeholder="Firstname" value="' + info.name + '">\
								</div>\
								<div>	\
									<label for="lastname_inp">Lastname</label>\
									<input type="text" id="lastname_inp" name="lastname" placeholder="Lastname" value="' + info.lastname + '">\
								</div>\
								<div>\
									<label for="address_inp">Address</label>\
									<input type="text" id="address_inp" name="address" placeholder="Address" value="' + info.address + '">\
								</div>\
								<div>\
									<label for="city_inp">Zip/City</label>\
									<input type="text" id="city_inp" name="city" placeholder="City" value="' + info.city + '">\
								</div>\
								<div>\
									<label for="country_select">Country</label>\
									<select name="country" id="country_select">';
										 $.each(countries,function( el,country ) {
										 	var selected = '';
										 	if (country.id == info.country) { 
										 		selected = 'selected';
										 	}
							              	$innerText += '<option ' + selected + ' value="' + country.id + '">' + country.name + '</option>';
										});
									$innerText += '</select>\
								</div>\
							</div>\
							<div class="col-md-4">\
								<span>Phones</span>\
								<div class="phone_list_container">';
									$.each(info.phones,function( el,phone ) {
										var checked = '';
										if (phone.is_show == 1) {
											 checked = 'checked';
										}
									 	$innerText += '<div>\
											<input type="tel" name="phone[' + el + '][value]" value="' + phone.phone + '" placeholder="+38(099)999-99-99">\
											<input type="checkbox" ' + checked + ' name="phone[' + el + '][is_show]">\
										</div>';
									});
								$innerText += '</div>\
								<span id="add_phone">Add</span>\
							</div>\
							<div class="col-md-4">\
								<span>Emails</span>\
								<div class="emails_list_container">';
									$.each(info.emails,function( el,email ) {
										var checked = '';
										if (email.is_show == 1) {
											 checked = 'checked';
										}
									 	$innerText += '<div>\
											<input type="email" name="email[' + el + '][value]" value="' + email.email + '" placeholder="test@gmail.com">\
											<input type="checkbox" ' + checked + ' name="email[' + el + '][is_show]">\
										</div>';
									});
								$innerText += '</div>\
								<span id="add_email">Add</span>\
							</div>\
						</div>\
						<button>Save</button>\
					</form>';

				}

				$('.main.container').html($innerText);

				//add new phone field to list
				$( "#add_phone" ).on( "click", function() {
					var number = $('.phone_list_container>div').length + 1;
					var element = '<div>\
						<input type="tel" name="phone[' + number + '][value]" placeholder="+38(099)999-99-99">\
						<input type="checkbox"  name="phone[' + number + '][is_show]">\
					</div>';
					$('.phone_list_container').append(element);
				});
 
				//add new email field to list
				$( "#add_email" ).on( "click", function() {
					var number = $('.emails_list_container>div').length + 1;
					var element = '<div>\
						<input type="email" name="email[' + number + '][value]" placeholder="test@gmail.com">\
						<input type="checkbox"  name="email[' + number + '][is_show]">\
					</div>';
					$('.emails_list_container').append(element);
				});

				//Save data
				$( "#mycontact_form" ).on( "submit", function( event ) {
				  event.preventDefault();
				  var data = $( this ).serializeArray();
				  data.push({name: "token", value: csrftoken});
				  $.ajax({
					  url: "/savecontact",
					  type: 'POST',
					  data: $.param(data),
					  success: function(data){
					  	alert('Success!');
					  }
					});
				});

				//phone mask
				$('.phone_list_container input[type="tel"]').mask('+38(099)999-99-99');

				
		  }
		}); 
		
	});

	

  

});