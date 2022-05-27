<?php
include 'config/crud.php';
if (deleteData($connection, 'kriteria', $_GET['id'], false)) {
    $_SESSION['success'] = 'Berhasil hapus data';
} else {
    $_SESSION['error'] = 'Gagal hapus data';
}
header('location:kriteria.php');
