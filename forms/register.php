<?php
include('../database/conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../partials/header.php'); ?>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <div class="card border">
                    <div class="card-header">
                        <h3>Register Form</h3>
                    </div>
                    <div class="card-body">

                        <!-- Register Form -->
                        <form method="post">
                            <div class="form-group mb-3">
                                <label for="name">Emri:</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Adresa e email-it:</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Fjalëkalimi:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Register</button>
                            <br>
                        </form>

                        <?php

                        if (isset($_POST['submit'])) {
                            $name = $_POST['name'];
                            $email = $_POST['email'];
                            $password = $_POST['password'];

                            // SQL query to insert the new user into the database
                            $sql = "INSERT INTO perdoruesit (emri, email_adresa, fjalekalimi) VALUES ('$name', '$email', '$password')";

                            // Execute the query and store the result in a variable
                            $result = mysqli_query($conn, $sql);

                            // Check if the query was successful
                            if ($result) {
                                // Registration successful, display a success message
                                echo '<div class="alert alert-success" role="alert">Registration successful!</div>';
                                header("Location: index.php");
                            } else {
                                // Registration failed, display an error message
                                echo '<div class="alert alert-danger" role="alert">Registration failed!</div>';
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