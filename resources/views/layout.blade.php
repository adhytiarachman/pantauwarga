<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>RT 06 RW 15 - Sistem Pendataan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- Bootstrap Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

    <!-- AOS Library -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600;800&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      display: flex;
      flex-direction: column;
    }

    body {
        font-family: 'Inter', 'Poppins', sans-serif;
    }


    .hero-section {
        background: url('/assets/images/background.png') no-repeat center center;
        background-size: cover;
        position: relative;
        z-index: 1;
    }
    .hero-section::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* semi-transparan gelap */
        z-index: -1;
    }
    
    main {
      flex: 1;
    }

    .footer {
      background-color: #f8f9fa;
      padding: 1rem 0;
      text-align: center;
      border-top: 1px solid #dee2e6;
    }

    .nav-link {
      transition: 0.3s ease;
    }

    .nav-link:hover {
      color: #0d6efd !important;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .hero {
      animation: fadeInUp 1.2s ease;
    }

    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    body {
        font-family: 'Inter', sans-serif;
    }
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .back-home-btn {
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .back-home-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .back-home-btn {
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    .back-home-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    body {
        font-family: 'Inter', 'Poppins', sans-serif;
    }

    .back-home-btn {
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    .back-home-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }


    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <main>
    @yield('content')
  </main>

  <footer class="footer">
    <small>&copy; 2025 RT 06 RW 15. All rights reserved.</small>
  </footer>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ duration: 1000, once: true });</script>

<script>
  function togglePassword() {
    const passwordField = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");

    if (passwordField.type === "password") {
      passwordField.type = "text";
      icon.classList.remove("bi-eye-slash");
      icon.classList.add("bi-eye");
    } else {
      passwordField.type = "password";
      icon.classList.remove("bi-eye");
      icon.classList.add("bi-eye-slash");
    }
  }
</script>

<script>
  function togglePassword() {
    const passwordField = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");

    if (passwordField.type === "password") {
      passwordField.type = "text";
      icon.classList.remove("bi-eye-slash");
      icon.classList.add("bi-eye");
    } else {
      passwordField.type = "password";
      icon.classList.remove("bi-eye");
      icon.classList.add("bi-eye-slash");
    }
  }
</script>


</body>
</html>
