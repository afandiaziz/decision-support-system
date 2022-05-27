<?php
include 'admin/config/crud.php';
if (isset($_GET['id']) && isset($_SESSION['alternatif'])) {
    if (in_array($_GET['id'], $_SESSION['alternatif'])) {
        $x = $_SESSION['alternatif'];
        $key = array_search($_GET['id'], $x);
        unset($x[$key]);
        $_SESSION['alternatif'] = $x;
    }
}
header("location: $_SESSION[referer]");
