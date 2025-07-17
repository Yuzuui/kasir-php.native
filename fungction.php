<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$conn = mysqli_connect("localhost","root","","kasir_tcoffe");

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $chek = mysqli_query($conn,"SELECT * FROM user WHERE username='$username' and password='$password'");
        $hitung = mysqli_num_rows($chek);
        
        if($hitung>0){
            $_SESSION['login']= 'True';
            header('location:index.php');
        }else{
            echo "<script>
        alert('Username atau password salah!');
        window.location.href = 'login.php';
    </script>";

            
        }
    }

    if(isset($_POST['tambah'])){
        $nama_barang = $_POST['nama'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $deskripsi = $_POST['deskripsi'];

        $tambah = mysqli_query($conn, "insert into produk(nama_produk, deskripsi, harga, stok) values ('$nama_barang','$deskripsi','$harga','$stok')");

        if($tambah){
            header('location:stok.php');
        }else{
            echo "<script>
            alert('Tidak berhasil menambahkan!');
            window.location.href = 'stok.php';
        </script>";
        }
    }

    if(isset($_POST['tambahp'])){
        $nama_pelanggan = $_POST['nama'];
        $no_telp = $_POST['no'];
        $alamat = $_POST['alamat'];

        $tambah = mysqli_query($conn, "insert into pelanggan(nama, no_telp, alamat) values ('$nama_pelanggan','$no_telp','$alamat')");

        if($tambah){
            header('location:pelanggan.php');
        }else{
            echo "<script>
            alert('Tidak berhasil menambahkan!');
            window.location.href = 'pelanggan.php';
        </script>";
        }
    }

    if(isset($_POST['tambahpesanan'])){
        $id_pelanggan = $_POST['idpelanggan'];
        $tambah = mysqli_query($conn, "insert into pesanan(id_pelanggan) values ('$id_pelanggan')");
        
        
        if($tambah){
            $id_pesanan = mysqli_insert_id($conn); // ambil ID terakhir yang diinsert
            header("Location: view.php?id_pesanan=$id_pesanan");
        }else{
            echo "<script>
            alert('Tidak berhasil menambahkan!');
            window.location.href = 'pesanan.php';
        </script>";
        }
    }

    //produk di pilih di pesanan
    if(isset($_POST['addproduk'])){
        $id_produk = $_POST['id_produk'];
        $id_pesanan = $_POST['id_pesanan'];
        $qty = intval($_POST['qty']);
    
        // Cek apakah produk sudah ada di dt_pesanan
        $cek = mysqli_query($conn, "SELECT * FROM dt_pesanan WHERE id_pesanan='$id_pesanan' AND id_produk='$id_produk'");
        if(mysqli_num_rows($cek) > 0){
            echo "<script>
                    alert('Produk sudah ditambahkan sebelumnya!');
                    window.location.href = 'view.php?id_pesanan=$id_pesanan';
                  </script>";
            exit();
        }
    
        // hitung stok sekarang
        $hitung1 = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_produk'");
        $hitung2 = mysqli_fetch_array($hitung1);
        $stoksekarang = intval($hitung2['stok']);
    
        if($stoksekarang >= $qty){
            $selisih = $stoksekarang - $qty;
    
            $tambah = mysqli_query($conn, "INSERT INTO dt_pesanan(id_pesanan,id_produk,qty) VALUES ('$id_pesanan', '$id_produk','$qty')");
            $update = mysqli_query($conn, "UPDATE produk SET stok='$selisih' WHERE id_produk='$id_produk'");
    
            if($tambah){
                header('location:view.php?id_pesanan='.$id_pesanan);
            }else{
                echo "<script>
                        alert('Tidak berhasil menambahkan!');
                        window.location.href = 'view.php?id_pesanan=$id_pesanan';
                      </script>";
            }
        }else{
            echo "<script>
                    alert('Barang Tidak Cukup!');
                    window.location.href = 'view.php?id_pesanan=$id_pesanan';
                  </script>";
        }
    }
    

    if(isset($_POST['barangmasuk'])){
        $id_produk = $_POST['id_produk'];
        $qty = $_POST['qty'];

        $insert = mysqli_query($conn, "insert into masuk (id_produk,qty) values ('$id_produk','$qty')");

        if($insert){
            header('location:masuk.php');
        }else{
            echo "<script>
            alert('Tidak berhasil menambahkan!');
            window.location.href = 'masuk.php';
        </script>";
        }
    }

    if(isset($_POST['editpesanan'])){
        $id_pesanan = $_POST['id_pesanan'];
        $id_pelanggan = $_POST['id_pelanggan'];
        mysqli_query($conn, "UPDATE pesanan SET id_pelanggan='$id_pelanggan' WHERE id_pesanan='$id_pesanan'");
        echo "<script>window.location.href='pesanan.php';</script>";
    }
    
    if(isset($_POST['hapuspesanan'])){
        $id_pesanan = $_POST['id_pesanan'];
    
        // Hapus data di tabel yang memiliki foreign key lebih dulu
        mysqli_query($conn, "DELETE FROM dt_pesanan WHERE id_pesanan='$id_pesanan'");
        mysqli_query($conn, "DELETE FROM pembayaran WHERE id_pesanan='$id_pesanan'");
        mysqli_query($conn, "DELETE FROM pesanan WHERE id_pesanan='$id_pesanan'");
    
        echo "<script>window.location.href='pesanan.php';</script>";
    }
    

    if(isset($_POST['editqty'])){
        $id_produk = $_POST['id_produk'];
        $id_pesanan = $_POST['id_pesanan'];
        $qty_baru = intval($_POST['qty']);
    
        // Ambil qty lama
        $cek = mysqli_query($conn, "SELECT qty FROM dt_pesanan WHERE id_pesanan='$id_pesanan' AND id_produk='$id_produk'");
        $data = mysqli_fetch_array($cek);
        $qty_lama = intval($data['qty']);
    
        // Hitung selisih untuk update stok
        $selisih = $qty_baru - $qty_lama;
    
        // Ambil stok sekarang
        $getstok = mysqli_query($conn, "SELECT stok FROM produk WHERE id_produk='$id_produk'");
        $datastok = mysqli_fetch_array($getstok);
        $stok = intval($datastok['stok']);
    
        if($stok - $selisih >= 0){
            // Update qty dan stok
            mysqli_query($conn, "UPDATE dt_pesanan SET qty='$qty_baru' WHERE id_pesanan='$id_pesanan' AND id_produk='$id_produk'");
            mysqli_query($conn, "UPDATE produk SET stok=stok - $selisih WHERE id_produk='$id_produk'");
            header("Location: view.php?id_pesanan=$id_pesanan");
        } else {
            echo "<script>alert('Stok tidak cukup!'); window.location.href='view.php?id_pesanan=$id_pesanan';</script>";
        }
    }
    
    if(isset($_POST['hapusproduk'])){
        $id_produk = $_POST['id_produk'];
        $id_pesanan = $_POST['id_pesanan'];
    
        // Ambil qty
        $cek = mysqli_query($conn, "SELECT qty FROM dt_pesanan WHERE id_pesanan='$id_pesanan' AND id_produk='$id_produk'");
        $data = mysqli_fetch_array($cek);
        $qty = intval($data['qty']);
    
        // Kembalikan stok
        mysqli_query($conn, "UPDATE produk SET stok=stok+$qty WHERE id_produk='$id_produk'");
        mysqli_query($conn, "DELETE FROM dt_pesanan WHERE id_pesanan='$id_pesanan' AND id_produk='$id_produk'");
    
        header("Location: view.php?id_pesanan=$id_pesanan");
    }
    
    if(isset($_POST['editbarang'])){
        $id = $_POST['id_produk'];
        $nama = $_POST['nama'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
    
        mysqli_query($conn, "UPDATE produk SET nama_produk='$nama', deskripsi='$deskripsi', harga='$harga', stok='$stok' WHERE id_produk='$id'");
        header('location:stok.php');
    }
    
    if(isset($_POST['hapusbarang'])){
        $id = $_POST['id_produk'];
        mysqli_query($conn, "DELETE FROM produk WHERE id_produk='$id'");
        header('location:stok.php');
    }
    
    if(isset($_POST['editmasuk'])){
        $id_masuk = $_POST['id_masuk'];
        $id_produk = $_POST['id_produk'];
        $qty_baru = $_POST['qty'];
    
        // Ambil qty lama
        $get_old = mysqli_query($conn, "SELECT qty FROM masuk WHERE id_masuk = '$id_masuk'");
        $d = mysqli_fetch_assoc($get_old);
        $qty_lama = $d['qty'];
    
        // Hitung selisih
        $selisih = $qty_baru - $qty_lama;
    
        // Update stok & data masuk
        $update_produk = mysqli_query($conn, "UPDATE produk SET stok = stok + $selisih WHERE id_produk = '$id_produk'");
        $update_masuk = mysqli_query($conn, "UPDATE masuk SET qty = '$qty_baru' WHERE id_masuk = '$id_masuk'");
    
        if($update_produk && $update_masuk){
            header('location:masuk.php');
            exit();
        } else {
            echo "<script>alert('Gagal update!');</script>";
        }
    }
    
    if(isset($_GET['hapus'])){
        $id_masuk = $_GET['hapus'];
    
        // Ambil data untuk kembalikan stok
        $get = mysqli_query($conn, "SELECT * FROM masuk WHERE id_masuk = '$id_masuk'");
        $data = mysqli_fetch_assoc($get);
        $id_produk = $data['id_produk'];
        $qty = $data['qty'];
    
        // Kurangi stok, hapus data masuk
        $kurangi = mysqli_query($conn, "UPDATE produk SET stok = stok - $qty WHERE id_produk = '$id_produk'");
        $hapus = mysqli_query($conn, "DELETE FROM masuk WHERE id_masuk = '$id_masuk'");
    
        if($kurangi && $hapus){
            header('location:masuk.php');
            exit();
        } else {
            echo "<script>alert('Gagal hapus!');</script>";
        }
    }
    
    if (!function_exists('prosesPembayaran')) {
        function prosesPembayaran($conn, $id_pesanan, $total_bayar, $uang_dibayar) {
            if($uang_dibayar < $total_bayar){
                return ['status'=>false, 'message'=>'Uang dibayar kurang!'];
            }
            $kembalian = $uang_dibayar - $total_bayar;
    
            $query = "INSERT INTO pembayaran (id_pesanan, total_bayar, uang_dibayar, kembalian, tanggal) 
                      VALUES ('$id_pesanan', '$total_bayar', '$uang_dibayar', '$kembalian', NOW())";
    
            if(mysqli_query($conn, $query)){
                return ['status'=>true, 'message'=>'Pembayaran sukses', 'kembalian'=>$kembalian];
            } else {
                return ['status'=>false, 'message'=>'Gagal simpan pembayaran'];
            }
        }
    }

    // Edit pelanggan
if (isset($_POST['editpelanggan'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $no = $_POST['no'];
    $alamat = $_POST['alamat'];

    $update = mysqli_query($conn, "UPDATE pelanggan SET nama='$nama', no_telp='$no', alamat='$alamat' WHERE id_pelanggan='$id_pelanggan'");

    if ($update) {
        header('Location: pelanggan.php');
        exit;
    } else {
        echo "<script>alert('Gagal mengedit pelanggan!'); window.location.href='pelanggan.php';</script>";
    }
}

// Hapus pelanggan
if (isset($_POST['hapuspelanggan'])) {
    $id_pelanggan = $_POST['id_pelanggan'];

    $hapus = mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");

    if ($hapus) {
        header('Location: pelanggan.php');
        exit;
    } else {
        echo "<script>alert('Gagal menghapus pelanggan!'); window.location.href='pelanggan.php';</script>";
    }
}
    
    
?>