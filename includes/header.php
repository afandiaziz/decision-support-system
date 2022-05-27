<?php
include 'admin/config/crud.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Afandi Aziz" />
    <title>Decision Support System</title>
    <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="vendor/jquery/jquery-3.6.0.min.js"></script>
    <style>
        .bg-different {
            background-color: #f6f9ff;
        }

        .products-thumbnail {
            width: 100%;
            height: 180px;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .products-thumbnail:hover .products-image,
        .products-thumbnail:focus .products-image {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        .products-thumbnail .products-image {
            width: 100%;
            height: 100%;
            background-color: #fff;
            background-position: center;
            background-size: contain;
            background-repeat: no-repeat;
            -webkit-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>