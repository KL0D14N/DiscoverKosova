<?php
session_start();
include('../config/conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../partials/header.php'); ?>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3>Login Form</h3>
                    </div>
                    <div class="card-body">

                        <!-- Login Form -->
                        <form method="post">
                            <div class="form-group mb-3">
                                <label for="email">Email:</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Login</button>
                        </form>

                        <?php
                        if (isset($_POST['submit'])) {
                            $email = $_POST['email'];
                            $password = $_POST['password'];

                            // SQL query to check if the user exists in the config
                            $sql = "SELECT * FROM perdoruesit WHERE email_adresa='$email' AND fjalekalimi='$password'";

                            // Execute the query and store the result in a variable
                            $result = mysqli_query($conn, $sql);

                            // Check if the query was successful and if a user was found
                            if (mysqli_num_rows($result) == 1) {
                                // User found, redirect to a protected page
                                header("Location: ../index.php");
                            } else {
                                // User not found, display an error message
                                echo '<div class="alert alert-danger" role="alert">Invalid email or password!</div>';
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include('../partials/footer.php'); ?>
</body>

</html>