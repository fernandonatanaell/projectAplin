<?php
    $histories = $conn->query('SELECT count(id) as jumlah, sum(total) as total From history')->fetch_assoc();
    $itemsold = $conn->query("SELECT sum(amount) as jumlah, count(distinct id_product) as productsold from history_products")->fetch_assoc();

    $todays = $conn->query('SELECT count(id) as jumlah, sum(total) as total From history where created_at >= CURDATE()')->fetch_assoc();
    $todaysOrder = $conn->query('SELECT * From history_products where id_history in (select id from history where created_at >= CURDATE())')->fetch_all(MYSQLI_ASSOC);

    $counting = $conn->query('SELECT * From history where created_at >= DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE())-1 DAY)')->fetch_all(MYSQLI_ASSOC);

    $count1 = 0;
    $count2 = 0;
    $count3 = 0;
    $count4 = 0;
    $lastday = date('t');

    foreach ($counting as $count){
        $date = date('Y-m-d', strtotime($count['created_at']));

        if ($date <= date('Y-m-07'))$count1++;
        if ($date > date('Y-m-07') && $date <= date('Y-m-15')) $count2++;
        if ($date > date('Y-m-15') && $date <= date('Y-m-23')) $count3++;
        if ($date > date('Y-m-23')) $count4++;
    }

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Overview</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Overview</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- AREA CHART -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Total Sales</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column justify-content-center align-items-center"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
                                <h1 class="display-1 text-success"><i class="nav-icon fas fa-cash-register"></i>
                                    <?= intval(($histories['total']/1000000) * 10) / 10?> jt
                                </h1><br>
                                <h3>Rp <?= number_format($histories['total']) ?></h3>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- PIE CHART -->
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Total Today's Orders</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column justify-content-center align-items-center"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
                                <h1 class="display-1 text-danger"><i class="nav-icon fas fa-receipt"></i>
                                    <?= number_format($todays['jumlah'])?></h1>
                                <br>
                                <h3>Rp <?= number_format($todays['total'])?></h3>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- DONUT CHART -->
                    <div class="card card-danger mb-5 pb-2">
                        <div class="card-header">
                            <h3 class="card-title">Today's Orders</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if(count($todaysOrder) == 0){
                                    ?>
                            <div class="d-flex flex-column justify-content-center align-items-center"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">

                                <h4> Tidak ada order hari ini
                                </h4> <br>
                                <h1><i class="nav-icon fas fa-tired"></i></h1>
                                <?php

                                } else {?>
                                <div class="card-body p-0" style="min-height: 250px; height: 250px; max-width: 100%;">
                                    <ul class="products-list product-list-in-card pl-2 pr-2">
                                        <?php 
                                        foreach ($todaysOrder as $orderan){
                                            $product = $conn->query("SELECT name, image From products where id = '$orderan[id_history]'")->fetch_assoc();
                                            $user = $conn->query("SELECT name From users, history where users.id = history.id_user and history.id = '$orderan[id_history]'")->fetch_assoc();
                                            
                                    ?>

                                        <li class="item">
                                            <div class="product-img">
                                                <img src="../<?= $product['image'] ?>" alt="Product Image"
                                                    class="img-size-50">
                                            </div>
                                            <div class="product-info">
                                                <span class="products-title"> <?= $user['name'] ?></span>
                                                <span class="badge badge-success float-right"><?= $orderan['amount'] ?>
                                                    item(s)</span>
                                                <span class="product-description">
                                                    <?= $product['name'] ?>
                                                </span>
                                            </div>
                                        </li>

                                        <?php
                                        }
                                    }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="index.php" class="uppercase">View All Orders</a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col (LEFT) -->
                    <div class="col-md-6">
                        <!-- LINE CHART -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Total Orders</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column justify-content-center align-items-center"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
                                    <h1 class="display-1 text-primary"><i class="nav-icon fas fa-shopping-bag"></i>
                                        <?= number_format($histories['jumlah']) ?></h1>
                                    <br>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- BAR CHART -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Total Items Sold</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column justify-content-center align-items-center"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
                                    <h1 class="display-1 text-primary"><i class="nav-icon fas fa-mobile-alt"></i>
                                        <?= number_format($itemsold['jumlah']) ?></h1>
                                    <br>
                                    <h3>From <?= number_format($itemsold['productsold']) ?> Products</h3>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- STACKED BAR CHART -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Sales Graph in This Month</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="areaChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col (RIGHT) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
$(function() {
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
        labels: ['1 - 7', '8 - 15', '16 - 23', '24 - <?= $lastday ?>'],
        datasets: [{
            label: 'Sales Graph',
            backgroundColor: 'rgba(243,156,18,0.9)',
            borderColor: 'rgba(255,193,7,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [<?= $count1 ?>, <?= $count2 ?>, <?= $count3 ?>, <?= $count4 ?>]
        }, ]
    }

    var areaChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                },
                ticks: {
                    fontColor: "white",
                }
            }],
            yAxes: [{
                gridLines: {
                    display: false,
                },
                ticks: {
                    fontColor: "white",
                }
            }]
        }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
        type: 'line',
        data: areaChartData,
        options: areaChartOptions
    })

})
</script>