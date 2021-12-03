$(function() {
//
//Файл перевода для js (js/translate.json)
//
const translate = translateMessege;
//console.log(translate.ru_header);
//
//
//
//


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
		  method: 'GET',
		  success: function(data){

		  	var data = JSON.parse(data);
		  	

				$('.main.container').html(data);

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