<?php
// Include the database connection file
require_once('./include/config.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!$conn){
        die("Connection failed:".preg_last_error());
    }
    // Get form data
    $employee_name = trim($_POST['employee_name']);
    $employee_email = trim($_POST['employee_email']);
    $employee_phone = trim($_POST['employee_phone']);
    $salary = trim($_POST['salary']);
    $employee_skills = trim($_POST['employee_skills']);
    $dob = trim($_POST['dob']);
    $user_type_id=trim($_POST['user_type_id']);
    $department = trim($_POST['department']);
    $position = trim($_POST['position']);

    // Insert data into the employee table
    $query = "INSERT INTO employees (employee_name, employee_email, employee_phone, salary, profile_image,employee_details,employee_skills,dob, created_at,updated_at,status, user_type_id,department_id,position_id) 
            VALUES ($1,$2,$3,$4,$5,$6,$7,$8,NOW(),NOW(),FALSE,$9,$10,$11)RETURNING employee_id";

        $result=pg_query_params($conn,$query,array($employee_name,$employee_email,$employee_phone,$salary,NULL,NULL,$employee_skills,$dob,$user_type_id,$department,$position));

    // Check if the query was successful

    if ($result) {
        echo 'Registration is successful';
    } else {
        echo 'Error: '. pg_last_error($conn);
    }

    // Close the database connection
    pg_close($conn);
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
                    <form action="register.php" method="POST">
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
                        <!-- <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="profile_image" class="form-control" required>
                        </div> -->
                        <div class="mb-3">
                            <label class="form-label">Position</label>
                                <select name="position" class="form-select" required>
                                    <option value="" selected disabled>-- Select Position --</option>
                                    <option value="1">HR Manager</option>
                                    <option value="2">Developer</option>
                                    <option value="3">Project Manager</option>
                                    <option value="4">Data Analyst</option>
                                    <option value="5">Marketing Executive</option>
                                </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                                <select name="department" class="form-select" required>
                                    <option value="" selected disabled>-- Select Department --</option>
                                    <option value="1">Higher Education Department</option>
                                    <option value="2">School Education Department</option>
                                    <option value="3">College Authority</option>
                                    <option value="4">University Director</option>
                                </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Skills</label>
                            <select name="employee_skills" class="form-select" required>
                                    <option value="" selected disabled>-- Select Skill --</option>
                                    <option value="Software Engineer">Database</option>
                                    <option value="Data Analyst">Problem Solving Ability</option>
                                    <option value="Project Manager">Full Stack Developer</option>
                                    <option value="HR Manager">Android Developer</option>
                                </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" required>
                        </div>
                        <div class="mb-3">
                        <label class="form-label">User Type</label>
                        <select class="form-control" name="user_type_id">
                            <option value="1">Admin</option>
                            <option value="2">Manager</option>
                        </select>   
                        </div>
                        <!-- <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div> -->
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
