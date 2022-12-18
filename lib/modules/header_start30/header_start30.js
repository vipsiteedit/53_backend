var header_start30_execute = function(params){ 
  var minus = 0;
  $(document).ready(function(){
             minus = 30;
             var widthsearch = parseInt($('#top_b_header .row').css('width')) - minus - parseInt($('.searchbut').css('width')) + 'px';
             $('#section-header .livesearch').css('width',widthsearch);
             var heightsearch = parseInt($('#top_b_header .row').css('height'));
             $('#section-header .livesearch').css('height',heightsearch);
             var widthsearch = parseInt($('#top_b_header .row').css('width')) - minus - parseInt($('.searchbut').css('width')) + 'px';
             $('#section-header .search-head').css('width',widthsearch);
             var heightsearch = parseInt($('#top_b_header .row').css('height'));
             $('#section-header .search-head').css('min-height',heightsearch);
             $('#section-header .suggestions').css('margin-top',parseInt(heightsearch) + 'px');
   });
        
   $(window).resize(function(){
             if($(window).width() > 767) {
                 minus = 30;
             }
             else {
                 minus = 30;
             }
             var widthsearch = parseInt($('#top_b_header .row').css('width')) - minus - parseInt($('.searchbut').css('width')) + 'px';
             $('#section-header .livesearch').css('width',widthsearch);
             var heightsearch = parseInt($('#top_b_header .row').css('height'));
             $('#section-header .livesearch').css('height',heightsearch);
             var widthsearch = parseInt($('#top_b_header .row').css('width')) - minus - parseInt($('.searchbut').css('width')) + 'px';
             $('#section-header .search-head').css('width',widthsearch);
             var heightsearch = parseInt($('#top_b_header .row').css('height'));
             $('#section-header .search-head').css('min-height',heightsearch);
             $('#section-header .suggestions').css('margin-top',parseInt(heightsearch)  + 'px');
   });

   
   function show_search() { 
      $('#section-header .searchbut').addClass('trigger-close');
      $('#section-header .search-head').css('display','block');
      $('#section-header .livesearch').animate({right: "0px"}, 300, function(){
          $('.suggestions, .search-head .buttonSend').css('display','block');
      });       
   }
   
   function hide_search() { 
      $('#section-header .searchbut').removeClass('trigger-close');
      $('#section-header .suggestions').css('display','none');
      $('#section-header .livesearch').animate({right: "-1281px"}, 300, function(){
          $('#section-header .search-head').css('display', 'none');          
      });
      $('#section-header .suggestions, #section-header .search-head .buttonSend').css('display','none');                     
      
   }    
    
   $('.searchbut').click(function(){
        if(!$(this).hasClass('trigger-close')) {
            clearTimeout($.data(this, 'slideTimer'));
            $.data(this, 'slideTimer', setTimeout(function() {
                show_search();
            }, 250));
        } else {
            clearTimeout($.data(this, 'slideTimer'));
            $.data(this, 'slideTimer', setTimeout(function() {
                hide_search();
            }, 250));
        }           
   });
        
}
