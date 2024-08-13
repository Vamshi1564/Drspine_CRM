<!DOCTYPE html>
<?php
session_start(); 
if(!isset($_SESSION['email'])){
   header("Location:login.php");
}
else
{
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
include("config.php");

if(isset($_POST['submit']))
{
    include("config.php");
    $name=mysqli_real_escape_string($conn,$_POST['name']);
   $email=mysqli_real_escape_string($conn,$_POST['email']);
   $phone=mysqli_real_escape_string($conn,$_POST['phone']);
   $password=mysqli_real_escape_string($conn,md5($_POST['password'])); 
   $branch = mysqli_real_escape_string($conn,$_POST['branch']);

$imagename=$_FILES["image"]["name"];
// $v3= rand(1111,4444);
$dist="./images/".$imagename;

$dist1="images/".$imagename;

move_uploaded_file($_FILES["image"]["tmp_name"],$dist);

$imageFileType = pathinfo($dist1,PATHINFO_EXTENSION);

$role= 2;
if(($name != "") && ($phone != "") && ($password != ""))
{
if($imageFileType != "jpeg" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "bmp" && $imageFileType != "gif" && $imageFileType != "tiff")
{
    echo "File Format Not Suppoted";
} 
else   
{
    $result=mysqli_query($conn,"select id from  manager_login where id=(select max(id) from  user_login)");
    if($row=mysqli_fetch_array($result))
    {
        $id=$row['id']+1;
    }

    $result2 = mysqli_query($conn,"SELECT * FROM  manager_login where phone='".$phone."'");
    $num_rows = mysqli_num_rows($result2);
    if($num_rows >= 1){
        ?>
       <script>alert("Phone already Registered");
                window.location="register-sales-person.php";
            </script>
            <?php
    }
    else
    {
      $result2 = mysqli_query($conn,"SELECT * FROM  manager_login where name='".$name."'");
    $num_rows = mysqli_num_rows($result2);
    if($num_rows >= 1){
        ?>
       <script>alert("Name already Exisit, Please use your initials");
                window.location="register-sales-person.php";
            </script>
            <?php
    }

    else{
       
    $sql = "insert into  manager_login(id,name,email,phone,image,password,role,branch) values('$id','$name','$email','$phone','$dist1','$password','$role','$branch')";

            if ($conn->query($sql) === TRUE) 
          {

 
     // if(mail($to1,$subject1,$message1,$headers1,'-fmahaveerdistributors00@gmail.com'))
   //   {  
    
      //if(mail($to,$subject,$message,$headers,'fmahaveerdistributors00@gmail.com'))
      // {



              ?>
              <script>
            
                alert("Successfully Registered");
                // window.location="index.php";
        </script>
              <?php
            //} 
          //}
        }
          else 
          {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
 }   
 }        
}
}
else
{
     ?>
              <script>
            
                alert("Please Enter all the fields");
                // window.location="register-sales-person.php";
        </script>
              <?php
}
}

?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
 <link rel="icon" type="image/x-icon" href="dist/img/fav.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
 <!--  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

            <script type='text/javascript'>
function preview_image(event) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('output_image');
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}
</script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo.png" alt="JyotiWoodsLogo" height="60" width="80">
  </div>

 <?php include("menu.php");?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Branch Admin</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <!-- <li class="breadcrumb-item active">Add New Patient </li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Branch Admin</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                       <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                          <div class="row">
                        <div class="form-group col-md-4">
                            <label>Name</label>
                            <input class="form-control" name="name" type="text" required/>
                             <!-- <p class="help-block">Example block-level help text here.</p> -->
                        </div>
                        <div class="form-group col-md-4">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email"  placeholder="Email">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Phone</label>
                           <input class="form-control" type="tel" name="phone" placeholder="Phone" required>
                        </div>
                        <div class="form-group col-md-4">
                         <label>password</label>
                        <input class="form-control" type="password" name="password"  placeholder="Password">
                        </div>
                        <div class="form-group col-md-4">
                         <label>Branch</label>
                         <select class="form-control" name="branch" id="branch">
                          <option value="Whitefield">Whitefield</option>
                          <option value="BEL">BEL</option>
                          <option value="IND">IND</option>
          </select>
                         
                        <!-- <input class="form-control" type="password" name="password"  placeholder="Password"> -->
                        </div>
                        <div class="form-group col-md-4">
                           <img src="" id="output_image" alt="image" width="130px" height="100px"/>
                            <label>Profile Image</label>
                            <input type="file" name="image" value="" accept="Images/*" onchange="preview_image(event)" />
                        </div>
                        
                        <!--  <div class="colmd-6" style="margin-left:700px;margin-right:0px;position:absolute;">
                          <img src="" id="output_image" alt="image" width="130px" height="100px"/>
                          </div> -->
                                                
                        <input type="submit" class="btn btn-primary" name="submit"  value="Submit"/>
                        <input type="reset" class="btn btn-danger" name="cancel" value="Cancel"/>
                      </div>
                    </div>
                   </form>
            
            </div>
          </div>
        </div>
      </div>
    </section>
   
  </div>
 



 <?php include("footer.php");?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<!-- <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
