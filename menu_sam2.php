<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .sidebar {
            min-width: 50px;
            max-width: 200px;
            transition: all 0.3s;
        }
        .sidebar:hover {
            width: 200px;
        }
        .sidebar-icon-only .nav-text {
            display: none;
        }
        .sidebar:hover .nav-text {
            display: inline;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-1 d-none d-md-block bg-light sidebar">
                <div class="position-sticky pt-3 sidebar-icon-only">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="nav-text ms-2">Calendar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span class="nav-text ms-2">Invoices</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-receipt"></i>
                                <span class="nav-text ms-2">Receipts</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-11 ms-sm-auto col-lg-11 px-md-4">
                <div class="py-5">
                    <h2>Patient Registration</h2>
                    <form class="row g-3">
                        <div class="col-md-4">
                            <label for="inputFirstName" class="form-label">First Name *</label>
                            <input type="text" class="form-control" id="inputFirstName" placeholder="First Name (required)">
                        </div>
                        <div class="col-md-4">
                            <label for="inputMiddleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="inputMiddleName" placeholder="Middle Name (optional)">
                        </div>
                        <div class="col-md-4">
                            <label for="inputLastName" class="form-label">Last Name *</label>
                            <input type="text" class="form-control" id="inputLastName" placeholder="Last Name (required)">
                        </div>
                        <div class="col-12">
                            <label class="d-block">Gender *</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="genderOptions" id="inlineRadio1" value="male">
                                <label class="form-check-label" for="inlineRadio1">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="genderOptions" id="inlineRadio2" value="female">
                                <label class="form-check-label" for="inlineRadio2">Female</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="inputAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                        </div>
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">City</label>
                            <select id="inputCity" class="form-select">
                                <option selected>Bangalore</option>
                                <!-- Add more options here -->
                            </select>
                        </div>
                        <!-- Add other form fields as needed -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Add Patient</button>
                            <button type="submit" class="btn btn-success">Add Patient & Book Appointment</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
