<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
    <style>
        /* Hoverable sidebar menu */
        .menu:hover .menu-text {
            display: block;
        }
        
        .menu-text {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-16 hover:w-64 h-screen bg-white shadow-md duration-300">
            <div class="flex flex-col space-y-4 p-4">
                <!-- Menu Item 1 -->
                <div class="menu flex items-center space-x-2">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="menu-text">Calendar</span>
                </div>
                <!-- Menu Item 2 -->
                <div class="menu flex items-center space-x-2">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span class="menu-text">Invoices</span>
                </div>
                <!-- Menu Item 3 -->
                <div class="menu flex items-center space-x-2">
                    <i class="fas fa-receipt"></i>
                    <span class="menu-text">Receipts</span>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 p-10">
            <div class="bg-white p-6 rounded shadow-lg">
                <h2 class="text-2xl font-semibold mb-6">Patient Registration</h2>
                <!-- Form Starts Here -->
                <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name Fields -->
                    <input type="text" placeholder="First Name (required)" class="border p-2 rounded">
                    <input type="text" placeholder="Middle Name (optional)" class="border p-2 rounded">
                    <input type="text" placeholder="Last Name (required)" class="border p-2 rounded">
                    <!-- Gender Fields -->
                    <div class="flex gap-6">
                        <label class="flex items-center">
                            <input type="radio" name="gender" class="form-radio">
                            <span class="ml-2">Male</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="gender" class="form-radio">
                            <span class="ml-2">Female</span>
                        </label>
                    </div>
                    <!-- Address Fields -->
                    <input type="text" placeholder="Address" class="border p-2 rounded">
                    <div>
                        <select class="border p-2 rounded">
                            <option>Bangalore</option>
                            <!-- Other options would go here -->
                        </select>
                    </div>
                    <!-- Other form elements would be coded similarly -->
                    <!-- Submit Buttons -->
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Patient
                    </button>
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Add Patient & Book Appointment
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
