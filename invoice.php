<?php
require 'ceklogin.php';
require 'fungction.php';

if (!isset($_GET['id_pesanan'])) {
    header('location:pesanan.php');
    exit;
}

$id_pesanan = $_GET['id_pesanan'];
$pesanan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan'"));
if (!$pesanan) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

$produk = mysqli_query($conn, "SELECT * FROM dt_pesanan p JOIN produk pr ON p.id_produk=pr.id_produk WHERE p.id_pesanan='$id_pesanan'");
$pembayaran = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_pesanan='$id_pesanan' ORDER BY tanggal DESC LIMIT 1"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?=$id_pesanan;?></title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            padding: 20px;
            max-width: 350px;
            margin: auto;
            background: #fff;
            color: #000;
        }

        h2, h4, p {
            text-align: center;
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 5px;
            font-size: 14px;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .dashed {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .total-row {
            font-weight: bold;
            border-top: 1px solid #000;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body onload="window.print()">

    <h2>T coffe</h2>
    <p>Jl. Contoh No.123, Jakarta</p>
    <div class="dashed"></div>

    <p><strong>INVOICE</strong></p>
    <p>ID Pesanan: <strong>#<?=$id_pesanan;?></strong></p>
    <p>Tanggal: <?=(!empty($pesanan['tgl'])) ? date('d-m-Y H:i', strtotime($pesanan['tgl'])) : '-'; ?></p>

    <table>
        <tbody>
            <?php
            $grandtotal = 0;
            while ($data = mysqli_fetch_array($produk)) {
                $subtotal = $data['harga'] * $data['qty'];
                $grandtotal += $subtotal;
            ?>
            <tr>
                <td colspan="2"><?=$data['nama_produk'];?></td>
            </tr>
            <tr>
                <td><?=$data['qty'];?> x Rp<?=number_format($data['harga']);?></td>
                <td class="right">Rp<?=number_format($subtotal);?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="dashed"></div>

    <table>
        <tr>
            <td>Total</td>
            <td class="right">Rp<?=number_format($grandtotal);?></td>
        </tr>
        <tr>
            <td>Uang Dibayar</td>
            <td class="right">Rp<?=number_format($pembayaran['uang_dibayar'] ?? 0);?></td>
        </tr>
        <tr class="total-row">
            <td>Kembalian</td>
            <td class="right">Rp<?=number_format($pembayaran['kembalian'] ?? 0);?></td>
        </tr>
    </table>

    <div class="dashed"></div>
    <p class="footer">Terima kasih atas kunjungannya!</p>
    <p class="footer">~ T Coffe ~</p>

</body>
</html>
