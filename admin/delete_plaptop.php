<?php
include 'config/crud.php';
if (deleteData($connection, 'bobot_laptop', $_GET['id_laptop'], false, " WHERE id_laptop='$_GET[id_laptop]'")) {
    $_SESSION['success'] = 'Berhasil hapus data';
} else {
    $_SESSION['error'] = 'Gagal hapus data';
}
header('location:penilaian-laptop.php');
