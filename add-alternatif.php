<?php
include 'admin/config/crud.php';
if (isset($_GET['id'])) {
    if (!isset($_SESSION['alternatif'])) {
        $_SESSION['alternatif'] = [$_GET['id']];
    } else {
        if (!in_array($_GET['id'], $_SESSION['alternatif'])) {
            array_push($_SESSION['alternatif'], $_GET['id']);
        }
    }
}
header("location: $_SESSION[referer]");
