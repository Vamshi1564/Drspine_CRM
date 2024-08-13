<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Custom styles for the day indicator */
        .day-indicator::before {
            content: attr(data-day);
            position: absolute;
            top: -8px;
            right: 0;
            background-color: #68D391;
            color: white;
            font-weight: 500;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.75rem;
        }
    </style>
</head>

<body class="bg-gray-100 font-inter">

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Calendar navigation -->
            <div class="flex items-center justify-between mb-4">
                <div>
                    <span class="text-lg font-semibold text-gray-800">January 2024</span>
                </div>
                <div class="flex items-center">
                    <button class="text-gray-600 hover:bg-gray-100 p-1.5 rounded-full mr-2">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="text-gray-600 hover:bg-gray-100 p-1.5 rounded-full">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <!-- Calendar grid -->
            <div class="grid grid-cols-7 gap-4">
                <!-- Calendar headings -->
                <div class="font-semibold text-center">Sun</div>
                <div class="font-semibold text-center">Mon</div>
                <div class="font-semibold text-center">Tue</div>
                <div class="font-semibold text-center">Wed</div>
                <div class="font-semibold text-center">Thu</div>
                <div class="font-semibold text-center">Fri</div>
                <div class="font-semibold text-center">Sat</div>
                <!-- Calendar days -->
                <!-- Loop through days -->
                <div class="bg-white p-2 rounded-lg shadow text-center relative">
                    <span class="text-sm font-semibold text-gray-800">1</span>
                </div>
                <!-- ... -->
                <!-- Repeat for each day of the month -->
                <div class="bg-white p-2 rounded-lg shadow text-center relative day-indicator" data-day="5">
                    <span class="text-sm font-semibold text-gray-800">2</span>
                    <div class="text-xs text-gray-500 mt-1">9a Ashok Kumar Gupta +18 more</div>
                </div>
                <!-- ... -->
                <!-- Repeat until the end of the month -->
            </div>
        </div>
    </div>

</body>

</html>
