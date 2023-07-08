  document.addEventListener("DOMContentLoaded", function () {
    var headerContainer = document.getElementById("public-navbar");
    window.onscroll = function () {
      var scrollPosition = window.scrollY;

      if (scrollPosition > 0) {
        headerContainer.classList.add("show-nav");
      } else {
        headerContainer.classList.remove("show-nav");
      }
    };
  });

