
<style type="text/css">
  
/* Custom Sidebar styles */
.custom-nav-sidebar {
  width: 52px; /* Initial width to show only icons */
  background-color: white;
  height: 100vh;
  position: fixed;
  overflow-x: hidden;
  transition: width 0.3s; /* Smooth transition */
  top:60px !important;
  box-shadow:0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
}

.custom-nav-sidebar:hover {
  width: 250px; /* Expanded width on hover to show text */
}

.custom-nav-sidebar .custom-nav-link {
  display: flex;
  align-items: center;
  padding: 10px 12px; /* Adjust padding for better alignment */
  color: #007bff; /* Sky blue color */
  background-color: white; /* White background */
  font-size: 16px; /* Adjust font size for visibility */
  transition: background-color 0.3s, color 0.3s;
  text-decoration: none;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.custom-nav-sidebar .custom-nav-link:hover {
  background-color: #f0f0f0; /* Slight grey background on hover */
}

.custom-nav-sidebar .custom-nav-icon {
  margin-right: 10px; /* Space between icon and text */
  font-size: 18px;
}

.custom-nav-sidebar .custom-nav-text {
  display: inline;
  opacity: 0; /* Initially hidden */
  transition: opacity 0.3s; /* Smooth transition */
}

.custom-nav-sidebar:hover .custom-nav-text {
  opacity: 1; /* Visible on hover */
}

</style>


<nav class=" navbar navbar-expand " style="background-color: #ffffff;color: black;
    border-bottom: 1px solid #dee2e6;
    z-index: 1034; margin-left: 0px;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
         <a href="index.php" class="brand-link"> 
    <img src="dist/img/drspine_logo.png" alt="drspine Logo" class="brand-image" style="width: 52%;">
  </a>

        <!-- <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color:white !important;"></i></a> -->
      </li>
  
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
     <!--  <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->

      <!-- Messages Dropdown Menu -->
<!--       <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item"> --> 
            <!-- Message Start -->
            <!-- <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div> --> 
            <!-- Message End -->
      <!-- </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> -->
            <!-- Message Start -->
            <!--  <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>  -->
            <!-- Message End -->
         <!--</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> -->
            <!-- Message Start -->
             <!-- <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div> --> 
            <!-- Message End -->
          <!--  </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> -->
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
          <!-- <i class="far fa-bell"></i> -->

          <span style="color:white;font-size:19px;" class="mr-3">Indira Nagar</span>
          <img src="dist/img/avatar.png" class="img-circle elevation-2" style="width:35px">
          <!-- <span class="badge badge-warning navbar-badge">15</span> -->
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- <span class="dropdown-item dropdown-header">15 Notifications</span> -->
          <div class="dropdown-divider"></div>
          <a href="profile.php" class="dropdown-item">
            <i class="fa fa-user-circle-o mr-2"></i>Profile
            <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="logout.php" class="dropdown-item">
            <i class="fa fa-sign-out mr-2"></i> Logout
            <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
          </a>
        
        </div>
              </li> 
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar custom-nav-sidebar">
  <!-- Brand Logo -->
 <!--  <a href="index.php" class="brand-link"> 
    <img src="dist/img/drspine_logo.png" alt="drspine Logo" class="ml-5 mt-2 brand-image elevation-3" style="width: 52%;">
  </a>
 -->
  <!-- Sidebar -->
  <div class="sidebar p-0">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills custom-nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'fd' || $_SESSION['role'] == 'cc') {
          ?>
           <li class="nav-item">
             <?php
              if (isset($_SESSION['branch_name_s']))
                $branch_name = $_SESSION['branch_name_s'];
              else if(isset($_GET['branch_name'])){
                $branch_name = $_GET['branch_name'];
              }else{
                $branch_name = 'whitefield';
              }
              ?>
          <a href="app_calender.php?branch_name=<?php echo urlencode($branch_name); ?>" class="nav-link custom-nav-link">
            <i class="custom-nav-icon fas fa-calendar-alt"></i>
            <p class="custom-nav-text">Appointments</p>
          </a>
        </li>
        <?php
          }
          ?>
         <?php
          if ($_SESSION['role'] == 'admin' && $_SESSION['role'] !=  'fd' && $_SESSION['role'] != 'cc') {
          ?>
        <li class="nav-item">
          <a href="manage_packages.php" class="nav-link custom-nav-link">
            <i class="custom-nav-icon fas fa-file-alt"></i>
            <p class="custom-nav-text">Manage Packages</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="download1.php" class="nav-link custom-nav-link">
            <i class="custom-nav-icon fas fa-download"></i>
            <p class="custom-nav-text">Download Patients Data</p>
          </a>
        </li>
        <?php } ?>

         <?php
          if ($_SESSION['role'] == 'admin' || $_SESSION['role'] ==  'fd' && $_SESSION['role'] != 'cc') {

          ?>
        <li class="nav-item">
          <a href="patient_details.php" class="nav-link custom-nav-link">
            <i class="custom-nav-icon fa fa-user"></i>
            <p class="custom-nav-text">Search Patient</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="manage_all_invoices.php" class="nav-link custom-nav-link">
            <i class="custom-nav-icon fas fa-file-invoice"></i>
            <p class="custom-nav-text">Invoices</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="manage_all_receipts.php" class="nav-link custom-nav-link">
            <i class="custom-nav-icon fas fa-receipt"></i>
            <p class="custom-nav-text">Receipts</p>
          </a>
        </li>
        <?php } ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
