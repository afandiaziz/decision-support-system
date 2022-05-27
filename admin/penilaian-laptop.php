<?php include 'includes/header.php'; ?>
<?php
$sql = 'SELECT distinct(bobot_laptop.id_laptop), laptop.name FROM bobot_laptop LEFT JOIN laptop ON bobot_laptop.id_laptop = laptop.id';
$data = fetchData($connection, $sql);
$kriteria = fetchData($connection, 'SELECT * FROM kriteria');
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold text-capitalize">penilaian Laptop</h1>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php unset($_SESSION['error']);
    endif; ?>
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php unset($_SESSION['success']);
    endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="add_plaptop.php" class="btn btn-primary">Tambah Data</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-hover table-striped" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <?php
                            foreach ($kriteria as $item) {
                                echo "<th>$item[name]</th>";
                            }
                            ?>
                            <th class="text-center"><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data) : ?>
                            <?php foreach ($data as $item) : ?>
                                <tr>
                                    <td><?= $item['name'] ?></td>
                                    <?php
                                    foreach ($kriteria as $n) {
                                        echo "<td>" . getData($connection, "bobot_laptop WHERE id_kriteria='$n[id]' AND id_laptop='$item[id_laptop]'")['score'] . "</td>";
                                    }
                                    ?>
                                    <td class="text-center align-middle">
                                        <a href="edit_plaptop.php?id_laptop=<?= $item['id_laptop'] ?>" class="btn btn-info">Edit</a>
                                        <a href="delete_plaptop.php?id_laptop=<?= $item['id_laptop'] ?>" class="btn btn-danger">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center">Data Kosong</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?php include 'includes/footer.php'; ?>