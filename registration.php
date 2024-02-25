<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>

            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 500px;
                margin: 50px auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            input[type="text"], input[type="number"],input[type="password"], select {
                width: 100%;
                padding: 10px;
                margin: 5px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            input[type="submit"], input[type="button"], button {
                width: 30%;
                padding: 10px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            input[type="submit"] {
                background-color: #4CAF50;
                color: white;
            }
            input[type="submit"]:hover {
                background-color: #45a049;
            }
            input[type="button"] {
                background-color: #f44336;
                color: white;
            }
            input[type="button"]:hover {
                background-color: #d32f2f;
                color: #111;
            }
			
			ul {
			  list-style-type: none;
			  margin: 0;
			  padding: 0;
			  overflow: hidden;
			  background-color: #333;
			}

			li {
			  float: none;
			  display: inline-block;
			}

			li a {
			  display: inline-block;
			  color: white;
			  text-align: left;
			  padding: 14px 16px;
			  text-decoration: none;
			}

			li a:hover {
			  background-color: #111;
			}
			
			nav{
				text-align:center;
			}
    </style>
</head>
<body>
    <div>
		<ul>
		  <li><a href="#home">Home</a></li>
		  <li><a href="#news">News</a></li>
		  <li><a href="#contact">Contact</a></li>
		</ul>
	</div>

    <div class="container">
    <?php
        session_start();
        $con = mysqli_connect("localhost", "root", "", "sysarch");

        if(isset($_POST["submit"])){
            $idno = $_POST['IDNO'];
            $last_name = $_POST['lastName'];
            $first_name = $_POST['firstName'];
            $middle_name = $_POST['middleName'];
            $year = $_POST['year'];
            $password = $_POST["password"];
            $Cpassword = $_POST["Cpassword"];
            $course = $_POST["course"];
            $email = $_POST["email"];
            $role = $_POST["role"];

            $errors = array();

            if (empty($idno) OR empty($last_name) OR empty($first_name) OR empty($middle_name) OR empty($year) OR empty($password) OR empty($Cpassword) OR empty($course) OR empty($email) OR empty($role)) {
                array_push($errors, "All Fields Are Required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            if (strlen($password)<8) {
                array_push($errors, "Password must be at least 8 characters long!!");
            }
            if ($password !== $Cpassword) {
                array_push($errors, "Password does not match");
            }

            $check_query = "SELECT * FROM users WHERE IDNO = ?";
            $check_stmt = mysqli_prepare($con, $check_query);
            mysqli_stmt_bind_param($check_stmt, "i", $idno);
            mysqli_stmt_execute($check_stmt);
            mysqli_stmt_store_result($check_stmt);
            if (mysqli_stmt_num_rows($check_stmt) > 0) {
                array_push($errors, "ID number already exists");
            }
            mysqli_stmt_close($check_stmt);

            if (count($errors)>0) {
                echo "<div class='alert alert-danger'>" . implode("<br>", $errors) . "</div>";
            } else {
                $query = "INSERT INTO users (IDNO, last_name, first_name, middle_name, year, password, course, email, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "isssissss", $idno, $last_name, $first_name, $middle_name, $year, $password, $course, $email, $role);
                $result = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
    
                if ($result) {
                    echo "<div class='alert alert-success'>Registration successful</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
                }
            }
        }
    ?>

        <h2>Registration Form</h2>
            <form id="registrationForm" action="registration.php" method="post">
            <input type="number" id="IDNO" name="IDNO" placeholder="ID Number" value="<?php echo isset($_POST['IDNO']) ? htmlspecialchars($_POST['IDNO']) : ''; ?>">
            <input type="text" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>">
            <input type="text" id="firstName" name="firstName" placeholder="First Name" value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>">
            <input type="text" id="middleName" name="middleName" placeholder="Middle Name" value="<?php echo isset($_POST['middleName']) ? htmlspecialchars($_POST['middleName']) : ''; ?>">
				<select id="year" name="year">
                    <option value="" disabled selected>Choose Year Level</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
				<input type="password" id="password" name="password" placeholder="Password">
				<input type="password" id="Cpassword" name="Cpassword" placeholder="Confirm Password">
				<select id="course" name="course">
                    <option value="" disabled selected>Choose Course</option>
                    <option value="BSIT">BSIT</option>
                    <option value="BSCS">BSCS</option>
                    <option value="BSIS">BSIS</option>
                    <option value="BSCPE">BSCPE</option>
                </select>
				<input type="text" id="email" name="email" placeholder="Email" <?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>>
                <select id="role" id="role" name="role">
                    <option value="" disabled selected>Choose Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Student">Student</option>
                    <option value="Staff">Staff</option>
                </select>
                <div class="form-btn">
                    <input type="submit" value="Register" class="btn" name="submit">
                    
                    <a href="login.php   ">
                        <input type="button" value="Login">
                    </a>
                </div>
            </form>
    </div>
</body>
</html>