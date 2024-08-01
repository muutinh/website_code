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

//   function search() {
//     var keyword = document.getElementById("searchInput").value;
//     if (keyword.trim() !== "") {
//         window.location.href = "product-list.php?keyword=" + encodeURIComponent(keyword);
//     }
// }

// function searchOnEnter(event) {
//   if (event.keyCode === 13) { // Kiểm tra xem phím nhấn có phải là Enter không
//       var keyword = document.getElementById("searchInput").value;
//       window.location.href = "product-list.php?keyword=" + keyword; // Chuyển hướng đến trang product-list.php với từ khóa đã nhập
//   }
// }

