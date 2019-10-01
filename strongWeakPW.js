// function strong(str) {
//   // at least one number, one lowercase and one uppercase letter
//   // at least six characters
//   var weak = /(?=.*[a-z])/;
//   var lessWeak = /(?=.*[a-z])(?=.*[A-Z])/; 
//   var medium = /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])/;
//   var strong = /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{6,}/;
//   return strong.test(str);
// }

var weak = /(?=.*[a-z])/;
var lessWeak = /(?=.*[a-z])(?=.*[A-Z])/;
var medium = /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])/;
var strong = /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{6,}/;

$( document ).ready(function() {
  
  const changeText = function (el, text, color) {
    el.text(text).css('color', color);
  };
  
  $('#pw').keyup(function(){
    
    let len = this.value.length;
    let str = this.value;
    const pbText = $('.auth .progress-bar_text');

    if (len === 0) {
      $('.auth .progress-bar_item').each(function() {
        $(this).removeClass('active')
      });
      $('.auth .active').css('background-color', 'transparent');
      changeText(pbText, 'Password is blank');
    } else if (strong.test(str)) {
      $('.auth .progress-bar_item').each(function () {
        $(this).addClass('active');
      });
      $('.auth .active').css('background-color', '#2DAF7D');
      changeText(pbText, 'Strong password');
    } else if (weak.test(str)) {
      $('.auth .progress-bar_item-2').addClass('active');
      $('.auth .progress-bar_item-3').removeClass('active');
      $('.auth .active').css('background-color', '#F9AE35');
      changeText(pbText, 'Could be stronger');
    } else {
      $('.auth .progress-bar_item-1').addClass('active');
      $('.auth .progress-bar_item-2').removeClass('active');
      $('.auth .progress-bar_item-3').removeClass('active');
      $('.auth .active').css('background-color', '#FF4B47');
      changeText(pbText, 'Too weak');
    } 
  });
  
});
  
