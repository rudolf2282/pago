<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card mt-5">
        <div class="card-header">
          <h3>Login</h3>
        </div>
					<div class="card-body">
						<form action="login.php" method="post" id="loginForm">
							<div class="mb-3"> <label for="email" class="form-label">Email:</label>
							<input type="email" name="email" class="form-control" required>
							</div>
								<div class="mb-3"> <label for="password" class="form-label">Password:</label>
								<input type="password" name="password" class="form-control" required>
							</div>
							<button type="submit" name="login" class="btn btn-primary">Login</button>
						</form>
                        <?php
                        session_start();

                        if (isset($_POST['login'])) {
                            $email = $_POST['email'];
                            $password = $_POST['password'];

                            $conn = new mysqli("localhost", "root", "", "gaji");

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT * FROM tbl_user WHERE email='$email'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $user = $result->fetch_assoc();
                                if ($password === $user['password']) {
                                    $_SESSION['user_name'] = $user['user_name'];
                                    echo "<script>window.location.href = 'dashboard.php';</script>";
                                } else {
                                    echo "<script>alert('Email atau password salah');</script>";
                                }
                            } else {
                                echo "<script>alert('Email atau password salah');</script>";
                            }

                            $conn->close();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
