let pLogo = document.getElementById('login-logo');
let originalTransform = getComputedStyle(pLogo).transform;
let loginCon = document.getElementById('user-login-con');

loginCon.addEventListener('mousemove', parallax);
loginCon.addEventListener('mouseout', resetTransform);


function parallax(e) {
  let x = (e.clientX - pLogo.getBoundingClientRect().left) / pLogo.offsetWidth - 0.5;
  let y = (e.clientY - pLogo.getBoundingClientRect().top) / pLogo.offsetHeight - 0.5;

  // Számítsa ki a 3D forgás szögeit
  let rotateX = y * 10; // 20 fokos elforgatás az Y tengely körül
  let rotateY = x * 10; // 20 fokos elforgatás az X tengely körül

  pLogo.style.transform = "translateX(" + x * 10 + "px) translateY(" + y * 10 + "px) rotateX(" + rotateX + "deg) rotateY(" + rotateY + "deg)";
}

function resetTransform() {
  pLogo.style.transform = originalTransform;
}