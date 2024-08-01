
// Gọi hàm adjustProductLayout khi trang được tải
function toggleFilter(filterId) {
  const filterContent = document.getElementById(filterId);
  filterContent.classList.toggle('collapsed');

}

// Zoom ảnh
document.addEventListener("DOMContentLoaded", function() {
  const wrapper = document.querySelector(".image-wrapper");
  const zoomFrame = document.querySelector(".zoom-frame");
  const zoomedImage = document.querySelector(".zoomed-image");
  const zoomRatio = 3; // Đặt tỉ lệ zoom là 1.5

  const image4Icon = document.querySelector(".image-4-icon");

  wrapper.addEventListener("mousemove", function(event) {
    // Tính vị trí của mouse với ảnh image-4-icon
    const offsetX = event.clientX - image4Icon.getBoundingClientRect().left;
    const offsetY = event.clientY - image4Icon.getBoundingClientRect().top;

    // Tính vị trí của hình ảnh zoom lên 
    const zoomX = offsetX * zoomRatio;
    const zoomY = offsetY * zoomRatio;

    // Update vị trí zoomFrame 
    const frameWidth = zoomFrame.offsetWidth;
    const frameHeight = zoomFrame.offsetHeight;
    const frameLeft = Math.min(Math.max(offsetX - frameWidth / 2, 0), image4Icon.width - frameWidth);
    const frameTop = Math.min(Math.max(offsetY - frameHeight / 2, 0), image4Icon.height - frameHeight);
    zoomFrame.style.left = `${frameLeft}px`;
    zoomFrame.style.top = `${frameTop}px`;

    // Update vị trí ảnh trong khung zoomFrame
    zoomedImage.style.transform = `translate(-${zoomX}px, -${zoomY}px) scale(${zoomRatio})`;
  });

  wrapper.addEventListener("mouseenter", function() {
    zoomFrame.style.display = "block";
  });

  wrapper.addEventListener("mouseleave", function() {
    zoomFrame.style.display = "none";
    zoomedImage.style.transform = "none";
  });
});

// Button số lượng
function totalClick(click) {
  const sum = document.getElementById('number');
  const sumValue = parseInt(sum.innerText) + click;
  console.log(sumValue + click);


  a = document.getElementById('number');
  console.log(a);

  sum.innerText = sumValue;

  //để số dương chứ không phải không âm
  if(sumValue <=1) {
    sum.innerText = 1;

    document.getElementById('input-quantity').value = 1;
  }
  else document.getElementById('input-quantity').value = sum.innerText;

}

//Button Thích 
const likeButton = document.getElementById("likeButton");
const likeBtn = document.getElementById("likeBtn");

let isLiked = false;

likeBtn.addEventListener("click", function() {
  if (!isLiked) {
    likeButton.style.backgroundColor = "pink";
    isLiked = true;
  } else {
    likeButton.style.backgroundColor = "transparent";
    isLiked = false;
  }
});


//Button Like comment 
document.getElementById("likeButtonComment").addEventListener("click", function() {
  var likeText = this.querySelector('.like-text');
  if (likeText.textContent === 'Like') {
      likeText.textContent = 'Liked';
      likeText.style.color = 'pink';
  } else {
      likeText.textContent = 'Like';
      likeText.style.color = ''; // Reset to default color
  }
});


// Hàm tạo star rating and comment box
createStarRating(5); 
createCommentBox();

document.addEventListener("DOMContentLoaded", function() {
  const stars = document.querySelectorAll(".star-cmt");

  stars.forEach(function(star) {
    star.addEventListener("click", function() {
      const value = parseInt(star.getAttribute("data-value"));
      resetStars();
      highlightStars(value);
    });
  });

  function resetStars() {
    stars.forEach(function(star) {
      star.classList.remove("active");
    });
  }

  function highlightStars(value) {
    for (let i = 0; i < value; i++) {
      stars[i].classList.add("active");
    }
  }
});


// Hàm tạo số lượng star icons dựa trên rating
function generateStars(rating) {
  const starWrapper = document.getElementById('star-rating');
  starWrapper.innerHTML = ''; // Clear previous stars
  
  for (let i = 0; i < 5; i++) {
    const star = document.createElement('span');
    star.classList.add('fa', 'fa-star', 'star');
    if (i < rating) {
      star.classList.add('checked');
    }
    starWrapper.appendChild(star);
  }
}

// Event để dropdown change
document.getElementById('star-dropdown').addEventListener('change', function() {
  const selectedRating = parseInt(this.value);
  generateStars(selectedRating);
});


//Nút Bình luận 
document.getElementById('comment-button').addEventListener('click', function() {
  // Lấy dữ liệu từ input 
  const comment = document.getElementById('comment-section').value;
  const rating = document.getElementById('star-dropdown').value;
  const productId = document.getElementById('product-id').value;
  // Thêm giá trị vào dữ liệu trong form
  const form = document.getElementById('review-form');
  const commentInput = document.createElement('input');
  commentInput.type = 'hidden';
  commentInput.name = 'comment';
  commentInput.value = comment;
  form.appendChild(commentInput);
  
  const ratingInput = document.createElement('input');
  ratingInput.type = 'hidden';
  ratingInput.name = 'rating';
  ratingInput.value = rating;
  form.appendChild(ratingInput);
  // Submit the form
  form.submit();
});