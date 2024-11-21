<?php


try {
    $connect = mysqli_connect("localhost", "root", "", "round30_online");
 
} catch (Exception $e) {
    echo $e->getMessage();
}
