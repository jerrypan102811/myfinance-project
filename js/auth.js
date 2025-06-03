function saveUser(username, email, password) {
  let users = JSON.parse(localStorage.getItem("users") || "{}");
  users[username] = { email, password };
  localStorage.setItem("users", JSON.stringify(users));
}

function validateUser(username, password) {
  let users = JSON.parse(localStorage.getItem("users") || "{}");
  return users[username] && users[username].password === password;
}

document.addEventListener("DOMContentLoaded", () => {
  const regForm = document.getElementById("registerForm");
  const loginForm = document.getElementById("loginForm");

  if (regForm) {
    regForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const u = document.getElementById("regUsername").value;
      const e_ = document.getElementById("regEmail").value;
      const p = document.getElementById("regPassword").value;
      saveUser(u, e_, p);
      alert("Registered successfully! Please log in.");
      window.location.href = "login.html";
    });
  }

  if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const u = document.getElementById("loginUsername").value;
      const p = document.getElementById("loginPassword").value;
      if (validateUser(u, p)) {
        localStorage.setItem("currentUser", u);
        alert("Welcome back, " + u + "!");
        window.location.href = "myfinance.html";
      } else {
        alert("Invalid credentials");
      }
    });
  }
});

function logoutUser() {
  localStorage.removeItem("currentUser");
  alert("You have been logged out.");
  window.location.href = "login.html";
}

document.addEventListener("DOMContentLoaded", () => {
  const currentUser = localStorage.getItem("currentUser");
  const needLoginPages = ["myfinance.html"];
  const currentPage = window.location.pathname.split("/").pop();
  if (needLoginPages.includes(currentPage) && !currentUser) {
    alert("Please login first.");
    window.location.href = "login.html";
  }
});