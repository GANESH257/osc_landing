$(function() {
  
    var marquee = $('.marquee');
    var ul = $('.marquee ul');
    
    var cloneContent = function() {
  
      var doClone = true;
      var clone_ul = function () {
         ul.find('li').clone().appendTo( ul );
      }
      var check_ul_width = function() {
        if(marquee.width() > ul.width() ) {
          clone_ul();
          return;
        }
        doClone = false;
        ul.css('visibility', 'visible');
      }
  
      do {
        check_ul_width();
        var mw = marquee.width();
        var uw = ul.width();
      } while (doClone);
  
    }
  
    cloneContent();
    
     
  $('.marquee').marquee({
      //duration in milliseconds of the marquee
      duration:8000,
      duplicated: true
  });
  
    
  });