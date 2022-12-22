<?php
    $values = $conn->query('select users.name as name, IFNULL(sum(history.total),0) as value from users left join history on history.id_user = users.id group by users.name order by value desc limit 5')->fetch_all(MYSQLI_ASSOC);
    $quantities = $conn->query('select users.name as name, IFNULL(count(history.id),0) as quantity from users left join history on history.id_user = users.id group by users.name order by quantity desc limit 5')->fetch_all(MYSQLI_ASSOC);
    $ratings = $conn->query('SELECT users.name AS name, (SELECT count(ratings.id) FROM ratings WHERE ratings.id_user = users.id) AS "rating", (SELECT count(ratings.id) FROM ratings WHERE ratings.id_user = users.id AND ratings.review IS Not NULL) AS "review" FROM users LEFT JOIN ratings on ratings.id_user = users.id GROUP BY users.name ORDER BY rating DESC, review desc LIMIT 5')->fetch_all(MYSQLI_ASSOC);

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
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
                            <h3 class="card-title">Top Purchase (By Value)</h3>

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
                                <h1 class="display-4 text-success"><i class="nav-icon fas fa-trophy"></i>
                                    <?= $values[0]['name'] ?></h1>
                                <br>
                                <h3>Rp <?= number_format($values[0]['value']) ?></h3>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- PIE CHART -->
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Top Purchase (By Quantity)</h3>

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
                                <h1 class="display-4 text-danger"><i class="nav-icon fas fa-trophy"></i>
                                    <?= $quantities[0]['name'] ?></h1>
                                <br>
                                <h3><?= number_format($quantities[0]['quantity']) ?> Orders</h3>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- DONUT CHART -->
                    <div class="card card-info mb-5 pb-2">
                        <div class="card-header">
                            <h3 class="card-title">Most Active (By Rating)</h3>

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
                                <h1 class="display-4 text-primary"><i class="nav-icon fas fa-trophy"></i>
                                    <?= $ratings[0]['name'] ?></h1>
                                <br>
                                <h3><?= number_format($ratings[0]['rating']) ?> Ratings <br>
                                    <?= number_format($ratings[0]['review']) ?> Reviews
                                </h3>
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
                            <h3 class="card-title">Top 5 (By Rating)</h3>

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
                                <canvas id="byRating"
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
        labels: [<?php foreach($values as $value) echo ("'" . $value['name'] . "',"); ?>],
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
        labels: [<?php foreach($quantities as $quantity) echo ("'" . $quantity['name'] . "',"); ?>],
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

    var ratings = {
        labels: [<?php foreach($ratings as $rating) echo ("'" . $rating['name'] . "',"); ?>],
        datasets: [{
            label: 'Ratings',
            backgroundColor: 'blue',
            borderColor: 'blue',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [<?php foreach($ratings as $rating) echo ($rating['rating'] . ","); ?>]
        }]
    }

    var byRating = $('#byRating').get(0).getContext('2d')

    var ratingOption = {
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

    new Chart(byRating, {
        type: 'bar',
        data: ratings,
        options: ratingOption
    })


})
</script>