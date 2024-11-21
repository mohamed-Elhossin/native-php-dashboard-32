<?php
include_once '../shared/head.php';
include_once '../core/config.php';

if (isset($_POST['login'])) {
  $email  = $_POST['email'];
  $password  = $_POST['password'];
  $select = "SELECT * FROM `users_all_data` WHERE `email` ='$email' ";
  $data = mysqli_query($connect, $select);
  $numRows = mysqli_num_rows($data);
  if ($numRows == 1) {
    $row = mysqli_fetch_assoc($data);
    $database_password = $row['password'];
    if (password_verify($password, $database_password)) {

// 
       setcookie("isAdmin",$email, time() + 86400*30 , '/');

      $_SESSION['admin'] = [
        "id" => $row['id'],
        "name" => $row['name'],
        "email" => $row['email'],
        "image" => $row['image'],
        "rule" => $row['rule_number'],
      ];
      redirect('');
    } else {
      $_SESSION['message']  = "False Password ";
    }
  } else {
    $_SESSION['message']  = "False Admin";
  }
}
// http://localhost/
// SERVER_NAME
// REQUEST_URI] => /online/pages/login.php
$currentPATH = "http://"  . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
 guest();
 
?>


<main>
  <div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="index.html" class="logo d-flex align-items-center w-auto">

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
                  <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                  <p class="text-center small">Enter your username & password to login</p>
                </div>

                <form class="row g-3 needs-validation" method="post">

                  <div class="col-12">
                    <label for="yourUsername" class="form-label">Email</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend">@</span>
                      <input type="email" name="email" class="form-control" required>
                      <div class="invalid-feedback">Please enter your username.</div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                    <div class="invalid-feedback">Please enter your password!</div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary w-100" name="login" type="submit">Login</button>
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