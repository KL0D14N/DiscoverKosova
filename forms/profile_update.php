<?php
session_start();
include('../config/conn.php');

// Get the user's information

$sql = "SELECT * FROM perdoruesit";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
  $row = mysqli_fetch_assoc($result);
}

// Update the user's information
if (isset($_POST['update'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];

  $sql = "UPDATE perdoruesit SET emri = '$name', email_adresa = '$email' WHERE id = " . $row['id'];

  if (mysqli_query($conn, $sql)) {
    $_SESSION['message'] = 'Your profile has been updated successfully!';
    header('Location: ../index.php');
    exit;
  } else {
    $_SESSION['message'] = 'There was an error updating your profile.';
  }
}
if (isset($_FILES["profile-picture"]) && $_FILES["profile-picture"]["error"] == 0) {
  // Specify the destination directory and file name for the uploaded file
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["profile-picture"]["name"]);

  // Move the uploaded file to the specified directory
  if (move_uploaded_file($_FILES["profile-picture"]["tmp_name"], $target_file)) {
    // Update the user's profile picture path in the config
    $profile_picture_path = $target_file;
    // Your config update code here...
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}


?>


<html>
<?php include('../partials/header.php'); ?>

<body>



  <!-- <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mb-4">Update Profile</h2>
        
      </div>
    </div>
  </div> -->










  <?php
  if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
  }
  ?>


  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <section class="vh-100" style="background-color: #f4f5f7;">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col col-lg-6 mb-4 mb-lg-0">
            <?php
            if (isset($_SESSION['message'])) {
              echo '<div class="alert alert-info my-3">' . $_SESSION['message'] . '</div>';
              unset($_SESSION['message']);
            }
            ?>
            <a href="../index.php" class="btn btn-light shadow-1 border border-1 my-3"><i class="fi fi-rr-angle-left fa-lg"></i></a>
            <div class="card mb-3" style="border-radius: .5rem;">
              <div class="row g-0">
                <div class="col-md-4 gradient-custom text-center text-white"
                  style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                  <img src="../images/2.webp" alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                  <h5>Marie Horwitz</h5>
                  <p>Web Designer</p>
                  <i class="far fa-edit mb-5"></i>
                </div>

                <div class="col-md-8">
                  <div class="card-body p-4">
                    <h6>Information</h6>
                    <hr class="mt-0 mb-4">
                    <div class="row pt-1">
                      <div class="col mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                          value="<?php echo $row['emri']; ?>" required>
                      </div>
                    </div>
                    <div class="row pt-1">
                      <div class="col mb-3">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email"
                          value="<?php echo $row['email_adresa']; ?>" required>
                      </div>
                    </div>
                    <div class="row pt-1">
                      <div class="col mb-3">
                        <label for="profile-picture">Profile Picture</label>
                        <input type="file" class="form-control-file" id="profile-picture" name="profile-picture">
                      </div>
                    </div>
                    <div class="row pt-1">
                      <div class="col mb-3">
                        <button type="submit" class="btn btn-primary" name="update"><i
                            class="fi fi-rr-refresh fa-lg"></i> Përditso</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
  </form>



  <?php include('../partials/footer.php'); ?>
</body>

</html>