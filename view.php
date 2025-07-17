<?php
require 'ceklogin.php';
require 'fungction.php';  // fungsi prosesPembayaran() sudah ada di sini

if(!isset($_GET['id_pesanan'])){
    header('location:pesanan.php');
    exit;
}

$id_pesanan = mysqli_real_escape_string($conn, $_GET['id_pesanan']);

// Ambil data pembayaran terbaru untuk pesanan ini (buat tampil kembalian)
$pembayaran = null;
$queryBayar = mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_pesanan='$id_pesanan' ORDER BY tanggal DESC LIMIT 1");
if(mysqli_num_rows($queryBayar) > 0){
    $pembayaran = mysqli_fetch_assoc($queryBayar);
}

// Proses pembayaran saat form bayar di-submit
if(isset($_POST['bayar'])){
    $total_bayar = (int)$_POST['total_bayar'];
    $uang_dibayar = (int)$_POST['uang_dibayar'];

    $result = prosesPembayaran($conn, $id_pesanan, $total_bayar, $uang_dibayar);

    if($result['status']) {
        // Redirect ke halaman ini supaya data terbaru tampil
        header("location: invoice.php?id_pesanan=$id_pesanan");
        exit;
    } else {
        echo "<script>alert('".$result['message']."');</script>";
    }
}

require 'include/header.php';
require 'include/side_bar.php';

if(isset($_GET['hapus'])){
    $id_masuk = mysqli_real_escape_string($conn, $_GET['hapus']);

    // Ambil data untuk kembalikan stok
    $get = mysqli_query($conn, "SELECT * FROM masuk WHERE id_masuk = '$id_masuk'");
    $data = mysqli_fetch_assoc($get);
    if($data){
        $id_produk = $data['id_produk'];
        $qty = $data['qty'];

        // Tambah kembali stok sebelum hapus data masuk
        $tambah_stok = mysqli_query($conn, "UPDATE produk SET stok = stok + $qty WHERE id_produk = '$id_produk'");
        $hapus = mysqli_query($conn, "DELETE FROM masuk WHERE id_masuk = '$id_masuk'");

        if($tambah_stok && $hapus){
            header('location:masuk.php');
            exit();
        } else {
            echo "<script>alert('Gagal hapus!');</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan!');</script>";
    }
}


?>

<link rel="stylesheet" href="assets/template/light/css/dataTables.bootstrap4.css">

<div class="wrapper">
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row my-4">
                        <div class="card-body">
                            <a href="invoice.php?id_pesanan=<?= $id_pesanan; ?>" class="btn btn-secondary mb-3" target="_blank">Cetak Invoice</a>
                            <button type="button" class="btn mb-2 btn-primary" data-toggle="modal"
                                data-target="#varyModal" data-whatever="@mdo">Tambah</button>

                            <!-- Modal tambah produk -->
                            <div class="modal fade" id="varyModal" tabindex="-1" role="dialog"
                                aria-labelledby="varyModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="varyModalLabel">Tambah Pesanan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post">
                                                <div class="form-group">
                                                    <label class="col-form-label">Pilih Produk :</label>
                                                    <select name="id_produk" class="form-control" required>
                                                        <?php
                                                        $getproduk = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk NOT IN (SELECT id_produk FROM dt_pesanan WHERE id_pesanan = '$id_pesanan')");
                                                        while($data = mysqli_fetch_array($getproduk)){
                                                            echo "<option value='{$data['id_produk']}'>{$data['nama_produk']} - {$data['deskripsi']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Qty:</label>
                                                    <input type="number" name="qty" class="form-control" min="1" required>
                                                </div>
                                                <input type="hidden" name="id_pesanan" value="<?= $id_pesanan; ?>">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="addproduk" class="btn btn-primary">Tambah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Tabel daftar produk pesanan -->
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <table class="table datatables" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Produk</th>
                                                <th>Harga satuan</th>
                                                <th>Jumlah</th>
                                                <th>Sub Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $get = mysqli_query($conn,"SELECT * FROM dt_pesanan p JOIN produk pr ON p.id_produk=pr.id_produk WHERE id_pesanan='$id_pesanan'");
                                            $i = 1;
                                            $total_pesanan = 0;
                                            while($data = mysqli_fetch_array($get)){
                                                $id_produk = $data['id_produk'];
                                                $nama_produk = $data['nama_produk'];
                                                $qty = $data['qty'];
                                                $harga = $data['harga'];
                                                $sub_total = $qty * $harga;
                                                $total_pesanan += $sub_total;
                                            ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $nama_produk; ?></td>
                                                <td>Rp. <?= number_format($harga); ?></td>
                                                <td><?= $qty; ?></td>
                                                <td>Rp. <?= number_format($sub_total); ?></td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editModal<?= $id_produk; ?>">Edit</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#hapusModal<?= $id_produk; ?>">Remove</a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editModal<?= $id_produk; ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Qty Produk</h5>
                                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_produk" value="<?= $id_produk; ?>">
                                                                <input type="hidden" name="id_pesanan" value="<?= $id_pesanan; ?>">
                                                                <div class="form-group">
                                                                    <label>Jumlah</label>
                                                                    <input type="number" class="form-control" name="qty" value="<?= $qty; ?>" min="1" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="editqty" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="hapusModal<?= $id_produk; ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Hapus Produk</h5>
                                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_produk" value="<?= $id_produk; ?>">
                                                                <input type="hidden" name="id_pesanan" value="<?= $id_pesanan; ?>">
                                                                <p>Yakin ingin menghapus produk <strong><?= $nama_produk; ?></strong> dari pesanan?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="hapusproduk" class="btn btn-danger">Hapus</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <?php } ?>
                                        </tbody>
                                    </table>

                                    <!-- Total bayar dan tombol bayar -->
                                    <div class="mt-4">
                                        <h5>Total Bayar: Rp <?= number_format($total_pesanan); ?></h5>
                                        <?php if(!$pembayaran): ?>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bayarModal">Bayar</button>
                                        <?php endif; ?>

                                    </div>

                                    <?php if($pembayaran): ?>
                                        <div class="alert alert-success mt-3">
                                            <strong>Pembayaran berhasil!</strong><br>
                                            Total: Rp <?= number_format($pembayaran['total_bayar']); ?><br>
                                            Dibayar: Rp <?= number_format($pembayaran['uang_dibayar']); ?><br>
                                            Kembalian: Rp <?= number_format($pembayaran['kembalian']); ?>
                                        </div>
                                    <?php endif; ?>


                                    <!-- Tampilkan kembalian jika ada -->
                                    

                                    <!-- Modal bayar -->
                                    <!-- Modal bayar -->
                                        <div class="modal fade" id="bayarModal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <form method="post" id="formBayar">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Pembayaran</h5>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="total_bayar" id="totalBayar" value="<?= $total_pesanan; ?>">
                                                            <div class="form-group">
                                                                <label>Total Bayar (Rp):</label>
                                                                <input type="text" class="form-control" value="Rp <?= number_format($total_pesanan); ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Uang Dibayar (Rp):</label>
                                                                <input type="number" name="uang_dibayar" id="uangDibayar" class="form-control" min="<?= $total_pesanan; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Kembalian (Rp):</label>
                                                                <input type="text" id="kembalian" class="form-control" readonly value="Rp 0">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="bayar" class="btn btn-primary">Bayar</button>
                                                        </div>
                                                        
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                </div> <!-- card-body -->
                            </div> <!-- card -->
                        </div> <!-- col-md-12 -->
                    </div> <!-- row my-4 -->
                </div> <!-- col-12 -->
            </div> <!-- row justify-content-center -->
        </div> <!-- container-fluid -->
    </main>
</div>

<script>
    const totalBayar = <?= $total_pesanan; ?>;
    const uangDibayarInput = document.getElementById('uangDibayar');
    const kembalianInput = document.getElementById('kembalian');

    uangDibayarInput.addEventListener('input', () => {
        let bayar = parseInt(uangDibayarInput.value) || 0;
        let kembali = bayar - totalBayar;
        kembalianInput.value = 'Rp ' + (kembali >= 0 ? kembali.toLocaleString() : '0');
    });
</script>

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

<?php require 'include/footer.php'; ?>
