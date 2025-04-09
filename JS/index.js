document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("loginForm");
    const errorSpan = document.getElementById("error");
  
    form.addEventListener("submit", function (e) {
      e.preventDefault();
  
      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value.trim();
      errorSpan.textContent = "";
  
      fetch("login.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          window.location.href = data.redirect; // ✅ Redirect from JS
        } else {
          errorSpan.textContent = data.message;
        }
      })
      .catch(() => {
        errorSpan.textContent = "Something went wrong.";
      });
    });
  });
  