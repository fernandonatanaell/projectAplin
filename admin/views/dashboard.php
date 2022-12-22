<?php
    $sel = mysqli_query($conn,"select count(*) as allcount from history");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> <i class="nav-icon fas fa-home"></i> Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->



            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Jumlah transaksi : <?php echo $totalRecords ?>
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table dashboard table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User</th>
                                                <th>Total (Rp)</th>
                                                <th>Discount</th>
                                                <th>Tanggal Beli</th>
                                                <th>Tanggal Diterima</th>
                                                <th>Status</th>
                                                <th data-orderable="false">Detail</th>
                                                <th data-orderable="false">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
            </section>
            <!-- /.content-header -->
        </div>
    </div>
</div>
<!-- /.content-wrapper -->

<script>
$(document).ready(function() {
    let tabel = $('.dashboard').DataTable({
        'order' : [[0, 'desc']],
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "scrollX": true,
        'ajax': {
            'url': './controllers/loadDashboard.php'
        },
        'columns': [{
                data: 'id'
            },
            {
                data: 'user'
            },
            {
                data: 'total'
            },
            {
                data: 'discount'
            },
            {
                data: 'beli'
            },
            {
                data: 'diterima'
            },
            {
                data: 'status',
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        if (data == 0) {
                            return `<button type="button" class="btn btn-warning  btn-sm">Menunggu Konfirmasi</button>`;
                        } else {
                            return ` <button type="button" class="btn btn-success btn-sm">Pesanan Selesai</button>`;
                        }
                    } else {
                        return data;
                    }
                }
            },
            {
                data: 'id',
                render: function(data, type, row, meta) {
                    return type === 'display' ?
                        `<button type="button" class="btn btn-primary btn-sm detail" value=` +
                        data + `>Lihat Detail</button>` : data;
                }
            },
            {
                data: 'status',
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        if (data == 0) {
                            return `<button type="button" class="btn btn-success btn-sm konfirm" value="` +
                                row.id + `">Kirim Pesanan</button>`;
                        } else {
                            return `<button type="button" class="btn btn-success btn-sm konfirm disabled">Kirim Pesanan</button>`
                        }
                    } else return data;
                }
            }
        ]
    })

    $(".dashboard").on("click", ".konfirm", function() {

        if (!$(this).hasClass("disabled")) {

            let id = $(this).val();

            Swal.fire({
                title: 'Proses pesanan?',
                text: 'Apakah anda ingin memproses pesanan ini?',
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Proses sekarang!",
            }).then((result) => {
                if (result['value'] == true) {
                    $.ajax({
                        type: "get",
                        url: "./controllers/ctrlPesanan.php",
                        data: {
                            'id': id,
                        },
                        success: function(response) {
                            tabel.ajax.reload(null, false);

                            Swal.fire(
                                'Yeay!!',
                                'Pesanan berhasil diproses!',
                                'success'
                            )
                        }
                    })
                }
            })
        }
    })
})

$(".dashboard").on("click", ".detail", function() {
    let id = $(this).val();

    $.ajax({
        type: "get",
        url: "./controllers/detailHistory.php",
        beforeSend: function() {
            Swal.showLoading();
        },
        data: {
            'id': id,
        },
        success: function(response) {
            Swal.fire({
                title: 'Detail ID : ' + id,
                html: response
            })
        }
    })
})
</script>