 
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand " style="background-color: #0c1645;color: white;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color:white !important;"></i></a>
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
        <?php
        $emailp=$_SESSION['email'];
        $passp = $_SESSION['role'];
        $idp= $_SESSION['id'];
        $sql="select * from manager_login where id= '$idp'";
        $result=$conn->query($sql);
        if($result->num_rows>0)
        {
             if($row = mysqli_fetch_assoc($result)) 
             {
        ?>
        <a class="nav-link" data-toggle="dropdown" href="#">
          <!-- <i class="far fa-bell"></i> -->

          <span style="color:white;font-size:19px;" class="mr-3"><?php echo $row["branch"];?></span>
          <img src="<?php echo $row["image"]?>" class="img-circle elevation-2" style="width:35px"/>
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
        <?php
      }
    }
        ?>
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
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #0c1645 !important;">
    <!-- Brand Logo -->
    <a href="index.php" class=""> 
      <img src="dist/img/drspine_logo.png" alt="drspine Logo" class="ml-5 mt-2 brand-image  elevation-3" style="width: 52%;">
      <!--<span class="brand-text font-weight-light">DrSpine</span>-->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
       <?php
        $sql="select * from manager_login ";
        $result=$conn->query($sql);
        if($result->num_rows>0)
        {
             if($row = mysqli_fetch_assoc($result)) 
             {
        ?>

      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $row["image"]?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="profile.php" class="d-block"><?php echo $row["name"]?></a>
        </div>
      </div> -->

      <?php
    }
  }
      ?>

      <!-- SidebarSearch Form -->
     <!--  <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      
     <!-- <nav class="mt-2"> -->
        <!-- <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> -->
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <!-- <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p> Dashboard
               
              </p>
            </a>
          </li>-->
          <!-- <li class="nav-item"> -->
            <!-- <a href="app_calender.php" class="nav-link"> -->
            <!-- <a href="app_calender.php?branch_name=<?php echo $branch_name; ?>" class="nav-link"> -->
            <!-- <?php
// $branch_name = "whitefield";

?>
<a href="app_calender.php?branch_name=<?php echo urlencode($branch_name); ?>" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p> Appointments
             <i class="right fas fa-angle-left"></i> -->
              <!-- </p> -->
            <!-- </a> -->
          <!-- </li> -->
          <!-- <li class="nav-item">
            <a href="appointment_list.php" class="nav-link">
              <i class="nav-icon fa fa-address-book-o"></i>
              <p>View Appointments List</p></a>
          </li> -->
          <!--<li class="nav-item">
            <a href="add_appointment.php" class="nav-link">
              <i class="nav-icon fa fa-address-book-o"></i>
              <p>Add Appointment New</p></a>
          </li>

           <li class="nav-item">
            <a href="add_appointment_old_patient.php" class="nav-link">
              <i class="nav-icon fa fa-address-book-o"></i>
              <p>Add Appointment Old</p></a>
          </li>-->

           <!-- <li class="nav-item">
            <a href="add-package.php" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Add Packages</p></a>
          </li> -->

          <!--<li class="nav-item">
            <a href="appointment_list.php" class="nav-link">
              <i class="nav-icon fa fa-address-book-o"></i>
              <p>View Appointment</p></a>
          </li>-->
          
<!--           
          <li class="nav-item">
            <a href="patient_details.php" class="nav-link">
              <i class="nav-icon fa fa-user"></i>
              <p> Search Patient</p>
            </a>
          </li>
           -->
       <!--   <li class="nav-item">
            <a href="view_all_patient_details.php" class="nav-link">
              <i class="nav-icon fa fa-address-book-o"></i>
              <p> View All Patients Details</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="view-patients.php" class="nav-link">
              <i class="nav-icon fa fa-address-book-o"></i>
              <p> View New Patients</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="view-prev-patients.php" class="nav-link">
              <i class="nav-icon fa fa-address-book-o"></i>
              <p> View Previous Patients</p>
            </a>
          </li>

            <li class="nav-item">
            <a href="add-leads.php" class="nav-link">
              <i class="nav-icon fa fa-user-circle-o"></i>
              <p> Add Leads </p>
            </a>
          </li>
        <li class="nav-item">
            <a href="view-leads.php" class="nav-link">
              <i class="nav-icon fa fa-user-o"></i>
               <p> View All Leads </p>
            </a>
          </li> 
          
          <li class="nav-item">
            <a href="add-patients.php" class="nav-link">
              <i class="nav-icon fa fa-address-book-o"></i>
              <p> Add Patients</p>
            </a>
          </li>-->
          
        
           <!--<li class="nav-item">
            <a href="view_branch_admin.php" class="nav-link">
              <i class="nav-icon fa fa-address-book-o"></i>
              <p>Manage branch Admin</p>
            </a>
          </li>--> 

           <!-- <li class="nav-item">
            <a href="manage_all_invoices.php" class="nav-link">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>Invoices</p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="manage_all_receipts.php" class="nav-link">
              <i class="nav-icon fas fa-solid fa-receipt"></i>
              <p>Receipts</p>
            </a>
          </li> 
          <li class="nav-item">
    <a href="download1.php" class="nav-link">
        <i class="nav-icon fas fa-download"></i>
        <p>Download Patients Data</p>
    </a>
</li>
          <li class="nav-item"> -->
          <!--  <a href="appointment_list.php" class="nav-link">
              <i class="nav-icon fa fa-address-book-o"></i>
              <p>Appointment List</p>
            </a>
          </li> -->
         <!--  <li class="nav-item">
            <a href="patient_details.php" class="nav-link">
              <i class="nav-icon fa fa-address-book-o"></i>
              <p>View Patient Details</p>
            </a>
          </li> -->
        <!-- </ul> -->
      <!-- </nav> -->
      <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
             <a href="app_calender.php?branch_name=<?php echo urlencode($branch_name); ?>" class="nav-link">
               <i class="nav-icon fas fa-calendar-alt"></i>
               <p> Appointments
                 <!-- <i class="right fas fa-angle-left"></i> -->
               </p>
             </a>
           </li>
         <?php
          }
          ?>
         <?php
          if ($_SESSION['role'] == 'admin' && $_SESSION['role'] !=  'fd' && $_SESSION['role'] != 'cc') {
          ?>
           <li class="nav-item">
             <a href="manage_packages.php" class="nav-link">
               <i class="nav-icon fas fa-file-alt"></i>
               <p>Manage Packages</p>
             </a>
           </li>
           <li class="nav-item">
    <a href="download1.php" class="nav-link">
        <i class="nav-icon fas fa-download"></i>
        <p>Download Patients Data</p>
    </a>
</li>
         <?php } ?>

         <?php
          if ($_SESSION['role'] == 'admin' || $_SESSION['role'] ==  'fd' && $_SESSION['role'] != 'cc') {

          ?>

           <li class="nav-item">
             <a href="patient_details.php" class="nav-link">
               <i class="nav-icon fa fa-user"></i>
               <p> Search Patient</p>
             </a>
           </li>


           <li class="nav-item">
             <a href="manage_all_invoices.php" class="nav-link">
               <i class="nav-icon fas fa-file-invoice"></i>
               <p>Invoices</p>
             </a>
           </li>

           <li class="nav-item">
             <a href="manage_all_receipts.php" class="nav-link">
               <i class="nav-icon fas fa-solid fa-receipt"></i>
               <p>Receipts</p>
             </a>
           </li>
         <?php } ?>
       </ul>
     </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
