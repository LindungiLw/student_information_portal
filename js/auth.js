document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("loginForm");

  if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const emailInput = document.getElementById("email").value;

      if (emailInput.endsWith("@jiu.ac")) {
        if (emailInput === "admin@jiu.ac") {
          alert("Welcome, JIU Student Portal Admin!");
          window.location.href = "admin/dashboard.html";
        } else {
          alert("Login successful! Welcome to the Student Portal.");
          window.location.href = "pages/home.html";
        }
      } else {
        alert("Access denied! Please use your campus email (@jiu.ac).");
      }
    });
  }
});
