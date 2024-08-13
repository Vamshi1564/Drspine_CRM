<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Gallery</title>
  <style>
    /* Styles for the gallery layout */
    .gallery-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
      margin: 20px;
    }

    .gallery-item {
      position: relative;
      overflow: hidden;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .gallery-item img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: fill;
  cursor: pointer;
}


    .gallery-item a {
      display: block;
      padding: 10px;
      text-align: center;
      text-decoration: none;
      background-color: #f5f5f5;
    }
    /* Lightbox styles */
  #lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }

  #lightbox-img {
    max-width: 90%;
    max-height: 90%;
  }

  .close-btn {
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 30px;
    color: white;
    cursor: pointer;
    z-index: 1001;
  }
  .next-btn {
  position: absolute;
  top: 50%;
  font-size: 30px;
  color: white;
  cursor: pointer;
  z-index: 1001;
  transform: translateY(-50%);
}
.prev-btn {
  position: absolute;
  top: 50%;
  font-size: 30px;
  color: white;
  cursor: pointer;
  z-index: 1001;
  transform: translateY(-50%);
}

.prev-btn {
  left: 20px;
}

.next-btn {
  right: 20px;
}
  </style>
</head>
<?php
  include("config.php");
  ?>
<body>
  <div class="gallery-container">
  <?php
    
    $patient_id = $_GET['patient_id'];
    $sql = "SELECT * FROM prev_patients_docs WHERE patient_id = $patient_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patient_id = $row['patient_id'];
        $fileData = $row['file_data'];
        $fileName = $row['filename'];
        $fileType = $row['mime_type'];

        echo '<div class="gallery-item">';
        
        if (strpos($fileType, 'image/') === 0) {
            // Display images
            echo '<img src="data:' . $fileType . ';base64,' . base64_encode($fileData) . '" alt="' . $fileName . '">';
        } else {
            // Display non-image files
            echo '<a href="data:' . $fileType . ';base64,' . base64_encode($fileData) . '" download>' . $fileName . '</a>';
        }
        
        echo '</div>';
    }
} else {
    echo "No files found for this patient.";
}

    // Close the database connection
    $conn->close();
    ?>
  </div>

  <div id="lightbox" class="hidden">
  <span class="close-btn">&times;</span>
  <span class="prev-btn">&#10094;</span>
  <span class="next-btn">&#10095;</span>
  <img id="lightbox-img" src="" alt="Lightbox Image">
</div>


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
</script>

<div style="text-align: center; margin-top: 20px;">
    <a href="javascript:history.back()">Return to Previous Page</a>
  </div>

  
</html>

