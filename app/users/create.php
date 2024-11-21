<?php
include_once '../../shared/head.php';
include_once '../../shared/header.php';
include_once '../../shared/aside.php';
include_once '../../core/config.php';
include_once '../../core/functions.php';

$select = "SELECT * FROM users";
$users = mysqli_query($connect, $select);
$Profile_id = $_SESSION['admin']['id'];

auth();

$errors  = [];
if (isset($_POST['send'])) {
    $name = filterValidation($_POST['name']);
    $email = filterValidation($_POST['email']);
    $password =   "12345678";

    if (string_validation($name, 90)) {
        $errors[] = "Invalid Name";
    }
    if (email_validation($email)) {
        $errors[] = "Invalid Email";
    }



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
            $type = substr($_FILES['image']['name'], -3);

            $image_name = rand(0, 1000) . $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $file_size = $_FILES['image']['size'];
            if (size_file_validation($file_size)) {
                $errors[] = "Size invalid";
            }
            if (file_type_validation($type, "jpg", "png", "jif")) {
                $errors[] = "Type Invalid";
            } else {
                $location = "./upload/$image_name";
                move_uploaded_file($image_tmp, $location);
            }
        }
        if (empty($errors)) {
            $insert = "INSERT INTO users VALUES(NULL , '$name' ,'$email','$hash_password','$image_name',$Profile_id ,3)";
            $i  = mysqli_query($connect, $insert);
            $_SESSION['message'] = "Craete New Admin Successully";
        }
    }
}
$currentPATH = "http://"  . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];


?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Form Layouts</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active">Layouts</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">

            <div class="card">

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $one_error): ?>
                                <li><?= $one_error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
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
                    <h5 class="card-title">Vertical Form</h5>

                    <!-- Vertical Form -->
                    <form class="row g-3" method="post" enctype="multipart/form-data">
                        <div class="col-12">
                            <label for="inputNanme4" class="form-label">User Name</label>
                            <input type="text" name="name" class="form-control" id="inputNanme4">
                        </div>
                        <div class="col-12">
                            <label for="inputEmail4" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="inputEmail4">
                        </div>

                        <div class="col-12">
                            <label for="inputEmail4" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="inputEmail4">
                        </div>

                        <div class="text-center">
                            <button type="submit" name="send" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- Vertical Form -->

                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->


<?php
include_once '../../shared/footer.php';
include_once '../../shared/script.php';
?>