// Gọi hàm adjustProductLayout khi trang được tải

function toggleFilter(filterId) {
  const filterContent = document.getElementById(filterId);
  filterContent.classList.toggle('collapsed');

}

// Hàm tăng giảm số lượng 
document.addEventListener("DOMContentLoaded", function() {
  const btnMinus = document.querySelector(".btn-minus");
  const btnPlus = document.querySelector(".btn-plus");
  const inputQuantity = document.querySelector(".input-quantity");

  btnMinus.addEventListener("click", function() {
    let currentValue = parseInt(inputQuantity.value);
    if (currentValue > 1) {
      inputQuantity.value = currentValue - 1;
    }
  });

  btnPlus.addEventListener("click", function() {
    let currentValue = parseInt(inputQuantity.value);
    inputQuantity.value = currentValue + 1;
  });
});

//Hàm pop-up Thêm giỏ hàng thành công 
document.addEventListener("DOMContentLoaded", function() {
  const addToCartBtn = document.getElementById("add-to-cart-btn");
  const popup = document.getElementById("popup");

  addToCartBtn.addEventListener("click", function() {
    popup.style.display = "block";
    popup.style.zIndex = "9999"; // Thiết lập zIndex để đảm bảo popup hiển thị trên cùng
    setTimeout(function() {
      popup.style.display = "none";
    }, 2000); // 2 seconds
  });
});
