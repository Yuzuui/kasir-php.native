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
                        <div class="card-body">
                            <button type="button" class="btn mb-2 btn-primary" data-toggle="modal"
                                data-target="#varyModal" data-whatever="@mdo">Tambah</button>
                            <div class="modal fade" id="varyModal" tabindex="-1" role="dialog"
                                aria-labelledby="varyModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="varyModalLabel">Tambah Pelanggan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post">
                                                <div class="form-group">
                                                    <label class="col-form-label">Pelanggan :</label>
                                                    <select name="idpelanggan" class="form-control" id="">
                                                        <?php
                                                    $getpelanggan = mysqli_query($conn, "select * from pelanggan");

                                                    while($data = mysqli_fetch_array($getpelanggan)){
                                                        $nama_pelanggan=$data['nama'];
                                                        $idpelanggan = $data['id_pelanggan'];
                                                        $alamat = $data['alamat'];
                                                    
                                                    ?>
                                                        <option value="<?=$idpelanggan;?>"><?=$nama_pelanggan;?> -
                                                            <?=$alamat;?></option>

                                                        <?php
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn mb-2 btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" name="tambahpesanan"
                                                class="btn mb-2 btn-primary">Tambah</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Small table -->
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <!-- table -->
                                    <table class="table datatables" id="dataTable-1">
                                        <thead>
                                            <tr>

                                                <th>#</th>
                                                <th>ID Pesanan</th>
                                                <th>Tanggal</th>
                                                <th>Nama Pelanggan</th>
                                                <th>Alamat</th>
                                                <th>Jumlah</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $get = mysqli_query($conn,"select * from pesanan p, pelanggan pl where p.id_pelanggan=pl.id_pelanggan");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($get)){
                                                $id_pesanan = $data['id_pesanan'];
                                                $tanggal = $data['tgl'];
                                                $nama_pelanggan = $data['nama'];
                                                $alamat = $data['alamat'];

                                                //hitung jumlah
                                                $hitung_jumlah = mysqli_query($conn,"select * from dt_pesanan where id_pesanan = '$id_pesanan'");
                                                $jumlah = mysqli_num_rows($hitung_jumlah)
                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$id_pesanan;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$nama_pelanggan;?></td>
                                                <td><?=$alamat;?></td>
                                                <td><?=$jumlah;?></td>
                                                <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                       
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#hapusModal<?=$id_pesanan;?>">Remove</a>
                                                        <a class="dropdown-item"
                                                            href="view.php?id_pesanan=<?=$id_pesanan;?>"
                                                            target="blank">View</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Modal Edit Pesanan -->
                                            <div class="modal fade" id="editModal<?=$id_pesanan;?>" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Pesanan</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_pesanan"
                                                                    value="<?=$id_pesanan;?>">
                                                                <div class="form-group">
                                                                    <label>Pelanggan</label>
                                                                    <select name="id_pelanggan" class="form-control">
                                                                        <?php $plg = mysqli_query($conn, "SELECT * FROM pelanggan");
                                                                        while($pl=mysqli_fetch_array($plg)){
                                                                            $selected = ($pl['id_pelanggan'] == $data['id_pelanggan']) ? "selected" : "";
                                                                            echo "<option value='".$pl['id_pelanggan']."' $selected>".$pl['nama']." - ".$pl['alamat']."</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="editpesanan"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Modal Hapus Pesanan -->
                                            <div class="modal fade" id="hapusModal<?=$id_pesanan;?>" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Hapus Pesanan</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_pesanan"
                                                                    value="<?=$id_pesanan;?>">
                                                                <p>Yakin ingin menghapus pesanan
                                                                    <strong>#<?=$id_pesanan;?></strong>?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="hapuspesanan"
                                                                    class="btn btn-danger">Hapus</button>
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
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>