<?php
    $query = "select * from users";
    $users = mysqli_query($conn, $query);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> <i class="nav-icon fas fa-users"></i> Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                                    <h3 class="card-title">User terdaftar : <?php echo mysqli_num_rows($users) ?></h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table myTable table-bordered table-hover" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($user = mysqli_fetch_assoc($users)){ ?>
                                            <tr>
                                                <td><?php echo $user['id'] ?></td>
                                                <td><?php echo $user['name'] ?>
                                                </td>
                                                <td><?php echo $user['username'] ?></td>
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
<!-- /.content-wrapper -->