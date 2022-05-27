<?php
include 'includes/header.php';
if (!isset($_SESSION['alternatif']) || count($_SESSION['alternatif']) < 2) {
    header("location: index.php");
}

$imploded = implode(',', $_SESSION['alternatif']);
$laptop = fetchData($connection, "SELECT * FROM v_laptop WHERE id IN ($imploded)");
$questions = fetchData($connection, "SELECT question.*, kriteria.name  FROM question LEFT JOIN kriteria ON question.id_kriteria = kriteria.id");
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION['referer'] = $currentUrl;
?>

<div class="page-content page-home">
    <?php if (isset($_GET['error'])) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Isi semua pertanyaan!</strong>
        </div>
    <?php endif; ?>
    <section class="py-4 bg-different">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-9">
                    <?php if (isset($_SESSION['alternatif'])) : ?>
                        <div class="row">
                            <div class="col-12 shadow-sm bg-white mb-3 h3 py-2" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#cAlternatif">
                                Alternatif (<?= count($_SESSION['alternatif']) ?>)
                            </div>
                            <?php $index = 0;
                            foreach ($laptop as $item) : ?>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4 collapse" id="cAlternatif">
                                    <div class="card shadow-sm text-center border-0">
                                        <div class="card-body">
                                            <div class="products-thumbnail">
                                                <div class="products-image" style="background-image: url('<?= $item['image'] ?>')"></div>
                                            </div>
                                            <h5 class="fw-bold text-warning mb-2 mt-3">Rp. <?= number_format($item['price'], 2, ',', '.') ?></h5>
                                            <div class="fw-bold text-dark mb-2"><?= $item['name'] ?></div>
                                            <table class="table table-sm table-striped small">
                                                <tbody>
                                                    <tr>
                                                        <td>Processor</td>
                                                        <td><?= $item['cpu'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Memory</td>
                                                        <td><?= $item['ram'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Storage</td>
                                                        <td><?= $item['storage'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Graphic</td>
                                                        <td><?= $item['gpu'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Berat</td>
                                                        <td><?= $item['weight'] ?> Kg</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Layar</td>
                                                        <td><?= $item['display'] ?>"</td>
                                                    </tr>
                                                    <tr>
                                                        <td>OS</td>
                                                        <td><?= $item['os'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Estimasi Baterai</td>
                                                        <td><?= $item['battery'] ?> jam</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="d-grid">
                                                <a href="delete-alternatif.php?id=<?= $item['id'] ?>" class="btn btn-danger">Delete from Alternatif</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $index++;
                            endforeach; ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>
    <div style="background-color: #f5f5f5;">
        <div class="container-fluid py-5">
            <div class="row justify-content-center">
                <div class="col-9 mb-4">
                    <div class="h3 mb-3">Jawablah pertanyaan berikut untuk menentukan bobot prefenresi</div>
                </div>
                <div class="col-9">
                    <form action="process-bobot.php" method="post">
                        <?php
                        $indexQ = 1;
                        foreach ($questions as $item) :
                            $answers = fetchData($connection, "SELECT * FROM answer WHERE id_question = '$item[id]'");
                        ?>
                            <div class="card card-body border-0">
                                <p>
                                    <?= $indexQ ?>.&nbsp; <?= $item['question'] ?>
                                </p>
                                <div class="ps-4">
                                    <?php $indexA = 0;
                                    foreach ($answers as $answer) : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" required name="<?= strtolower($item['name']) ?>" value="<?= $answer['nilai'] ?>" id="<?= $indexQ ?><?= $indexA ?>y">
                                            <label class="form-check-label" for="<?= $indexQ ?><?= $indexA ?>y">
                                                <?= $answer['answer'] ?>
                                            </label>
                                        </div>
                                    <?php $indexA++;
                                    endforeach; ?>
                                </div>
                            </div>
                        <?php $indexQ++;
                        endforeach; ?>
                        <div class="mt-4">
                            <button type="reset" class="btn btn-warning me-3 text-uppercase">Reset</button>
                            <button type="submit" class="btn btn-success text-uppercase">Proses</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>