[]<?php
// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and ensure the user is logged in
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
} else {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
}

// Generate CSRF token if not already set
if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

include("config.php");

// Validate and sanitize the patient_id
if (!isset($_GET['patient_id']) || !ctype_digit($_GET['patient_id'])) {
    die("Invalid patient ID.");
}
$patient_id = intval($_GET['patient_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Patient Documents</title>
  <link rel="icon" type="image/x-icon" href="dist/img/fav.ico">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">

  <style>
    .gallery-item { position: relative; overflow: hidden; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 20px; }
    .gallery-item img { display: block; width: 100%; height: 300px; object-fit: cover; cursor: pointer; }
    .gallery-item a { display: block; padding: 10px; text-align: center; text-decoration: none; background-color: #f5f5f5; }
    #lightbox { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); justify-content: center; align-items: center; z-index: 1000; }
    #lightbox-img { max-width: 90%; max-height: 90%; }
    .close-btn, .next-btn, .prev-btn { position: absolute; font-size: 30px; color: white; cursor: pointer; z-index: 1001; }
    .close-btn { top: 20px; right: 30px; }
    .next-btn, .prev-btn { top: 50%; transform: translateY(-50%); }
    .prev-btn { left: 20px; }
    .next-btn { right: 20px; }
    .card-body { background-color: #f7f7f7; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3); width:100%; }
    .card-body table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    .card-body td { padding: 5px; border: 1px solid #ddd; }
    .card-body p.heading { font-weight: bold; margin: 0; }
    .card-body p.data { margin-top: 18px; }
    .card-body a { text-decoration: none; color: #007bff; }
    .card-body a:hover { text-decoration: underline; }
    .card-body a:active { color: #0056b3; }
    .card-body a:focus { outline: none; }
    .file-info { text-align: center; margin: 5px 0; font-size: 12px; color: #777; }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo.png" alt="drspine" height="60" width="80">
  </div>
  <?php include("menu.php"); ?>
  <div class="content-wrapper" style="width:'fit-content';">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Information</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid" style="margin-left: 50px;">
        <div class="row">
          <div class="col-md-3">
            <h4 style="margin-top: 12px; margin-left: 30px;">Patient Files:</h4>
          </div>
          <div class="col-md-3">
            
            <?php
          


// Fetch patient files securely
$stmt = $conn->prepare("SELECT * FROM patient_docs WHERE patient_id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Debugging: Check which fields are available in the row
        $filePath = $row['file_path'] ?? 'No file path';
        $fileName = $row['filename'] ?? 'No file name';
        $fileType = $row['mime_type'] ?? 'Unknown';
        $uploadTime = isset($row['timestamp']) ? (new DateTime($row['timestamp'], new DateTimeZone('UTC')))->setTimezone(new DateTimeZone('Asia/Kolkata'))->format('Y/m/d H:i:s') : 'No timestamp';
        $comments = $row['comments'] ?? 'No comments';

        echo '<div class="gallery-item">';
        if (strpos($fileType, 'image/') === 0) {
            echo '<img src="' . htmlspecialchars($filePath) . '" alt="' . htmlspecialchars($fileName) . '">';
        } else {
            echo '<a href="'. $filePath .'" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($row['filename'], ENT_QUOTES, 'UTF-8') . '</a>';
        }
        echo '<p class="file-info">File Name: ' . htmlspecialchars($fileName) . '</p>';
        echo '<p class="file-info">Upload Time: ' . htmlspecialchars($uploadTime) . '</p>';
        echo '<p class="file-info">Comments: ' . htmlspecialchars($comments) . '</p>';
        echo '<button class="delete-btn" style="margin-left: 130px;" data-file-id="' . htmlspecialchars($row['id']) . '">Delete</button>';
        echo '</div>';
    }
} else {
    echo "No files found for this patient.";
}

// Close the database connection
$stmt->close();
$conn->close();
            ?>
          </div>
        </div>
        <div id="lightbox" class="hidden">
          <span class="close-btn">&times;</span>
          <span class="prev-btn">&#10094;</span>
          <span class="next-btn">&#10095;</span>
          <img id="lightbox-img" src="" alt="Lightbox Image">
        </div>
        <div style="text-align: center; margin-top: 20px;">
          <a href="javascript:history.back()">Return to Previous Page</a>
        </div>
      </div>
    </section>
  </div>

  <?php include("footer.php"); ?>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
  const galleryItems = document.querySelectorAll('.gallery-item img');
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const closeBtn = document.querySelector('.close-btn');
  const prevBtn = document.querySelector('.prev-btn');
  const nextBtn = document.querySelector('.next-btn');

  let currentIndex = 0;
  let scrollPosition = 0;

  galleryItems.forEach((item, index) => {
    item.addEventListener('click', () => {
      scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
      currentIndex = index;

      document.body.style.overflow = 'hidden';
      updateLightboxImage();
      lightbox.style.display = 'flex';
    });
  });

  prevBtn.addEventListener('click', () => {
    if (currentIndex > 0) {
      currentIndex--;
      updateLightboxImage();
    }
  });

  nextBtn.addEventListener('click', () => {
    if (currentIndex < galleryItems.length - 1) {
      currentIndex++;
      updateLightboxImage();
    }
  });

  closeBtn.addEventListener('click', () => {
    document.body.style.overflow = 'auto';
    window.scrollTo(0, scrollPosition);
    lightbox.style.display = 'none';
  });

  function updateLightboxImage() {
    lightboxImg.src = galleryItems[currentIndex].src;
  }

  document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    console.log('CSRF Token:', csrfToken); // Check if the token is correct

    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const fileId = button.getAttribute('data-file-id');
            console.log('Deleting file with ID:', fileId); // Debugging

            fetch('delete_file.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'file_id=' + encodeURIComponent(fileId) + '&csrf_token=' + encodeURIComponent(csrfToken)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('File deleted successfully.');
                    const patientId = <?php echo json_encode($patient_id); ?>;
                    window.location.href = 'files.php?patient_id=' + encodeURIComponent(patientId);
                } else {
                    alert('Error deleting file: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
</body>
</html>
