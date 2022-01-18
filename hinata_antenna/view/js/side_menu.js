$(function() {

  //サイドメニュー
  $('.sidemenu').on('click', function() {

    if($('.sidemenu-wrap').hasClass('open')){

      $('.sidemenu-button').attr('src','img/open.svg');
      $('.sidemenu-wrap').removeClass('open');


    }else{

      $('.sidemenu-button').attr('src','img/close.svg');
      $('.sidemenu-wrap').addClass('open');

    }


  });


});
