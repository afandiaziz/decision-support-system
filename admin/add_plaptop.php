<?php
include 'includes/header.php';
$laptop = fetchData($connection, 'SELECT * FROM laptop WHERE id NOT IN (SELECT distinct(bobot_laptop.id_laptop) FROM bobot_laptop)');
$kriteria = fetchData($connection, 'SELECT * FROM kriteria');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($kriteria as $item) {
        if ($_POST[$item['id']]) {
            insertData($connection, 'bobot_laptop', [
                'id_laptop' => $_POST['id_laptop'],
                'id_kriteria' => $item['id'],
                'score' => $_POST[$item['id']]
            ]);
        }
    }
    $_SESSION['success'] = 'Berhasil tambah data';
    echo ("<script>location.href = 'penilaian-laptop.php';</script>");
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 text-capitalize font-weight-bold">penilaian laptop</h1>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php unset($_SESSION['error']);
    endif; ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="id_laptop" class="text-capitalize">Laptop</label>
                            <select name="id_laptop" required id="id_laptop" class="form-control">
                                <option value="">-</option>
                                <?php foreach ($laptop as $item) : ?>
                                    <option value="<?= $item['id'] ?>"><?= $item['name'] ?> - Rp. <?= number_format($item['price'], 2, ',', '.') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <th>Kriteria</th>
                                <th>Nilai</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($kriteria as $item) :
                                    $min = getData($connection, "answer INNER JOIN question ON question.id = answer.id_question WHERE question.id_kriteria = '$item[id]' ORDER BY answer.nilai ASC");
                                    $max = getData($connection, "answer INNER JOIN question ON question.id = answer.id_question WHERE question.id_kriteria = '$item[id]' ORDER BY answer.nilai DESC");
                                ?>
                                    <tr>
                                        <th width="20%" class="text-right align-middle"><?= $item['name'] ?></th>
                                        <td><input min="<?= $min['nilai'] ?>" max="<?= $max['nilai'] ?>" type="number" name="<?= $item['id'] ?>" class="form-control" required></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?php include 'includes/footer.php'; ?>