<?php
    $values = $conn->query('SELECT products.name as name, products.image as image, IFNULL((sum(history_products.amount)*products.harga),0) as value From products left join history_products on products.id = history_products.id_product group by products.name order by value desc limit 5')->fetch_all(MYSQLI_ASSOC);
    $quantities = $conn->query('SELECT products.name as name, products.image as image, IFNULL(sum(history_products.amount),0) as quantity From products left join history_products on products.id = history_products.id_product group by products.name order by quantity desc limit 5')->fetch_all(MYSQLI_ASSOC);
    $ratings = $conn->query('SELECT products.name as name, products.image as image, AVG(ratings.rate) as rata, count(ratings.rate) as jumlah From products, ratings where products.id = ratings.id_product order by rata desc, jumlah desc limit 1')->fetch_assoc();
    $summary = $conn->query('SELECT FORMAT(t.rata, 1) as rata, count(t.id_product) as jumlah from (select id_product, avg(rate) as rata from ratings group by id_product) as t order by rata desc')->fetch_all(MYSQLI_ASSOC);

    function cutString($string, $jumlah){
        $cutted = $string;
        if (strlen($string) > $jumlah){
            $cutted = explode( "\n", wordwrap($string, $jumlah));
            $cutted = $cutted[0] . "...";
        }
        return $cutted;
    }
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Product</li>
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
                            <h3 class="card-title">Best Seller (By Value)</h3>

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
                            <div class="d-flex flex-column justify-content-center"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
                                <div class="row">
                                    <div class="col-6 d-flex flex-column align-items-center">
                                        <img src="../<?=$values[0]['image']?>" alt="" srcset="" style="height: 250px; ">
                                    </div>
                                    <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                        <h3 class="border-bottom"><?= cutString($values[0]['name'], 30) ?></h3>
                                        <h3>Rp <?= number_format($values[0]['value']) ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- PIE CHART -->
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Best Seller (By Quantity)</h3>

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
                            <div class="d-flex flex-column justify-content-center"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
                                <div class="row">
                                    <div class="col-6 d-flex flex-column align-items-center">
                                        <img src="../<?=$quantities[0]['image']?>" alt="" srcset=""
                                            style="height: 250px; ">
                                    </div>
                                    <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                        <h3 class="border-bottom"><?= cutString($quantities[0]['name'],30) ?></h3>
                                        <h3><?= number_format($quantities[0]['quantity'])?> Units</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- DONUT CHART -->
                    <div class="card card-info mb-5 pb-2">
                        <div class="card-header">
                            <h3 class="card-title">Most Loved</h3>

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
                            <div class="d-flex flex-column justify-content-center"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
                                <div class="row">
                                    <div class="col-6 d-flex flex-column align-items-center">
                                        <img src="../<?=$ratings['image']?>" alt="" srcset="" style="height: 250px; ">
                                    </div>
                                    <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                        <h3 class="border-bottom"><?= cutString($ratings['name'],30) ?></h3>
                                        <h3>Rate : <?= number_format($ratings['rata'], 1, ',')?> <br>
                                            <?= number_format($ratings['jumlah'])?> Ratings
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col (LEFT) -->
                <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Top 5 (By Value)</h3>

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
                                <div class="chart">
                                    <canvas id="byValue"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- BAR CHART -->
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Top 5 (By Quantity)</h3>

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
                                <canvas id="byQuantity"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- STACKED BAR CHART -->
                    <div class="card card-info mb-5">
                        <div class="card-header">
                            <h3 class="card-title">Rating Summary</h3>

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
                                <canvas id="pieChart"
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
    var values = {
        labels: [<?php foreach($values as $value) echo ("'" . cutString($value['name'],30) . "',"); ?>],
        datasets: [{
            label: 'Value',
            backgroundColor: 'green',
            borderColor: 'green',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [<?php foreach($values as $value) echo ($value['value'] . ","); ?>]
        }]
    }

    var byValue = $('#byValue').get(0).getContext('2d')

    var stackedBarChartOptions = {
        responsive: true,
        legend: {
            display: false
        },
        maintainAspectRatio: false,
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
                    callback: function(value) {
                        return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
                    }
                }
            }]
        }
    }

    new Chart(byValue, {
        type: 'bar',
        data: values,
        options: stackedBarChartOptions
    })

    var quantities = {
        labels: [<?php foreach($quantities as $quantity) echo ("'" . cutString($quantity['name'],30) . "',"); ?>],
        datasets: [{
            label: 'Quantity',
            backgroundColor: 'red',
            borderColor: 'red',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [<?php foreach($quantities as $quantity) echo ($quantity['quantity'] . ","); ?>]
        }]
    }

    var byQuantity = $('#byQuantity').get(0).getContext('2d')

    var quantityOption = {
        responsive: true,
        legend: {
            display: false
        },
        maintainAspectRatio: false,
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

    new Chart(byQuantity, {
        type: 'bar',
        data: quantities,
        options: quantityOption
    })

    function getRandomColor(){
       return 'hsla(' + (Math.random() * 360) + ', 100%, 50%, 1)';
    }

    var pieData = {
        labels: [<?php foreach($summary as $sum) echo ("'" . $sum['rata'] . "',"); ?>],
        datasets: [{
            data: [<?php foreach($summary as $sum) echo ("'" . $sum['jumlah'] . "',"); ?>],
            backgroundColor: [<?php foreach($summary as $sum) echo ("getRandomColor(), "); ?>],
        }]
    }

    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            labels: {
                fontColor: 'white'
            }
        },
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    })

})
</script>