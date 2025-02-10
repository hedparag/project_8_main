<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $employee_name = $_POST['employee_name'];
    $employee_email = $_POST['employee_email'];
    $employee_phone = $_POST['employee_phone'];
    $salary = $_POST['salary'];
    $employee_details = $_POST['employee_details'];
    $employee_skills = $_POST['employee_skills'];
    $dob = $_POST['dob'];
    $status = $_POST['status'];
    $created_at = date("Y-m-d H:i:s");
    $updated_at = date("Y-m-d H:i:s");

    
    $profile_image = $_FILES['profile_image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    
    
    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
        
        $query = "INSERT INTO employees (employee_name, employee_email, employee_phone, salary, profile_image, employee_details, employee_skills, dob, created_at, updated_at, status) 
                VALUES ('$employee_name', '$employee_email', '$employee_phone', '$salary', '$profile_image', '$employee_details', '$employee_skills', '$dob', '$created_at', '$updated_at', '$status')";

        $result = pg_query($conn, $query);

        if ($result) {
            echo "Registration successful!";
        } else {
            echo "Error: " . pg_last_error($conn);
        }
    } else {
        echo "Error uploading profile image.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h2>Employee Registration</h2>
                </div>
                <div class="card-body">
                    <form action="register.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Employee Name</label>
                            <input type="text" name="employee_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="employee_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="employee_phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" name="salary" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="profile_image" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Details</label>
                            <textarea name="employee_details" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Skills</label>
                            <input type="text" name="employee_skills" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
