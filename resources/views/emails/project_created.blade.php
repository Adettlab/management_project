<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Tailwind CSS atau hasil dari PurgeCSS */
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800">Hello, {{ $employeeName }}</h1>
        <p class="text-gray-600 mt-2">You have been assigned to a new project:</p>
        <div class="mt-4">
            <h2 class="text-xl font-semibold text-blue-600"><strong>Project:</strong> {{ $projectName }}</h2>
            <p><strong>Start Date:</strong> {{ $startDate }}</p>
            <p><strong>End Date:</strong> {{ $endDate }}</p>
        </div>
        <p class="mt-6 text-gray-600">Please check the project management system for more details...Thank you!</p>
    </div>
</body>
</html>
