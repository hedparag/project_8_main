<?php
session_start();
include 'config.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if(!$conn){
    die("Database connection failed");
}

// Fetch employee data
$query = "SELECT * FROM employees";
$result = pg_query($conn, $query);

if(!$result){
    die("Error in SQL query:".pg_last_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to Employee Dashboard</h1>
    
    <!-- Logout Button -->
    <a href="logout.php">Logout</a>
    
    <!-- Employee Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        
        <?php
        while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['employee_name'] . "</td>";
            echo "<td>" . $row['employee_email'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
