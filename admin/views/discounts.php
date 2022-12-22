<?php
    $query = "select * from discounts";
    $discounts = mysqli_query($conn, $query);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> <i class="nav-icon fas fa-percent"></i> Discounts</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Discount</li>
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
                                    <h3 class="card-title mt-2 jumlah">Jumlah discount :
                                        <?php echo mysqli_num_rows($discounts) ?></h3>

                                    <div class="card-tools">
                                        <a class="btn btn-success" id="create" role="button">Create New Discount</a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <table class="table myTable table-bordered table-hover" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Kode</th>
                                                <th>Potongan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="theTable">
                                            <?php while($discount = mysqli_fetch_assoc($discounts)){ ?>
                                            <tr>
                                                <td><?php echo $discount['id'] ?></td>
                                                <td><?php echo $discount['name'] ?></td>
                                                <td><?php echo $discount['kode'] ?></td>
                                                <td><?php echo $discount['potongan'] ?> %</td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
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

<script>
$(document).ready(function() {
    $('#create').click(async function() {
        const {
            value: formValues
        } = await Swal.fire({
            title: 'Buat diskon baru',
            html: '<input id="swal-input1" placeholder="Masukkan nama diskon" class="swal2-input">' +
                '<input id="swal-input2" placeholder="Masukkan kode diskon" class="swal2-input">' +
                '<input id="swal-input3" placeholder="Masukkan besar potongan" class="swal2-input">',
            showCancelButton: true,
            confirmButtonText: 'Tambah Diskon',
            focusConfirm: false,
            preConfirm: () => {
                return new Promise(function(resolve) {
                    // Validate input
                    if ($("swal-input1").val() == '' || $("#swal-input2")
                    .val() == '' || $("#swal-input3").val() == '') {
                        Swal.showValidationMessage("Input tidak boleh kosong!");
                        Swal.enableConfirmButton();
                    } else if ($("#swal-input3").val() < 0 || $("#swal-input3")
                        .val() > 100) {
                        Swal.showValidationMessage(
                            "Besar potongan antara 0 - 100%");
                        Swal.enableButtons()
                    } else {
                        Swal.resetValidationMessage();
                        resolve([
                            $("#swal-input1").val(),
                            $("#swal-input2").val(),
                            $("#swal-input3").val(),
                        ])
                    }
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        })

        if (formValues) {
            $.ajax({
                type: "post",
                url: "./controllers/ctrlDiscount.php",
                beforeSend: function() {
                    Swal.showLoading();
                },
                data: {
                    'nama': formValues[0],
                    'kode': formValues[1],
                    'potongan': formValues[2]
                },
                success: function(response) {
                    $('.table').DataTable().destroy();
                    $("#theTable").append(response);
                    $('.table').DataTable({
                        "scrollX": true
                    }).draw();

                    $(".jumlah").load("./controllers/getJumlah.php");

                    Swal.fire(
                        'Yeay!!',
                        'Berhasil menambah discount!',
                        'success'
                    )
                }
            })
        }

    })
})
</script>
<!-- /.content-wrapper -->