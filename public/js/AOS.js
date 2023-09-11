window.addEventListener('scroll', () => {


  const reveals = document.querySelectorAll('.reveal')

  reveals.forEach(reveal => {
    let height = window.innerHeight;
    let revealTop = reveal.getBoundingClientRect().top;
    let revealPoint = 150;

    if (revealTop < height - revealPoint) {
      reveal.classList.add('active');
    } else {
      reveal.classList.remove('active');
    }
  })


})