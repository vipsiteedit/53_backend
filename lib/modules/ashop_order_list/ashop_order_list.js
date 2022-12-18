var ashop_order_list_execute = function(params){ 

$(document).ready(function(){

  var allPanels = $('#cabinet-tabs .tab-content'),
      thisPanel;
    
  $('#cabinet-tabs .cabinet-tab button').click(function() {
        thisPanel = $(this).closest('.cabinet-tab').next();
        
        if(thisPanel.hasClass('slideDown') == false){
            allPanels.slideUp().removeClass('slideDown');
            thisPanel.slideDown().addClass('slideDown');
        }    

        return false;
  });
});
}
