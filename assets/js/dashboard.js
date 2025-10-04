document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  const mainWrapper = document.getElementById("mainWrapper");
  const menuIcon = document.querySelector(".menu-icon");

  menuIcon.addEventListener("click", function () {
    sidebar.classList.toggle("active");
    mainWrapper.classList.toggle("shifted");
  });

  // Dropdown Toggle
  document.querySelectorAll(".dropdown > a.nav-link").forEach(dropdown => {
    dropdown.addEventListener("click", function (e) {
      e.preventDefault();
      const container = this.nextElementSibling;
      container.style.display = (container.style.display === "flex") ? "none" : "flex";
    });
  });
});