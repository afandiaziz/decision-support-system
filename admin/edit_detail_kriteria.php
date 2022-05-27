<?php
include 'includes/header.php';
$kriteria = fetchData($connection, 'SELECT * FROM kriteria');
$data = getData($connection, 'detail_kriteria', $_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (updateData($connection, 'detail_kriteria', $_GET['id'], [
        'name' => $_POST['name'],
        'id_kriteria' => $_POST['id_kriteria'],
        'nilai' => $_POST['nilai'],
    ])) {
        $_SESSION['success'] = 'Berhasil tambah data';
        echo ("<script>location.href = 'detail-kriteria.php';</script>");
    } else {
        $_SESSION['error'] = 'Gagal tambah data';
    }
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 text-capitalize font-weight-bold">detail kriteria</h1>
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
            <form action="" method="post" id="form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="text-capitalize">name</label>
                    <input type="text" name="name" id="name" class="form-control required" value="<?= $data['name'] ?>">
                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                </div>
                <div class="form-group">
                    <label for="id_kriteria" class="text-capitalize">kriteria</label>
                    <select name="id_kriteria" class="form-control required" id="id_kriteria">
                        <option value="">-</option>
                        <?php foreach ($kriteria as $item) : ?>
                            <option <?= ($data['id_kriteria'] == $item['id'] ? 'selected' : '') ?> value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                </div>
                <div class="form-group">
                    <label for="nilai" class="text-capitalize">nilai</label>
                    <input type="number" min="1" max="5" name="nilai" id="nilai" class="form-control required" value="<?= $data['nilai'] ?>">
                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#form').submit(function(e) {
            const required = $('.required');
            let x = 0;
            required.map((index, item) => {
                if ($('#' + item.getAttribute('id')).val().trim()) {
                    $('#' + item.getAttribute('id')).removeClass('is-invalid').removeAttr('required');
                    x++;
                } else {
                    if (index == x) {
                        $('#' + item.getAttribute('id')).addClass('is-invalid').attr('required', 'required').focus();
                    } else {
                        $('#' + item.getAttribute('id')).addClass('is-invalid').attr('required', 'required');
                    }
                }
            });
            const y = $('.required.is-invalid');
            if (y.length) {
                e.preventDefault();
                return false;
            } else {
                return true;
            }
        });
    });
</script>
<!-- /.container-fluid -->
<?php include 'includes/footer.php'; ?>