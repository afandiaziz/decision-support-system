<?php
include 'includes/header.php';
$data = getData($connection, 'laptop', $_GET['id_laptop']);
$kriteria = fetchData($connection, 'SELECT * FROM kriteria');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($kriteria as $item) {
        if ($_POST[$item['id']]) {
            updateData($connection, 'bobot_laptop', $_GET['id_laptop'], [
                'score' => $_POST[$item['id']]
            ], " WHERE id_laptop='$_GET[id_laptop]' AND id_kriteria='$item[id]'");
        }
    }
    $_SESSION['success'] = 'Berhasil edit data';
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
            <form action="?id_laptop=<?= $_GET['id_laptop'] ?>" method="post">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="text-capitalize">Laptop</label>
                            <input type="text" id="name" class="form-control required" readonly disabled value="<?= $data['name'] ?>">
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
                                    $score = getData($connection, "bobot_laptop WHERE bobot_laptop.id_kriteria = '$item[id]' AND bobot_laptop.id_laptop = '$_GET[id_laptop]'");
                                ?>
                                    <tr>
                                        <th width="20%" class="text-right align-middle"><?= $item['name'] ?></th>
                                        <td><input value="<?= $score['score'] ?>" min="<?= $min['nilai'] ?>" max="<?= $max['nilai'] ?>" type="number" name="<?= $item['id'] ?>" class="form-control" required></td>
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