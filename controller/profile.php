<?php
// session_star
include_once '../core/config.php';
include_once '../core/functions.php';

$old_image = $_SESSION['admin']['image'];
$profile_id = $_SESSION['admin']['id'];

$profile_email = $_SESSION['admin']['email'];
$numRows = null;
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];



    if ($profile_email != $email) {
        $select = "SELECT * FROM `users` WHERE `email` ='$email' ";
        $data = mysqli_query($connect, $select);
        $numRows = mysqli_num_rows($data);
    }

    if ($numRows > 0) {
        redirect("pages/profile.php");
        $_SESSION['message'] = "Enter Deffrent Email";
    } else {
        if (empty($_FILES['image']['name'])) {
            $image_name = $old_image;
        } else {
            unlink("../app/users/upload/$old_image");
            $image_name = rand(0, 1000) . $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $location = "../app/users/upload/$image_name";
            $_SESSION['admin']['image'] = $image_name;
            move_uploaded_file($image_tmp, $location);
        }

        $update = "UPDATE users SET name = '$name', email = '$email',image='$image_name' where id =$profile_id";
        $u = mysqli_query($connect, $update);


        redirect("pages/profile.php");
        $_SESSION['message'] = "change Data Successfully";
    }
}



if (isset($_POST['change_password'])) {
    $current_password = $_POST['password'];
    $selectPassword = "SELECT `password` FROM users  where id =$profile_id  ";
    $selectPasswrd2 = mysqli_query($connect, $selectPassword);
    $row  = mysqli_fetch_assoc($selectPasswrd2);
    $old_password = $row['password'];
    $true_old_password = password_verify($current_password, $old_password);
    // ------------------ 
    $newpassword = $_POST['newpassword'];
    $confirm_password = $_POST['confirm_password'];
    if ($true_old_password) {

        if ($newpassword == $confirm_password) {
            $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
            $update = "UPDATE users SET `password`= '$hash_password' where id =$profile_id";
            $u = mysqli_query($connect, $update);
            
            redirect("pages/profile.php");
            $_SESSION['message'] = "change password Successfully";
        } else {
            redirect("pages/profile.php");
            $_SESSION['message'] = "Your Password Confirmation InValid !";
        }
    } else {
        redirect("pages/profile.php");
        $_SESSION['message'] = "Your Current Password InValid !";
    }
}
