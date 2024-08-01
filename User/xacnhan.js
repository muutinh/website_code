function init() {
    var firstname = document.getElementById("hovaten");
    var company = document.getElementById("tencongty");
    var address = document.getElementById("diachi");
    var city = document.getElementById("thanhpho");
  
    firstname.textContent = sessionStorage.hoten;
    company.textContent = sessionStorage.congty;
    address.textContent = sessionStorage.diachi + " Quan " + sessionStorage.diachiDuong;
    city.textContent = sessionStorage.thanhpho;
  }
  
  function goback() {
    history.back();
  }
  
  window.onload = init;