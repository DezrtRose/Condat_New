$(function(){
  $("#bars li .bar").each(function(key, bar){
    var applications = $(this).data('applications');
    if (applications>28){
    	applications=28;
    }
    var percentage=applications/32*100;


    $(this).animate({
      'height':percentage+'%'
    }, 1000);
  })
})
