$(document).ready(function(){
    $('#toggle').click(function(){
      $('nav').slideToggle();
    });

    // Thêm sự kiện toggle sub-menu khi click vào tiêu đề của menu
    $('#main-menu li').click(function(){
        $(this).children('ul.sub-menu').slideToggle();
    });

  //   $('#main-menu li').click(function(event) {
  //     if ($(this).hasClass('product')) {
  //         event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
  //         $(this).toggleClass('submenu-active').siblings().removeClass('submenu-active');
  //     }
  // });
  })