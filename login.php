<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
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
            input[type="submit"], input[type="button"] {
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
                color: #111;
            }
            input[type="button"] {
                background-color: #1a85cc;
                color: white;
            }
            input[type="button"]:hover {
                background-color: #0f6aab;
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
        if (isset($_POST["login"])) {
            $idno = $_POST['idno'];
            $password = $_POST['password'];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE idno = '$idno'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                echo "Retrieved Password from Database: " . $user['password'];
                if ($password == $user["password"]){
                    header("Location: index.php");
                    die();
                }else {
                    echo "<div class='alert alert-success'>PASSWORD INCORRECT</div>";
                }
            }else {
                echo "<div class='alert alert-success'>ID Number Does Not Exist</div>";
            }
        }
    ?>
        <h2>Login Form</h2>
            <form id="Login" action="login.php" method="post">
                <input type="number" id="idno" name="idno" placeholder="Enter ID Number" required>

				<input type="password" id="password" name="password" placeholder="Enter Password" required>
				<input type="submit" value="login" name="login">
                <a href="registration.php   ">
                    <input type="button" value="Signup">
                </a>

            </form>
    </div>
</body>
</html>