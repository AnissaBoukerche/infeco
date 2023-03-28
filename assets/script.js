const navLink = document.querySelectorAll('.nav-link');
navLink.forEach((el) => {
  el.addEventListener('click', (e) => {
    navLink.forEach((el) => el.classList.remove('active'));
    el.classList.add('active');
  });
});
