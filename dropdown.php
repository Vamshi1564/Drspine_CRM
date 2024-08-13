<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
 <!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (necessary for Select2's JavaScript) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <style>
    .custom-width-select2 {
  width: 300px !important; /* Change the width as needed */
}
    </style>
</head>
<body class="bg-gray-100">
  <div class="min-h-screen bg-gray-100 p-10">
    <div class="container mx-auto bg-white p-8 rounded-md shadow-lg">
      <div class="flex justify-between items-center mb-10">
        <h1 class="text-2xl font-bold">Invoice</h1>
        <div>
          <div class="flex items-center mb-2">
            <label for="doctor" class="w-20 mr-2 font-semibold">Doctor:</label>
            <input list="doctors" id="doctor" name="doctor" class="form-input rounded-md border-gray-300" placeholder="Select a doctor">
            <datalist id="doctors">
              <option value="Dr Jay">Dr Jay</option>
              <!-- Repeat options for all doctors -->
            </datalist>
          </div>
          <div class="flex items-center">
            <label for="branch" class="w-20 mr-2 font-semibold">Branch:</label>
            <select class="form-control" name="center_type" id="center_type"> 
                          <option  value="wellness" Selected>MJVA Wellness Pvt Ltd</option>
                          <option  value="healthcare" >MJVA healthcare Pvt Ltd</option>
                          
                        </select>
          </div>
        </div>
      </div>

      <!-- Package selection and details -->
      <div class="mb-6">
        <label for="package" class="block mb-2 font-semibold">Package Name</label>
       <select class="form-control select2" name="product_choice" id="product_choice">
  <!-- Dynamically loaded options will go here -->
</select>

        <!-- List of packages -->
       
      </div>
      <script>
$(document).ready(function() {
  // Initialize Select2 with AJAX data source
  $('#product_choice').select2({
    placeholder: "Select a package",
    allowClear: true,
    width: '300px',
    ajax: {
      url: 'fetch-packages.php',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        return {
          searchTerm: params.term, // search term
            };
      },
      processResults: function(data) {
        return {
          results: data.items
        };
      },
      cache: true
    }
  });
  
  // Trigger AJAX call when center_type changes

});


      </script>
      </body></html>
                  