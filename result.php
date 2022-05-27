<?php
include 'includes/header.php';

if (isset($_SESSION['alternatif']) && isset($_SESSION['bobot']) && $_SESSION['bobot'] && $_SESSION['alternatif']) {
    $imploded = implode(',', $_SESSION['alternatif']);
    $laptop = fetchData($connection, "SELECT * FROM v_laptop WHERE id IN ($imploded)");
    $kriteria = fetchData($connection, "SELECT * FROM kriteria");

    $bobotPreferensi = [];
    $step1 = [];
    $step2 = [];
    $step3 = [];
    $step4 = [];
    $step5 = [];
    $step6 = [];
} else {
    header('location: index.php');
}
?>

<div class="page-content page-home">
    <section class="py-5" style="background-color: #f5f5f5;">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 text-uppercase">Alternatif</h4>
                        </div>
                        <div class="card-body table-responsive" style="white-space: nowrap;">
                            <table class="table table-sm table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Laptop</th>
                                        <th>RAM/Memory</th>
                                        <th>CPU/Processor</th>
                                        <th>GPU/Graphic</th>
                                        <th>Storage</th>
                                        <th>Berat</th>
                                        <th>Display/Layar (Inch)</th>
                                        <th>OS</th>
                                        <th>Estimasi Baterai</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($laptop as $item) :
                                    ?>
                                        <tr>
                                            <td><?= $no + 1 ?></td>
                                            <td><?= $item['name'] ?></td>
                                            <td><?= $item['ram'] ?></td>
                                            <td><?= $item['cpu'] ?></td>
                                            <td><?= $item['gpu'] ?></td>
                                            <td><?= $item['storage'] ?></td>
                                            <td><?= $item['weight'] ?> Kg</td>
                                            <td><?= $item['display'] ?>"</td>
                                            <td><?= $item['os'] ?></td>
                                            <td><?= $item['battery'] ?> jam</td>
                                            <td class="text-dark fw-bold">Rp. <?= number_format($item['price'], 2, ',', '.') ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" style="display: none;" id="fnd-result-explanation">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">STEP 1</h4>
                        </div>
                        <div class="card-body table-responsive" style="white-space: nowrap;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="mb-2">TABEL DATA SESUAI PEMBOBOTAN MASING MASING LAPTOP</h4>
                                    <table class="table table-sm table-hover table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <?php foreach ($kriteria as $item) : ?>
                                                    <th><?= $item['name'] ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 0;
                                            foreach ($laptop as $item) :
                                                $x = [];
                                                $indexK = 0;
                                                foreach ($kriteria as $itemK) {
                                                    $bobotLaptop = getData($connection, "bobot_laptop WHERE bobot_laptop.id_laptop = '$item[id]' AND bobot_laptop.id_kriteria = '$itemK[id]'");
                                                    $x[$indexK] = $bobotLaptop['score'];
                                                    $indexK++;
                                                }
                                                $step1[$no] = $x;
                                            ?>
                                                <tr>
                                                    <td><?= $no + 1 ?></td>
                                                    <?php foreach ($x as $itemKBl) : ?>
                                                        <td><?= $itemKBl ?></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            <?php
                                                $no++;
                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <h4 class="mb-2">PEMBOBOTAN PREFERENSI SESUAI DENGAN PERTANYAAN</h4>
                                    <table class="table table-sm table-hover table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="33%"></th>
                                                <th>Bobot</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 0;
                                            foreach ($_SESSION['bobot'] as $item) :
                                                $bobotPreferensi[$no] = $_SESSION['bobot'][strtolower($kriteria[$no]['name'])];
                                            ?>
                                                <tr>
                                                    <th>Pertanyaan <?= $no + 1 ?> (<?= $kriteria[$no]['name'] ?>)</th>
                                                    <td><?= $bobotPreferensi[$no] ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">STEP 2</h4>
                        </div>
                        <div class="card-body table-responsive" style="white-space: nowrap;">
                            <h4 class="text-center text-uppercase">BUAT MATRIKS TERNORMALISASI R</h4>
                            <table class="table table-sm table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <?php foreach ($kriteria as $item) : ?>
                                            <th><?= $item['name'] ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($step1); $i++) {
                                    ?>
                                        <tr>
                                            <td><?= $i + 1 ?></td>
                                            <?php
                                            for ($j = 0; $j < count($_SESSION['bobot']); $j++) {
                                                $n = 0;
                                                for ($k = 0; $k < count($step1); $k++) {
                                                    $n += pow($step1[$k][$j], 2);
                                                }
                                                $n = $step1[$i][$j] / pow($n, 0.5);
                                                $step2[$j][$i] = $n;
                                            ?>
                                                <td><?= $n ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">STEP 3</h4>
                        </div>
                        <div class="card-body table-responsive" style="white-space: nowrap;">
                            <h4 class="text-center text-uppercase">MATRIKS TERNORMALISASI R x BOBOT YANG DITENTUKAN OLEH USER</h4>
                            <table class="table table-sm table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <?php foreach ($kriteria as $item) : ?>
                                            <th><?= $item['name'] ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($step1); $i++) {
                                    ?>
                                        <tr>
                                            <td><?= $i + 1 ?></td>
                                            <?php
                                            for ($j = 0; $j < count($step2); $j++) {
                                                $n = $bobotPreferensi[$j] * $step2[$j][$i];
                                                $step3[$j][$i] = $n;
                                            ?>
                                                <td><?= $n ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">STEP 4</h4>
                        </div>
                        <div class="card-body table-responsive" style="white-space: nowrap;">
                            <h4 class="text-center text-uppercase">IDEAL BEST DAN IDEAL WORST</h4>
                            <table class="table table-sm table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <?php foreach ($kriteria as $item) : ?>
                                            <th><?= $item['name'] ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-center">A<sup>+</sup></th>
                                        <?php
                                        for ($i = 0; $i < count($step3); $i++) {
                                            if (!$kriteria[$i]['best']) {
                                                $step4[$i][0] = min($step3[$i]);
                                        ?>
                                                <td><?= min($step3[$i]) ?></td>
                                            <?php
                                            } else {
                                                $step4[$i][0] = max($step3[$i]);
                                            ?>
                                                <td><?= max($step3[$i]) ?></td>
                                        <?php }
                                        } ?>
                                    </tr>
                                    <tr>
                                        <th class="text-center">A<sup>-</sup></th>
                                        <?php
                                        for ($i = 0; $i < count($step3); $i++) {
                                            if ($kriteria[$i]['worst']) {
                                                $step4[$i][1] = max($step3[$i]);
                                        ?>
                                                <td><?= max($step3[$i]) ?></td>
                                            <?php
                                            } else {
                                                $step4[$i][1] = min($step3[$i]);
                                            ?>
                                                <td><?= min($step3[$i]) ?></td>
                                        <?php }
                                        } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 text-uppercase">STEP 5</h4>
                        </div>
                        <div class="card-body table-responsive" style="white-space: nowrap;">
                            <h4 class="text-uppercase text-center">menentukan Jarak antara <br>nilai terbobot setiap alternatif terhadap solusi ideal positif (Di+)
                                <br>dan<br>
                                nilai terbobot setiap alternatif terhadap solusi ideal negatif (Di-)
                            </h4>
                            <table class="table table-sm table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>D<sub>i</sub><sup>+</sup></th>
                                        <th>D<sub>i</sub><sup>-</sup></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($step1); $i++) {
                                    ?>
                                        <tr>
                                            <?php
                                            $diPlus = 0;
                                            $diMinus = 0;
                                            for ($j = 0; $j < count($step4); $j++) {
                                                $diPlus += pow(($step3[$j][$i] - $step4[$j][0]), 2);
                                                $diMinus += pow(($step3[$j][$i] - $step4[$j][1]), 2);
                                            }
                                            $diPlus = pow($diPlus, 0.5);
                                            $diMinus = pow($diMinus, 0.5);
                                            $step5[0][$i] = $diPlus;
                                            $step5[1][$i] = $diMinus;
                                            ?>
                                            <td><?= $diPlus ?></td>
                                            <td><?= $diMinus ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 text-uppercase">STEP 6</h4>
                        </div>
                        <div class="card-body table-responsive" style="white-space: nowrap;">
                            <h4 class="text-uppercase text-center">Nilai preferensi untuk setiap alternatif <br>
                                dan<br>
                                RANK PENENTUAN
                            </h4>
                            <table class="table table-sm table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="25%">V<sub>i</sub></th>
                                        <th>Rank</th>
                                        <th>Laptop</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($step5[0]); $i++) {
                                        $step6[$i] = $step5[1][$i] / ($step5[0][$i] + $step5[1][$i]);
                                    }
                                    $ordered_step6 = $step6;
                                    rsort($ordered_step6);

                                    $no = 0;
                                    foreach ($step6 as $key => $value) {
                                        foreach ($ordered_step6 as $ordered_key => $ordered_value) {
                                            if ($value === $ordered_value) {
                                                $key = $ordered_key;
                                                break;
                                            }
                                        }
                                    ?>
                                        <tr class="<?= (((int) $key + 1) == 1 ? 'table-success fw-bold' : '') ?>">
                                            <td><?= $value ?></td>
                                            <td><?= ((int) $key + 1) ?></td>
                                            <td><?= $laptop[$no]['name'] ?></td>
                                        </tr>
                                    <?php $no++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="fnd-result">
                <div class="col-10 mb-4">
                    <div class="card">
                        <div class="card-body table-responsive" style="white-space: nowrap;">
                            <h4 class="text-uppercase">Hasil</h4>
                            <table class="table table-sm table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="25%">V<sub>i</sub></th>
                                        <th>Rank</th>
                                        <th>Laptop</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($step5[0]); $i++) {
                                        $step6[$i] = $step5[1][$i] / ($step5[0][$i] + $step5[1][$i]);
                                    }
                                    $ordered_step6 = $step6;
                                    rsort($ordered_step6);

                                    $no = 0;
                                    foreach ($step6 as $key => $value) {
                                        foreach ($ordered_step6 as $ordered_key => $ordered_value) {
                                            if ($value === $ordered_value) {
                                                $key = $ordered_key;
                                                break;
                                            }
                                        }
                                    ?>
                                        <tr class="<?= (((int) $key + 1) == 1 ? 'table-success fw-bold' : '') ?>">
                                            <td><?= $value ?></td>
                                            <td><?= ((int) $key + 1) ?></td>
                                            <td><?= $laptop[$no]['name'] ?></td>
                                        </tr>
                                    <?php $no++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="d-grid">
                        <button type="button" onclick="explanation()" id="btn-toggle-show" class="btn btn-lg btn-info">Lihat Penjelasan</button>
                        <button type="button" onclick="explanation()" id="btn-toggle-hide" style="display: none;" class="btn btn-lg btn-info">Sembunyikan Penjelasan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    function explanation(show) {
        $('#btn-toggle-show, #btn-toggle-hide').fadeToggle();
        $('#fnd-result, #fnd-result-explanation').slideToggle();
    }
</script>
<?php include 'includes/footer.php'; ?>