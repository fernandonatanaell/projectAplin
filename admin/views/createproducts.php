<?php
    $brands = $conn->query('SELECT * From brands')->fetch_all(MYSQLI_ASSOC);
    $colors = $conn->query('SELECT * From colors')->fetch_all(MYSQLI_ASSOC);
    $categories = $conn->query('SELECT * From categories')->fetch_all(MYSQLI_ASSOC);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Products</h1>
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
                                <form action="./controllers/addProduct.php" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="image">Tambah Foto*</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control-file" onchange="document.getElementById('preview-img').src = window.URL.createObjectURL(this.files[0])" name="image" id="image" accept=".jpg, .jpeg, .png" required>
                                                    <img id="preview-img" src="./image.png" alt="" width="100" height="100">
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="form-group">
                                            <label for="name">Nama Produk*</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Masukkan Nama Produk" name="name" required>
                                        </div>

                                        <br>

                                        <div class="form-group">
                                            <label for="description">Deskripsi Produk*</label>
                                            <textarea class="form-control" id="description"
                                                placeholder="Masukkan Deskripsi Produk" rows="8" name="description" required></textarea>
                                        </div>

                                        <br>

                                        <div class="form-group">
                                            <label for="color" style="margin-right:10px;">Warna: </label>
                                            <select class="selectpicker" data-actions-box="true" data-size="5" data-live-search="true" data-selected-text-format="count" title="Pilih warna produk" data-style="btn-secondary" multiple name="color[]" id="color">
                                            <?php foreach($colors as $color) {?>
                                                    <option value=<?php echo $color['id']?>><?php echo $color['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="newColor">Atau tambah warna baru (Pisahkan dengan koma)</label>
                                            <input type="text" class="form-control"
                                                placeholder="Contoh : Red, Green, Blue" name="newColor">
                                        </div>

                                        <br>

                                        <div class="form-group">
                                            <label for="category" style="margin-right: 10px;">Kategori: </label>
                                            <select multiple class="selectpicker" data-actions-box="true" data-size="5" data-live-search="true" data-selected-text-format="count" title="Pilih kategori produk" data-style="btn-secondary" name="category[]" id="category">
                                                <?php foreach($categories as $category) {?>
                                                    <option value=<?php echo $category['id']?>><?php echo $category['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="newCategory">Atau tambah kategori baru (Pisahkan dengan koma)</label>
                                            <input type="text" class="form-control"
                                                placeholder="Contoh : Polaroid, Digital, 5G" name="newCategory">
                                        </div>

                                        <br>

                                        <div class="form-group">
                                            <label for="id_brands" style="margin-right: 10px;">Brand* : </label>
                                            <select class="selectpicker" data-size="5" data-live-search="true" title="Pilih brand produk" data-style="btn-secondary" id="id_brands" name="id_brands" required>
                                                <option value="new">Add New Brand</option>
                                                <?php foreach($brands as $brand) {?>
                                                    <option value=<?php echo $brand['id']?>><?php echo $brand['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group" id="namaBrand" hidden>
                                            <label for="nama_brand">Nama Brand*</label>
                                            <input type="text" class="form-control" name="nama_brand" id="nama_brand"
                                                placeholder="Masukkan Nama brand">
                                        </div>

                                        <br>

                                        <div class="form-group">
                                            <label for="berat">Berat (Gram)*</label>
                                            <input type="number" class="form-control" id="berat"
                                                placeholder="Masukkan Berat Produk" min="1" name="berat" required>
                                        </div>

                                        <br>

                                        <div class="form-group">
                                            <label for="stock">Stock*</label>
                                            <input type="number" class="form-control" id="stock"
                                                placeholder="Masukkan Jumlah Stock Yang Tersedia" name="stock" min="1" required>
                                        </div>

                                        <br>

                                        <div class="form-group">
                                            <label for="harga">Harga*</label>
                                            <input type="number" class="form-control" id="harga"
                                                placeholder="Masukkan Harga" min="1" name="harga" required>
                                        </div>

                                        <br>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="setuju" required>
                                            <label class="form-check-label" for="setuju">Saya setuju dengan Syarat dan Ketentuan yang belum saya baca</label>
                                        </div>

                                        <br>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
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
        $('#id_brands').change(function(){
        if($('#id_brands').val() == "new"){
            $('#namaBrand').removeAttr('hidden');
            $('#namaBrand').find(".form-control").attr('required', true);
        } else {
            $('#namaBrand').attr('hidden', true);
            $('#namaBrand').find(".form-control").removeAttr('required');
        }
        })
    })

</script>