$(function() {
    
    $('.lang_switcher').on('change', function() {
     	 window.location.replace("/language/" + $(this).val());
  });
});