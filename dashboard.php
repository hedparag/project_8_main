<?php
session_start();
require_once('./include/config.php');

// var_dump($_SESSION); // Debug session data
// exit();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name']?? 'User';
$user_type_id = $_SESSION['user_type_id'] ?? 4;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>

        <!-- Admin-only Section-->

        <?php if ($user_type_id == 1): ?>
            
            <h3 class="mt-4">Employee List</h3>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch all employees excluding admins (assuming user_type_id = 1 is for admins)
                    $query = "SELECT e.employee_id, e.employee_name,e.employee_email, u.user_name FROM employees e 
                            LEFT JOIN users u ON e.employee_id = u.employee_id 
                            WHERE u.user_type_id != 1 OR u.user_type_id IS NULL";
                    $result = pg_query($conn, $query);

                    if (!$result) {
                        die("<tr><td colspan='3' class='text-center text-danger'>Query Failed: " . pg_last_error($conn) . "</td></tr>");
                    }
            
                    if (pg_num_rows($result) == 0) {
                        echo "<tr><td colspan='3' class='text-center'>No employees found</td></tr>";
                    }else{
                    while ($row = pg_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['employee_name']) . "</td>
                                <td>" . (isset($row['employee_email']) && !empty($row['employee_email']) ? htmlspecialchars($row['employee_email']): 'No Email') . "</td>
                                <td>
                                    <form method='POST' action='approve_employee.php' style='display:inline-block;'>
                                        <input type='hidden' name='employee_id' value='{$row['employee_id']}'>
                                        <button type='submit' class='btn btn-success btn-sm'>Approve</button>
                                    </form>
                                    <form method='POST' action='delete_employee.php' style='display:inline-block;'>
                                        <input type='hidden' name='employee_id' value='{$row['employee_id']}'>
                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                    </form>
                                    <a href='employee_details.php?id={$row['employee_id']}' class='btn btn-info btn-sm'>Details</a>
                                </td>
                            </tr>";
                    }
                }
                    ?>
                </tbody>
            </table>
            <?php else: ?>
            <!-- Employee profile if not admin -->
            <h3>Your Profile</h3>
            <?php 
            $query = "SELECT * FROM employees WHERE employee_id=$1";
            $result = pg_query_params($conn, $query, [$user_id]);
            $user = pg_fetch_assoc($result);
            ?>
            <p><strong>Full Name:</strong> <?= htmlspecialchars($user['employee_name']) ?></p>
            <p><strong>Department:</strong> <?= htmlspecialchars($user['department_id']) ?></p>
            <p><strong>Contact:</strong> <?= htmlspecialchars($user['contact']) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
        <?php endif; ?>

        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
