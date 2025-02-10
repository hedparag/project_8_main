<?php
session_start();
// include 'config.php'; // Ensure the connection is available

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['employee_email'];
    $password = $_POST['password']; 

    // Use pg_query_params for security
    $query = "SELECT * FROM users WHERE employee_email = $1 AND password = $2";
    $result = pg_query_params($conn, $query, [$email, $password]);

    if ($result && pg_num_rows($result) > 0) {
        $_SESSION['user'] = pg_fetch_assoc($result);
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h2>Login</h2>
                </div>
                <div class="card-body">
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="employee_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember_me">
                            <label class="form-check-label">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <div class="mt-3 text-center">
                        <p><a href="forgot_password.php">Forgot Password?</a></p>
                        <p>New User? <a href="register.php">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
