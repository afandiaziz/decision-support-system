<?php
include 'includes/header.php';
$sql = 'SELECT * FROM v_laptop';
if (isset($_GET['brand']) && $_GET['brand']) {
    $sql .= ' WHERE brand = "' . $_GET['brand'] . '"';
} else {
    $sql .= ' WHERE brand LIKE "%%"';
}
if (isset($_GET['memory']) && $_GET['memory']) {
    $sql .= ' AND ram LIKE "%' . $_GET['memory'] . '%"';
}
if (isset($_GET['name']) && $_GET['name']) {
    $sql .= ' AND name LIKE "%' . $_GET['name'] . '%"';
}
if (isset($_GET['cpu']) && $_GET['cpu']) {
    $sql .= ' AND cpu LIKE "%' . $_GET['cpu'] . '%"';
}
if (isset($_GET['storage']) && $_GET['storage']) {
    $sql .= ' AND storage LIKE "%' . $_GET['storage'] . '%"';
}
if (isset($_GET['gpu']) && $_GET['gpu']) {
    $sql .= ' AND gpu LIKE "%' . $_GET['gpu'] . '%"';
}
if (isset($_GET['min-weight']) && isset($_GET['max-weight'])) {
    $sql .= ' AND weight BETWEEN "' . ($_GET['min-weight'] ? $_GET['min-weight'] : 0) . '" and "' . ($_GET['max-weight'] ? $_GET['max-weight'] : 10) . '"';
}
if (isset($_GET['min-display']) && isset($_GET['max-display'])) {
    $sql .= ' AND display BETWEEN "' . ($_GET['min-display'] ? $_GET['min-display'] : 11) . '" and "' . ($_GET['max-display'] ? $_GET['max-display'] : 20) . '"';
}
if (isset($_GET['min-battery']) && isset($_GET['max-battery'])) {
    $sql .= ' AND battery BETWEEN "' . ($_GET['min-battery'] ? $_GET['min-battery'] : 0) . '" and "' . ($_GET['max-battery'] ? $_GET['max-battery'] : 24) . '"';
}
if (isset($_GET['min-price']) && isset($_GET['max-price'])) {
    $sql .= ' AND price BETWEEN "' . ($_GET['min-price'] ? $_GET['min-price'] : 0) . '" and "' . ($_GET['max-price'] ? $_GET['max-price'] : 200000000) . '"';
}
if (isset($_GET['os']) && $_GET['os']) {
    $sql .= ' AND os = "' . $_GET['os'] . '"';
}

$laptop = fetchData($connection, $sql);
$laptopNoFilter = fetchData($connection, 'SELECT * FROM v_laptop');
$brands = fetchData($connection, 'SELECT distinct(brand) FROM laptop');
$os = fetchData($connection, 'SELECT distinct(os) FROM laptop ORDER BY os');
$display = fetchData($connection, 'SELECT distinct(display) FROM laptop ORDER BY display');

$totalLaptop = countData($connection, "laptop");
$totalLaptopFiltered = countData($connection, str_replace('SELECT * FROM', '', $sql));
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION['referer'] = $currentUrl;

?>

<div class="page-content page-home">
    <section class="py-5 bg-different">
        <div class="container-fluid">
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-uppercase w-100">
                            <form action="" method="get">
                                <a href="index.php" class="btn btn-warning mb-3">Reset Filter</a>
                                <div class="form-group mb-3">
                                    <label for="name" class="mb-2 fw-bold text-capitalize">name</label>
                                    <input type="text" id="name" name="name" class="form-control" min="2" placeholder="Enter name..." value="<?= (isset($_GET['name']) && $_GET['name'] ? $_GET['name'] : null) ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="brand" class="mb-2 fw-bold text-capitalize">Brands</label>
                                    <select name="brand" class="form-control" id="brand">
                                        <option value="">All (<?= $totalLaptop ?>)</option>
                                        <?php foreach ($brands as $brand) : $total = countData($connection, "laptop WHERE brand='$brand[brand]'"); ?>
                                            <option value="<?= $brand['brand'] ?>" <?= (isset($_GET['brand']) && $_GET['brand'] == $brand['brand'] ? 'selected' : null) ?>><?= $brand['brand'] ?> (<?= $total ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="cpu" class="mb-2 fw-bold text-capitalize">processor</label>
                                    <input type="text" id="cpu" name="cpu" class="form-control" min="2" placeholder="Enter processor..." value="<?= (isset($_GET['cpu']) && $_GET['cpu'] ? $_GET['cpu'] : null) ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="memory" class="mb-2 fw-bold text-capitalize">Memory</label>
                                    <input type="text" id="memory" name="memory" class="form-control" min="2" placeholder="Enter memory..." value="<?= (isset($_GET['memory']) && $_GET['memory'] ? $_GET['memory'] : null) ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="storage" class="mb-2 fw-bold text-capitalize">storage</label>
                                    <input type="text" id="storage" name="storage" class="form-control" min="2" placeholder="Enter storage..." value="<?= (isset($_GET['storage']) && $_GET['storage'] ? $_GET['storage'] : null) ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="gpu" class="mb-2 fw-bold text-capitalize">Graphic</label>
                                    <input type="text" id="gpu" name="gpu" class="form-control" min="2" placeholder="Enter gpu..." value="<?= (isset($_GET['gpu']) && $_GET['gpu'] ? $_GET['gpu'] : null) ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="battery" class="mb-2 fw-bold text-capitalize">battery</label>
                                    <div class="d-flex">
                                        <div class="me-1 col-4">
                                            <input type="number" step="0.01" id="min-battery" name="min-battery" class="form-control" min="0" placeholder="Min" value="<?= (isset($_GET['min-battery']) && $_GET['min-battery'] ? $_GET['min-battery'] : null) ?>">
                                        </div>
                                        <div class="ms-1 col-4">
                                            <input type="number" step="0.01" id="max-battery" name="max-battery" class="form-control" max="24" placeholder="Max" value="<?= (isset($_GET['max-battery']) && $_GET['max-battery'] ? $_GET['max-battery'] : null) ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="weight" class="mb-2 fw-bold text-capitalize">weight</label>
                                    <div class="d-flex">
                                        <div class="me-1 col-4">
                                            <input type="number" step="0.01" id="min-weight" name="min-weight" class="form-control" min="0" placeholder="Min" value="<?= (isset($_GET['min-weight']) && $_GET['min-weight'] ? $_GET['min-weight'] : null) ?>">
                                        </div>
                                        <div class="ms-1 col-4">
                                            <input type="number" step="0.01" id="max-weight" name="max-weight" class="form-control" placeholder="Max" value="<?= (isset($_GET['max-weight']) && $_GET['max-weight'] ? $_GET['max-weight'] : null) ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="display" class="mb-2 fw-bold text-capitalize">display</label>
                                    <div class="d-flex">
                                        <div class="me-1 col-4">
                                            <input type="number" step="0.01" id="min-display" name="min-display" class="form-control" min="11" placeholder="Min" value="<?= (isset($_GET['min-display']) && $_GET['min-display'] ? $_GET['min-display'] : null) ?>">
                                        </div>
                                        <div class="ms-1 col-4">
                                            <input type="number" step="0.01" id="max-display" name="max-display" class="form-control" max="20" placeholder="Max" value="<?= (isset($_GET['max-display']) && $_GET['max-display'] ? $_GET['max-display'] : null) ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="price" class="mb-2 fw-bold text-capitalize">price</label>
                                    <div class="d-flex">
                                        <div class="me-1">
                                            <input type="number" step="0.01" id="min-price" name="min-price" class="form-control" min="0" placeholder="Min" value="<?= (isset($_GET['min-price']) && $_GET['min-price'] ? $_GET['min-price'] : null) ?>">
                                        </div>
                                        <div class="ms-1">
                                            <input type="number" step="0.01" id="max-price" name="max-price" class="form-control" min="0" placeholder="Max" value="<?= (isset($_GET['max-price']) && $_GET['max-price'] ? $_GET['max-price'] : null) ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="os" class="mb-2 fw-bold text-capitalize">OS</label>
                                    <select name="os" class="form-control" id="os">
                                        <option value="">All (<?= $totalLaptop ?>)</option>
                                        <?php foreach ($os as $os) : $total = countData($connection, "laptop WHERE os='$os[os]'"); ?>
                                            <option value="<?= $os['os'] ?>" <?= (isset($_GET['os']) && $_GET['os'] == $os['os'] ? 'selected' : null) ?>><?= $os['os'] ?> (<?= $total ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-success">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <?php if (isset($_SESSION['alternatif'])) : ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex">
                                    <div class="h3 mb-3">Alternatif (<?= count($_SESSION['alternatif']) ?>)</div>
                                    <?php if (count($_SESSION['alternatif']) > 1) : ?>
                                        <div class="ms-auto"><a href="penentuan-bobot.php" class="btn btn-success">Next Step &nbsp;<i class="fas fa-arrow-right"></i></a></div>
                                    <?php endif ?>
                                </div>
                            </div>

                            <?php $index = 0;
                            foreach ($laptopNoFilter as $item) : ?>
                                <?php if (in_array($item['id'], $_SESSION['alternatif'])) : ?>
                                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
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
                                <?php endif ?>
                            <?php $index++;
                            endforeach; ?>
                        </div>
                        <hr>
                    <?php endif ?>
                    <?php if ($laptop) : ?>
                        <div class="row">
                            <div class="col-12 h3 mb-3">Laptop (<?= $totalLaptopFiltered ?>)</div>
                            <?php $index = 0;
                            foreach ($laptop as $item) : ?>
                                <?php if (!isset($_SESSION['alternatif']) || isset($_SESSION['alternatif']) && !in_array($item['id'], $_SESSION['alternatif'])) : ?>
                                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                                        <div class="card text-center shadow-sm border-0">
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
                                                    <a href="add-alternatif.php?id=<?= $item['id'] ?>" class="btn btn-primary">Add to Alternatif</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php $index++;
                            endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'includes/footer.php'; ?>