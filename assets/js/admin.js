document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  const mainWrapper = document.getElementById("mainWrapper");
  const menuIcon = document.querySelector(".menu-icon");

  // Sidebar toggle
  menuIcon.addEventListener("click", function () {
    sidebar.classList.toggle("active");
    mainWrapper.classList.toggle("shifted");
  });

  // Dropdown toggle
  document.querySelectorAll(".dropdown > a.nav-link").forEach(dropdown => {
    dropdown.addEventListener("click", function (e) {
      e.preventDefault();
      this.parentElement.classList.toggle("open");
    });
  });
});
