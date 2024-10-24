      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="indexAfter.php"><img src="assets/images/MNFSBLogo.png" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="indexAfter.php"><img src="assets/images/MNFSBLogo.png" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
            
              <div class="nav-profile-img">
                <img src="assets/images/faces-clipart/pic-4.png" alt="image">
                <span class="availability-status online"></span>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <div class="dropdown-divider"></div>
              
              </div>
            </li>
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <div class="nav-profile-image">
                <img src="assets/images/faces-clipart/pic-4.png" alt="profile">
                <span class="login-status online"></span>
                <!--change to offline or busy as needed-->
              </div>
              <div class="nav-profile-text d-flex flex-column">
                
                <span class="text-secondary text-small">MNFSB</span>
              </div>
              <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="indexAfter.php">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#insertion-pages" aria-expanded="false" aria-controls="insertion-pages">
              <span class="menu-title">Reservation</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-plus-box menu-icon"></i>
            </a>
            <div class="collapse" id="insertion-pages">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="resvCalendar.php"> Calendar Reservation </a></li>
              </ul>
            </div>
             <div class="collapse" id="insertion-pages">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="resvStatus.php"> Reservation Status </a></li>
              </ul>
            </div>
          </li>


          

        </a>
        <div class="collapse" id="general-pages">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="blank-page.html"> Blank Page </a></li>
            <li class="nav-item"> <a class="nav-link" href="login.html"> Login </a></li>
            <li class="nav-item"> <a class="nav-link" href="register.html"> Register </a></li>
            <li class="nav-item"> <a class="nav-link" href="error-404.html"> 404 </a></li>
            <li class="nav-item"> <a class="nav-link" href="error-500.html"> 500 </a></li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>