document.addEventListener("DOMContentLoaded", function() {
  document.querySelector('.j-rcb').addEventListener("click", redlum_contact_box_open);

  function redlum_contact_box_open() {
    Array.from(document.getElementsByClassName('rcb')).forEach(function(item) {
      item.classList.toggle("visible");
    });
  }

});
