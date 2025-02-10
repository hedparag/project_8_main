<?php
if(!isset($SESSION['user_id'])){
    header("Location:login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query="Select * from users where id=$1";
$result=pg_query_params($conn,$query,array($user_id));
$user = pg_fetch_assoc($result);

$query_emp="Select * from employee"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h1>Profile Page</h1>
    <form method="POST">
        <label>Full Name:</label>
        <input type="text" name="full_name" required><br>
        <br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <br>
        <label>Phone Number:</label>
        <input type="text" name="phone_number" required><br>
        <br>
        <label>Address:</label>
        <input type="text" name="address" required><br>
        <br>
        <button type="submit">Update Proffile</button>
    </form>

    <a href="dashboard.php">Back to Dashboard</a>
    
</body>
</html>