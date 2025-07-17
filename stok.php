<?php
require 'ceklogin.php';
require 'include/header.php';
require 'include/side_bar.php';
require 'include/footer.php';
?>
<link rel="stylesheet" href="assets/template/light/css/dataTables.bootstrap4.css">


<div class="wrapper">
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row my-4">
                        <!-- Small table -->
                        <div class="col-md-12">
                            <div class="card-body">
                                <button type="button" class="btn mb-2 btn-primary" data-toggle="modal"
                                    data-target="#varyModal" data-whatever="@mdo">Tambah</button>
                                <div class="modal fade" id="varyModal" tabindex="-1" role="dialog"
                                    aria-labelledby="varyModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="varyModalLabel">Tambah Barang</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post">
                                                    <div class="form-group">
                                                        <labelclass="col-form-label">Nama Barang:</labelclass=>
                                                            <input type="text" class="form-control" id="recipient-name"
                                                                name="nama">
                                                    </div>
                                                    <div class="form-group">
                                                        <labelclass="col-form-label">Harga:</labelclass=>
                                                            <input type="text" class="form-control" id="recipient-name"
                                                                name="harga">
                                                    </div>
                                                    <div class="form-group">
                                                        <labelclass="col-form-label">Stok:</labelclass=>
                                                            <input type="number" class="form-control"
                                                                id="recipient-name" name="stok">
                                                    </div>
                                                    <div class="form-group">
                                                        <labelclass="col-form-label">Deskripsi:</labelclass=>
                                                            <input type="text" class="form-control" id="recipient-name"
                                                                name="deskripsi">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn mb-2 btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" name="tambah"
                                                    class="btn mb-2 btn-primary">Tambah</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow">
                                <div class="card-body">
                                    <!-- table -->
                                    <table class="table datatables" id="dataTable-1">
                                        <thead>
                                            <tr>

                                                <th>#</th>
                                                <th>Nama Produk</th>
                                                <th>Deskripsi</th>
                                                <th>stok</th>
                                                <th>harga</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $get = mysqli_query($conn,"select * from produk");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($get)){
                                                $nama_barang = $data['nama_produk'];
                                                $deskripsi = $data['deskripsi'];
                                                $stok = $data['stok'];
                                                $harga = $data['harga'];
                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$nama_barang;?></td>
                                                <td><?=$deskripsi;?></td>
                                                <td><?=$stok;?></td>
                                                <td><?=$harga;?></td>
                                                <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editModal<?=$data['id_produk'];?>">Edit</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#hapusModal<?=$data['id_produk'];?>">Remove</a>

                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editModal<?=$data['id_produk'];?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title">Edit Barang</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <input type="hidden" name="id_produk" value="<?=$data['id_produk'];?>">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" name="nama" class="form-control" value="<?=$nama_barang;?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Deskripsi</label>
                                                        <input type="text" name="deskripsi" class="form-control" value="<?=$deskripsi;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Harga</label>
                                                        <input type="number" name="harga" class="form-control" value="<?=$harga;?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Stok</label>
                                                        <input type="number" name="stok" class="form-control" value="<?=$stok;?>" required>
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="submit" name="editbarang" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                            </div>

                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="hapusModal<?=$data['id_produk'];?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <form method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title">Hapus Barang</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <input type="hidden" name="id_produk" value="<?=$data['id_produk'];?>">
                                                    <p>Yakin ingin menghapus barang <strong><?=$nama_barang;?></strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="submit" name="hapusbarang" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                            </div>

                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- simple table -->
                    </div> <!-- end section -->
                </div> <!-- .col-12 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </main> <!-- main -->
</div> <!-- .wrapper -->
<script src='assets/template/light/js/jquery.dataTables.min.js'></script>
<script src='assets/template/light/js/dataTables.bootstrap4.min.js'></script>
<script>
    $('#dataTable-1').DataTable({
        autoWidth: true,
        "lengthMenu": [
            [16, 32, 64, -1],
            [16, 32, 64, "All"]
        ]
    });
</script>
<script src="js/apps.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->

</body>

</html>