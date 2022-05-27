<?php
include 'includes/header.php';
$question = fetchData($connection, 'SELECT * FROM question');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (insertData($connection, 'answer', [
        'answer' => $_POST['name'],
        'id_question' => $_POST['id_question'],
        'nilai' => $_POST['nilai'],
    ])) {
        $_SESSION['success'] = 'Berhasil tambah data';
        echo ("<script>location.href = 'answer.php';</script>");
    } else {
        $_SESSION['error'] = 'Gagal tambah data';
    }
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 text-capitalize font-weight-bold">jawaban</h1>
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
                    <label for="id_question" class="text-capitalize">pertanyaan</label>
                    <select name="id_question" class="form-control required" id="id_question">
                        <option value="">-</option>
                        <?php foreach ($question as $item) : ?>
                            <option value="<?= $item['id'] ?>"><?= $item['question'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                </div>
                <div class="form-group">
                    <label for="name" class="text-capitalize">jawaban</label>
                    <input type="text" name="name" id="name" class="form-control required">
                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                </div>
                <div class="form-group">
                    <label for="nilai" class="text-capitalize">nilai</label>
                    <input type="number" min="1" max="5" name="nilai" id="nilai" class="form-control required">
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