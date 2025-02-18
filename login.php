<?php
session_start();
require_once('./include/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['user_name']);
    $password = trim($_POST['password']); 

    if(empty($username)||empty($password)){
        $_SESSION['error']="Both fields are required";
        header("Location:login.php");
        exit();
    }
    // Use pg_query_params for security
    $query = "SELECT user_id,user_name,password,user_type_id FROM users WHERE user_name = '$username' AND status = 't'";
    $result = pg_query($conn,$query);

    $user = pg_fetch_assoc($result);
    // echo '<pre>';
    // print_r($user);
    // echo '</pre>';
    // die;
    // echo $user['password'];
    //echo password_hash($password,PASSWORD_DEFAULT);
    
    if(count($user)>0){
    



    // $plain_password = "admin123"; 
    // $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

    //echo "Hashed Password: " . $hashed_password;
    // exit;



        if(password_verify($password,$user['password'])){
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['user_type_id'] = $user['user_type_id'];

            // var_dump($_SESSION);
            // echo "anbcd";
            // // Debug session data
            // exit();
            echo 'correct';

            
            header("Location: dashboard.php");
            // echo "pytr";
            exit();
        }else{
            echo 'incorrect';
            $error="Invalid password";
            
            exit();
        }
    }else{
        $error = "User not found";
    
        exit();
    }    
}
pg_close($conn);
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
                            <label class="form-label">Username</label>
                            <input type="text" name="user_name" class="form-control" required>
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
