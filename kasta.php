<?php
include 'includes/header.php';
$laptopx = fetchData($connection, 'SELECT * FROM laptop');

$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION['referer'] = $currentUrl;

?>

<div class="page-content page-home">
    <section class="py-5 bg-different">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <table class="table table-sm table-hover table-bordered">
                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($laptopx as $item) :
                                // if ($item['price'] >= 0 && $item['price'] <= 5000000) {
                                //     $score = 1;
                                // } else if ($item['price'] > 5000000 && $item['price'] <= 7000000) {
                                //     $score = 2;
                                // } else if ($item['price'] > 7000000 && $item['price'] <= 10000000) {
                                //     $score = 3;
                                // } else if ($item['price'] > 10000000 && $item['price'] <= 15000000) {
                                //     $score = 4;
                                // } else if ($item['price'] > 15000000) {
                                //     $score = 5;
                                // }
                                if ($item['battery'] > 0 && $item['battery'] <= 4) {
                                    $score = 1;
                                } else if ($item['battery'] > 4 && $item['battery'] <= 8) {
                                    $score = 2;
                                } else if ($item['battery'] > 8) {
                                    $score = 3;
                                }
                                // insertData($connection, 'bobot_laptop', [
                                //     'id_laptop' => $item['id'],
                                //     'id_kriteria' => 6,
                                //     'score' => $score
                                // ]);
                            ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= $item['battery'] ?></td>
                                    <td><?= $score ?></td>
                                </tr>
                            <?php
                                $no++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>

                    <?= $no ?>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include 'includes/footer.php'; ?>