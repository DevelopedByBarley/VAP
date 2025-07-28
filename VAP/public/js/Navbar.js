document.addEventListener("DOMContentLoaded", function () {
  var headerContainer = document.getElementById("public-navbar");
  var currentPath = window.location.pathname; // Ebben tárolódik majd a jelenlegi útvonal
  var pagesWithAnimation = currentPath === "/" || currentPath === "/user/dashboard"; // Ellenőrizzük, hogy a jelenlegi útvonal "/"-e

  if (pagesWithAnimation) {
    window.onscroll = function () {
      var scrollPosition = window.scrollY;

      if (scrollPosition > 0) {
        headerContainer.classList.add("show-nav");
      } else {
        headerContainer.classList.remove("show-nav");
      };
    }
  } else {
    headerContainer.classList.add("show-nav");
  }
});