<?php

session_start();

define("Base_URL", "http://localhost/online/");

function URL($var = null)
{
    return Base_URL . $var;
}



function redirect($var = null)
{
    echo "
<script>
    window.location.replace('http://localhost/online/$var');
</script>";
}
if (isset($_POST['delete_message'])) {
    echo "hell wolrd";
    unset($_SESSION['message']);
    $currentPATH = $_POST['currentPATH'];
    header("location: $currentPATH");
}




function auth($rule1 = null, $rule2 = null)
{
    if ($_COOKIE['isAdmin']) {
        $rule_numner = $_SESSION['admin']['rule'];
        if ($rule_numner == 1 || $rule_numner == $rule1 || $rule_numner == $rule2) {
        } else {
            redirect('pages/error404.php');
        }
    } else {
        redirect('pages/login.php');
    }
}



function guest()
{
    if (isset($_SESSION['admin'])) {
        redirect('');
    }
}
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie("isAdmin", $email, time() - 3213, '/');
    redirect('pages/login.php');
}











// Validation functions:
function filterValidation($input)
{
    $input = ltrim($input);
    $input = rtrim($input);
    $input = strip_tags($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}



function string_validation($input, $maxlen = 20, $minlen = 3)
{

    $isEmpty  = empty($input);
    $isBiggerLen = strlen($input) >  $maxlen;
    $isSmalllen = strlen($input) < $minlen;
    if ($isEmpty || $isBiggerLen || $isSmalllen) {
        return true;
    } else {
        return false;
    }
}



function email_validation($input, $maxlen = 60, $minlen = 3)
{
    $isEmpty  = empty($input);
    $isBiggerLen = strlen($input) >  $maxlen;
    $isSmalllen = strlen($input) < $minlen;
    $isNotMail =  !filter_var($input, FILTER_VALIDATE_EMAIL);
    if ($isEmpty || $isBiggerLen || $isSmalllen || $isNotMail) {
        return true;
    } else {
        return false;
    }
}


function number_validation($input)
{
    $isEmpty  = empty($input);
    $isNagtive  = $input < 0;
    $isNotNumber =  !filter_var($input, FILTER_VALIDATE_FLOAT);
    if ($isEmpty || $isNotNumber || $isNagtive) {
        return true;
    } else {
        return false;
    }
}




function size_file_validation($file_size, $you_req_size  = 2)
{
    $migaSize = ($file_size / 1024) / 1024;
    $isBiggerLen =  $migaSize  > $you_req_size;
    if ($isBiggerLen) {
        return true;
    } else {
        return false;
    }
}


function file_type_validation($your_file_type, $type1 = null, $type2 = null, $type4 = null, $type5 = null)
{
    if ($your_file_type == $type1 || $your_file_type == $type2 || $your_file_type == $type4 || $your_file_type == $type5) {
        return false;
    } else {
        return true;
    }
}
