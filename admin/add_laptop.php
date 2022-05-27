<?php
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_FILES['image']['name']) {
        $filename = date('YmdGis') . $_FILES["image"]["name"];
        if (move_uploaded_file($_FILES["image"]["tmp_name"], '../images/' . $filename)) {;
            if (insertData($connection, 'laptop', [
                'name' => $_POST['name'],
                'os' => $_POST['os'],
                'weight' => $_POST['weight'],
                'ram_size' => $_POST['ram_size'],
                'ram_type' => $_POST['ram_type'],
                'cpu_prod' => $_POST['cpu_prod'],
                'cpu_model' => $_POST['cpu_model'],
                'storage_size' => $_POST['storage_size'],
                'storage_type' => $_POST['storage_type'],
                'gpu_prod' => $_POST['gpu_prod'],
                'gpu_model' => $_POST['gpu_model'],
                'battery' => $_POST['battery'],
                'display' => $_POST['display'],
                'price' => $_POST['price'],
                'image' => $filename
            ])) {
                $_SESSION['success'] = 'Berhasil tambah data';
                echo ("<script>location.href = 'laptop.php';</script>");
            } else {
                $_SESSION['error'] = 'Gagal tambah data';
            }
        } else {
            $_SESSION['error'] = 'Gagal upload gambar';
        }
    } else {
        $_SESSION['error'] = 'Silahkan pilih gambar';
    }
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 text-capitalize font-weight-bold">laptop</h1>
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
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="text-capitalize">name</label>
                            <input type="text" name="name" id="name" class="form-control required">
                            <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                        </div>
                        <div class="form-group">
                            <label for="os" class="text-capitalize">OS</label>
                            <input type="text" name="os" id="os" class="form-control required">
                            <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                        </div>
                        <div class="form-group">
                            <label for="weight" class="text-capitalize">weight</label>
                            <input type="text" name="weight" id="weight" class="form-control required">
                            <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ram_size" class="text-capitalize">RAM size</label>
                                    <input type="text" name="ram_size" id="ram_size" class="form-control required">
                                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ram_type" class="text-capitalize">RAM type</label>
                                    <input type="text" name="ram_type" id="ram_type" class="form-control required">
                                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cpu_prod" class="text-capitalize">Processor Type</label>
                                    <input type="text" name="cpu_prod" id="cpu_prod" class="form-control required">
                                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cpu_model" class="text-capitalize">Processor Model</label>
                                    <input type="text" name="cpu_model" id="cpu_model" class="form-control required">
                                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="storage_size" class="text-capitalize">Storage size</label>
                                    <input type="text" name="storage_size" id="storage_size" class="form-control required">
                                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="storage_type" class="text-capitalize">Storage type</label>
                                    <input type="text" name="storage_type" id="storage_type" class="form-control required">
                                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="gpu_prod" class="text-capitalize">GPU Type</label>
                                    <input type="text" name="gpu_prod" id="gpu_prod" class="form-control required">
                                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="gpu_model" class="text-capitalize">GPU Model</label>
                                    <input type="text" name="gpu_model" id="gpu_model" class="form-control required">
                                    <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="battery" class="text-capitalize">Estimated battery</label>
                            <input type="text" name="battery" id="battery" class="form-control required">
                            <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                        </div>
                        <div class="form-group">
                            <label for="display" class="text-capitalize">display</label>
                            <input type="text" name="display" id="display" class="form-control required">
                            <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="text-capitalize">price</label>
                            <input type="text" name="price" id="price" class="form-control required">
                            <div class="small text-danger d-none">Tidak Boleh Kosong</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" required data-height="320" accept="image/*" class="form-control dropify">
                        </div>
                    </div>
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