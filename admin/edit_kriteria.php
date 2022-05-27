<?php
include 'includes/header.php';
$data = getData($connection, 'kriteria', $_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (updateData($connection, 'kriteria', $_GET['id'], [
        'name' => $_POST['name'],
        'best' => $_POST['best'],
        'worst' => $_POST['worst']
    ])) {
        $_SESSION['success'] = 'Berhasil edit data';
        echo ("<script>location.href = 'kriteria.php';</script>");
    } else {
        $_SESSION['error'] = 'Gagal edit data';
    }
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 text-capitalize font-weight-bold">kriteria</h1>
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
            <form action="?id=<?= $data['id'] ?>" id="form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="text-capitalize">name</label>
                    <input type="text" name="name" id="name" class="form-control required" value="<?= $data['name'] ?>">
                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                </div>
                <div class="form-group">
                    <label for="best" class="text-capitalize">ideal best</label>
                    <div class="d-flex">
                        <div class="mr-3 custom-control custom-radio">
                            <input type="radio" name="best" id="best-max" value="1" <?= $data['best'] == 1 ? 'checked' : '' ?> class="form-control custom-control-input" required>
                            <label class="custom-control-label" for="best-max">Max</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" name="best" id="best-min" value="0" <?= $data['best'] == 0 ? 'checked' : '' ?> class="form-control custom-control-input" required>
                            <label class="custom-control-label" for="best-min">Min</label>
                        </div>
                    </div>
                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                </div>
                <div class="form-group">
                    <label for="worst" class="text-capitalize">ideal worst</label>
                    <div class="d-flex">
                        <div class="mr-3 custom-control custom-radio">
                            <input type="radio" name="worst" id="worst-max" value="1" <?= $data['worst'] == 1 ? 'checked' : '' ?> class="form-control custom-control-input" required>
                            <label class="custom-control-label" for="worst-max">Max</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" name="worst" id="worst-min" value="0" <?= $data['worst'] == 0 ? 'checked' : '' ?> class="form-control custom-control-input" required>
                            <label class="custom-control-label" for="worst-min">Min</label>
                        </div>
                    </div>
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