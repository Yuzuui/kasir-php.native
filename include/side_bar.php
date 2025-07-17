<!-- Top Navbar -->
<nav class="topnav navbar navbar-light bg-light shadow-sm">
  <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
    <i class="fe fe-menu navbar-toggler-icon"></i>
  </button>
  <ul class="nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button"
         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="avatar avatar-sm mt-2">
          <img src="assets/template/light/assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle shadow-sm">
        </span>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="logout.php">Logout</a>
        <a class="dropdown-item" href="#">Settings</a>
      </div>
    </li>
  </ul>
</nav>

<!-- Sidebar -->
<aside class="sidebar-left border-right shadow-sm" id="leftSidebar" data-simplebar style="background-color: #f8f5f2;">
  <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
    <i class="fe fe-x"><span class="sr-only"></span></i>
  </a>
  <nav class="vertnav navbar navbar-light">
    <!-- Logo -->
    <div class="w-100 my-4 text-center">
      <a class="navbar-brand mx-auto d-block" href="index.html">
        <img src="assets/template/image/mylogo.png" alt="T Coffe Logo" style="height: 50px;">
        <p class="mt-2 mb-0 font-weight-bold text-brown">T Coffe</p>
      </a>
    </div>

    <!-- Menu -->
    <ul class="navbar-nav flex-fill w-100 mb-2">
      <li class="nav-item w-100">
        <a class="nav-link" href="index.php">
          <i class="fe fe-home fe-16"></i>
          <span class="ml-3 item-text">Dashboard</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="pesanan.php">
          <i class="fe fe-shopping-bag fe-16"></i>
          <span class="ml-3 item-text">Pesanan</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="stok.php">
          <i class="fe fe-lock fe-16"></i>
          <span class="ml-3 item-text">Stok</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="masuk.php">
          <i class="fe fe-log-in fe-16"></i>
          <span class="ml-3 item-text">Masuk</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="pelanggan.php">
          <i class="fe fe-user-plus"></i>
          <span class="ml-3 item-text">Pelanggan</span>
        </a>
      </li>
    </ul>
  </nav>
</aside>
