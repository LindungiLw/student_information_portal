document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("loginForm");

  if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const emailInput = document.getElementById("email").value;

      if (emailInput.endsWith("@jiu.ac")) {
        if (emailInput === "admin@jiu.ac") {
          alert("Selamat datang, Admin Portal JIU Student!");
          window.location.href = "admin/dashboard.html";
        } else {
          alert("Login berhasil! Selamat datang di Student Portal.");
          window.location.href = "pages/home.html";
        }
      } else {
        alert("Akses ditolak! Silakan gunakan email kampus (@jiu.ac).");
      }
    });
  }
});
