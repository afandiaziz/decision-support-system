<?php
include 'admin/config/crud.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $kriteria = fetchData($connection, "SELECT * FROM kriteria");
    if (count($_POST) == count($kriteria)) {
        $_SESSION['bobot'] = $_POST;
        header("location: result.php");
    } else {
        header("location: $_SESSION[referer]?error");
    }
} else {
    header("location: $_SESSION[referer]");
}
