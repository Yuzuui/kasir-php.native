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
                                                <h5 class="modal-title" id="varyModalLabel">Tambah Pesanan</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Pilih Produk :</label>
                                                        <select name="id_produk" class="form-control">
                                                            <?php
                                                    $getproduk  = mysqli_query($conn, "select * from produk ");

                                                    while($data = mysqli_fetch_array($getproduk )){
                                                        $nama_produk=$data['nama_produk'];
                                                        $deskripsi = $data['deskripsi'];
                                                        $stok = $data['stok'];
                                                        $id_produk = $data['id_produk'];
                                                    
                                                    ?>
                                                            <option value="<?=$id_produk;?>"><?=$nama_produk;?> -
                                                                <?=$deskripsi;?></option>

                                                            <?php
                                                    }
                                                    ?>
                                                        </select>
                                                        <div class="form-group">
                                                            <label class="col-form-label">qty:</label>
                                                            <input type="number" class="form-control"
                                                                id="recipient-name" name="qty" min="1" required>
                                                        </div>
                                                        
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn mb-2 btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" name="barangmasuk"
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
                                                <th>jumlah</th>
                                                <th>tanggal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $get = mysqli_query($conn,"select * from masuk m, produk p where m.id_produk=p.id_produk");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($get)){
                                                $nama_barang = $data['nama_produk'];
                                                $deskripsi = $data['deskripsi'];
                                                $jumlah = $data['qty'];
                                                $tanggal = $data['tanggal'];
                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$nama_barang;?></td>
                                                <td><?=$deskripsi;?></td>
                                                <td><?=$jumlah;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <!-- Edit trigger -->
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#edit<?=$data['id_masuk'];?>">Edit</a>
                                                        <!-- Delete trigger -->
                                                        <a class="dropdown-item" href="masuk.php?hapus=<?=$data['id_masuk'];?>" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="edit<?=$data['id_masuk'];?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <form method="post">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title">Edit Barang Masuk</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>×</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <input type="hidden" name="id_masuk" value="<?=$data['id_masuk'];?>">
                                                    <input type="hidden" name="id_produk" value="<?=$data['id_produk'];?>">
                                                    <div class="form-group">
                                                        <label>Jumlah (qty):</label>
                                                        <input type="number" name="qty" class="form-control" value="<?=$jumlah;?>" required>
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="submit" name="editmasuk" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                                </div>
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