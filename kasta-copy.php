<?php
include 'includes/header.php';
$sql = 'SELECT * FROM laptop';
$laptop = fetchData($connection, $sql);
$laptopNoFilter = fetchData($connection, 'SELECT * FROM v_laptop');
$brands = fetchData($connection, 'SELECT distinct(brand) FROM laptop');
$os = fetchData($connection, 'SELECT distinct(os) FROM laptop ORDER BY os');
$display = fetchData($connection, 'SELECT distinct(display) FROM laptop ORDER BY display');
$cpu = fetchData($connection, 'SELECT distinct(cpu_model) FROM laptop ORDER BY cpu_model');
$gpu = fetchData($connection, 'SELECT distinct(gpu_model) FROM laptop ORDER BY gpu_model');

$totalLaptop = countData($connection, "laptop");
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION['referer'] = $currentUrl;

$dataLaptopJSON = json_decode(file_get_contents('./data.json'));
// $bobotCPU [
//     '1' => [
//         '',
//     ],
//     '2' => [
//         '',
//     ],
//     '3' => [
//         '',
//     ],
//     '4' => [
//         '',
//     ],
//     '5' => [
//         'M1', 'Xeon', 'Ryzen 9', 'Ryzen 7'
//     ],
// ];

?>

<div class="page-content page-home">
    <section class="py-5 bg-different">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <ol class="row">
                        <?php $index = 0;
                        foreach ($cpu as $item) : ?>
                            <li><?= $item['cpu_model'] ?></li>
                        <?php $index++;
                        endforeach; ?>
                    </ol>
                </div>
                <div class="col-6">
                    <ol class="row">
                        <?php $index = 0;
                        foreach ($gpu as $item) : ?>
                            <li><?= $item['gpu_model'] ?></li>
                        <?php $index++;
                        endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    let result = {};
    for (let [key, name] of Object.entries(data)) {
        let storages = [];
        for (let [keyStorage, nameStorage] of Object.entries(data[key].primary_storage)) {
            if (keyStorage != "selected" && data[key].primary_storage[keyStorage].cap <= 1048) {
                storages.push(keyStorage);
            }
        }
        if (storages.length > 0) {
            storageCap = data[key].primary_storage[storages[Math.floor(Math.random() * storages.length)]].cap;
            storageType = data[key].primary_storage[storages[Math.floor(Math.random() * storages.length)]].model;
        } else {
            storageCap = data[key].primary_storage[data[key].primary_storage.selected].cap;
            storageType = data[key].primary_storage[data[key].primary_storage.selected].model;
        }
        result[key] = {
            name: data[key].model_info[0].noteb_name.replace(" (US)", ""),
            brand: data[key].model_info[0].noteb_name.replace(" (US)", "").split(" ")[0],
            image: data[key].model_resources.thumbnail,
            price: 14225.55 * data[key].config_price,
            os: data[key].operating_system[data[key].operating_system.selected].name.replace(".00", ""),
            weight: data[key].chassis[data[key].chassis.selected].weight_kg,
            display: data[key].display[data[key].display.selected].size,
            battery: data[key].battery_life_raw,
            cpu_prod: data[key].cpu[data[key].cpu.selected].prod,
            cpu_model: data[key].cpu[data[key].cpu.selected].model,
            gpu_prod: data[key].gpu[data[key].gpu.selected].prod,
            gpu_model: data[key].gpu[data[key].gpu.selected].model,
            ram_size: data[key].memory[data[key].memory.selected].size,
            ram_type: data[key].memory[data[key].memory.selected].type,
            storage_size: storageCap,
            storage_type: storageType,
        };
        // console.log(key);
        // console.log(data[key].model_info[0].noteb_name.replace(" (US)", ""));
        // console.log(data[key].display[data[key].display.selected]);
    }

    let query = "";
    for (let [key, name] of Object.entries(result)) {
        let sql = "INSERT INTO laptop SET ";
        for (let [itemKey, itemValue] of Object.entries(result[key])) {
            sql += `${itemKey} = '${itemValue}', `;
        }
        // console.log(sql.slice(0, -2));
        query += sql.slice(0, -2) + ";";
    }

    // document.querySelector("div").innerHTML = JSON.stringify(result);
    // document.querySelector("div").innerHTML = query;
    // console.log(query);
    // console.log(result);
</script>
<?php include 'includes/footer.php'; ?>