  document.addEventListener("DOMContentLoaded", function () {
    var headerContainer = document.getElementById("public-navbar");
    var pageHeaderBottom = document.getElementById("page-header").getBoundingClientRect().bottom;
    console.log(pageHeaderBottom);
    window.onscroll = function () {
      var scrollPosition = window.scrollY;

      if (scrollPosition >= pageHeaderBottom) {
        headerContainer.classList.add("show-nav");
      } else {
        headerContainer.classList.remove("show-nav");
      }
    };
  });

