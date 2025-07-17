<?php
require 'fungction.php';

if(!isset($_SESSION['login'])){

} else{
    header('location:index.php');
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Login</title>
    
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="assets/template/light/css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="assets/template/light/css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="assets/template/light/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="assets/template/light/css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="assets/template/light/css/app-dark.css" id="darkTheme" disabled>
  </head>
  <body class="light">
    <div class="wrapper vh-100">
      <div class="row align-items-center h-100">
        <div class="col-lg-6 d-none d-lg-flex">
          <!-- Optional image or content for left side -->
        </div> <!-- ./col -->
        <div class="col-lg-6">
          <div class="w-50 mx-auto">
            <form class="mx-auto text-center" method="post">
              <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
              <img src="assets/template/image/mylogo.png" alt="Logo" class="navbar-brand-img brand-md" style="height: 150px; width: 150px;">
              </a>
              <h1 class="h6 mb-3">Sign in T-coffe
              </h1>
              <div class="form-group">
                <label for="inputUsername" class="sr-only">Username</label>
                <input type="text" id="inputUsername" class="form-control form-control-lg" name="username" placeholder="Username" required>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control form-control-lg" name="password" placeholder="Password" required>
              </div>
              <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Let me in</button>
            </form>
          </div> <!-- .form wrapper -->
        </div> <!-- ./col -->
      </div> <!-- .row -->
    </div>

    <!-- Scripts -->
    <script src="assets/template/light/js/jquery.min.js"></script>
    <script src="assets/template/light/js/popper.min.js"></script>
    <script src="assets/template/light/js/moment.min.js"></script>
    <script src="assets/template/light/js/bootstrap.min.js"></script>
    <script src="assets/template/light/js/simplebar.min.js"></script>
    <script src="assets/template/light/js/daterangepicker.js"></script>
    <script src="assets/template/light/js/jquery.stickOnScroll.js"></script>
    <script src="assets/template/light/js/tinycolor-min.js"></script>
    <script src="assets/template/light/js/config.js"></script>
    <script src="assets/template/light/js/apps.js"></script>

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>
  </body>
</html>
