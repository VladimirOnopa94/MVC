$(function() {
	var csrftoken = $('meta[name=csrf-token]').attr('content');
    
	$('.lang_switcher').on('change', function() {
		 window.location.replace("/language/" + $(this).val());
	});

	$.ajax({
	  url: "/signin",
	  data: {email:'test@mail.ru',password:'testpass'},
	  
	   type: 'POST',
	  success: function(){
	  }
	});    
  

});