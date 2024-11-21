<?php
include_once '../shared/head.php';
include '../core/config.php';

$message = null;
if (isset($_POST['send'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password =   $_POST['password'];
  $hash_password = password_hash($password, PASSWORD_DEFAULT);

  $select = "SELECT * FROM `users` WHERE `email` ='$email' ";
  $data = mysqli_query($connect, $select);
  $numRows = mysqli_num_rows($data);
  if ($numRows > 0) {
    $_SESSION['message'] = "Enter Deffrent Email";
  } else {
    if (empty($_FILES['image']['name'])) {
      $image_name = "def.webp";
    } else {
      $image_name = rand(0, 1000) . $_FILES['image']['name'];
      $image_tmp = $_FILES['image']['tmp_name'];
      $location = "../app/users/upload/$image_name";
      move_uploaded_file($image_tmp, $location);
    }
    $insert = "INSERT INTO users VALUES(NULL , '$name' ,'$email','$hash_password','$image_name',Default)";
    $i  = mysqli_query($connect, $insert);
    redirect("pages/login");
  }
}
$currentPATH = "http://"  . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

?>


<main>
  <div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="index.html" class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">NiceAdmin</span>
              </a>
            </div><!-- End Logo -->

            <div class="card mb-3">
              <?php if (isset($_SESSION['message'])): ?>
                <div id="alert-invlid" class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?= $_SESSION['message'] ?>
                  <form action="<?= URL("core/functions.php") ?>" method="post">
                    <input type="hidden" name="currentPATH" value="<?= $currentPATH ?>">
                    <button name="delete_message" class="btn-close" type="submit"></button>
                  </form>
                </div>
              <?php endif; ?>
              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                  <p class="text-center small">Enter your personal details to create account</p>
                </div>

                <form class="row g-3 needs-validation" method="post" enctype="multipart/form-data">
                  <div class="col-12">
                    <label for="yourName" class="form-label">Your Name</label>
                    <input type="text" name="name" class="form-control" id="yourName" required>
                    <div class="invalid-feedback">Please, enter your name!</div>
                  </div>

                  <div class="col-12">
                    <label for="yourEmail" class="form-label">Your Email</label>
                    <input type="email" name="email" class="form-control" id="yourEmail" required>
                    <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                    <div class="invalid-feedback">Please enter your password!</div>
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Image</label>
                    <input type="file" name="image" accept="image/*" class="form-control">
                    <div class="invalid-feedback">Please enter your Image</div>
                  </div>

                  <div class="col-12">
                    <button class="btn btn-primary w-100" name="send" type="submit">Create Account</button>
                  </div>
                  <div class="col-12">
                    <p class="small mb-0">Already have an account? <a href="<?= URL("pages/login.php") ?>">Log in</a></p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>

  </div>
</main><!-- End #main -->

<?php
include_once '../shared/footer.php';
include_once '../shared/script.php';
?>