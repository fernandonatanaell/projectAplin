<?php
    $sel = mysqli_query($conn,"select count(*) as allcount from products");
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
                    <h1 class="m-0"> <i class="nav-icon fas fa-mobile-alt"></i> Products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
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
                                    <h3 class="card-title mt-2">Jumlah product : <?php echo $totalRecords ?></h3>

                                    <div class="card-tools">
                                        <a class="btn btn-success" href="index.php?content=Products&create=True" role="button">Create New Product</a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <table class="table product table-bordered table-hover" style="width: 100%" >
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Brand</th>
                                                <th>Berat (gram)</th>
                                                <th>Stock (units)</th>
                                                <th>Harga (Rp)</th>
                                                <th data-orderable="false">Tambah</th>
                                                <th data-orderable="false">Edit</th>
                                                <th data-orderable="false">View</th>
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
$(document).ready(function(){
let tabel =  $('.product').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "scrollX": true,
        'ajax': {
            'url' : './controllers/loadProduct.php'
        },
        'columns': [
            {data: 'id'},
            {data: 'name'},
            {data: 'brand'},
            {data: 'berat'},
            {data: 'stock'},
            {data: 'harga'},
            {data: 'id', render: function (data, type, row, meta) {
                return type === 'display' ?
                `<button type="button" class="btn btn-success tambah" value="` + data + `">Stock</button>` : data;
            }},
            {data: 'id', render: function (data, type, row, meta) {
                return type === 'display' ?
                `<button type="button" class="btn btn-warning" onclick=" window.location = './index.php?content=Products&edit=True&id_product=` + data + `'">Edit</button>`: data;
            }},
            {data: 'id', render: function (data, type, row, meta) {
                return type === 'display' ?
                `<button type="button" class="btn btn-primary" onclick=" window.open('../views/product/product.php?id_product=` + data + `','_blank')">View</button>` : data;
            }}
        ]
    })

    $('.product').on("click", ".tambah", async function() {
    let button = $(this);

    const {
        value: stock
    } = await Swal.fire({
        title: 'Masukkan jumlah stock',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Tambah Stock',
        inputValidator: (value) => {
            if (!value) {
                return 'Masukkan jumlah terlebih dahulu!'
            }
            if (isNaN(value)) {
                return 'Value harus number'
            }
            if (value < 1) {
                return 'Value minimal 1'
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    })

    if (stock) {
        let id_product = $(this).val();

        $.ajax({
            type: "post",
            url: "./controllers/ctrlProduct.php",
            data: {
                'action': 'tambah',
                'id_product': id_product,
                'stock': stock
            },
            success: function() {
                tabel.ajax.reload(null, false);

                Swal.fire(
                    'Yeay!!',
                    'Berhasil menambah stock',
                    'success'
                )
            }
        })
    }
})
})    

</script>