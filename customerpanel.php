<?php
session_start();

// customer_panel.php (Backend + Frontend)

// Database connection
$host = "localhost"; // Change if needed
$db = "your_database_name"; // Replace with your DB name
$user = "your_db_user";
$pass = "your_db_password";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Fetch user by ID from session
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  $user = $result->fetch_assoc();
} else {
  die("No user found.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ANS Customer Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
  <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-xl">
    <h1 class="text-2xl font-bold mb-4 text-center">Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <div class="p-4 bg-gray-50 rounded-xl border">
        <h2 class="font-semibold text-lg">📦 Package Details</h2>
        <p>Plan: <strong><?php echo htmlspecialchars($user['package']); ?></strong></p>
        <p>Data Used: <strong><?php echo htmlspecialchars($user['data_used']); ?> / <?php echo htmlspecialchars($user['data_total']); ?></strong></p>
      </div>

      <div class="p-4 bg-gray-50 rounded-xl border">
        <h2 class="font-semibold text-lg">📅 Billing Info</h2>
        <p>Status: <span class="text-green-600 font-semibold"><?php echo htmlspecialchars($user['status']); ?></span></p>
        <p>Expiry Date: <strong><?php echo htmlspecialchars($user['expiry']); ?></strong></p>
        <p>Next Payment: <strong><?php echo htmlspecialchars($user['next_payment']); ?></strong></p>
      </div>

      <div class="p-4 bg-gray-50 rounded-xl border">
        <h2 class="font-semibold text-lg">🌐 Connection Status</h2>
        <p>MAC Address: <code><?php echo htmlspecialchars($user['mac_address']); ?></code></p>
        <p>Current Status: <span class="text-green-500 font-bold"><?php echo htmlspecialchars($user['connection_status']); ?></span></p>
      </div>

      <div class="p-4 bg-gray-50 rounded-xl border">
        <h2 class="font-semibold text-lg">💳 Actions</h2>
        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Pay Bill</button>
        <button class="bg-gray-300 text-black px-4 py-2 rounded ml-2 hover:bg-gray-400">Contact Support</button>
      </div>

    </div>
  </div>
</body>
</html>
