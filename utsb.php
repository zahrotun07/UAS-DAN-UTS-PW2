<?php
// Array multidimensi untuk menyimpan data produk (nama, stok, harga satuan)
$produk = [
    ["nama" => "Buavita", "stok" => 30, "harga" => 7890],
    ["nama" => "Bango", "stok" => 21, "harga" => 21890],
    ["nama" => "Sariwangi", "stok" => 10, "harga" => 9990],
    ["nama" => "Shampo", "stok" => 23, "harga" => 32450],
    ["nama" => "Bedak", "stok" => 15, "harga" => 11560],
    ["nama" => "Baju", "stok" => 13, "harga" => 55450],
    ["nama" => "Jumper", "stok" => 2, "harga" => 52430],
];
// Menghitung jumlah total per produk dan total keseluruhan
$totalKeseluruhan = 0;
foreach ($produk as &$item) {
    $item["jumlah"] = $item["stok"] * $item["harga"];
    $totalKeseluruhan += $item["jumlah"];
}
// Menghitung diskon
$diskon = 0;
if ($totalKeseluruhan > 400000) {
    $diskon = 0.30 * $totalKeseluruhan;
} elseif ($totalKeseluruhan > 200000) {
    $diskon = 0.15 * $totalKeseluruhan;
}
$totalPembayaran = $totalKeseluruhan - $diskon;
// Tanggal transaksi
$tanggalTransaksi = date("d F Y");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
        }
        .line-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .line-item strong {
            font-weight: bold;
        }
        .total, .discount, .payment-total {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div class="header">
    <h2>Struk Pembayaran</h2>
    <p>Tanggal Transaksi: <?= $tanggalTransaksi; ?></p>
</div>
<!-- Daftar Produk -->
<?php foreach ($produk as $item): ?>
<div class="line-item">
    <span><?= $item["nama"]; ?> (<?= $item["stok"]; ?> x <?= number_format($item["harga"], 0, ',', '.'); ?>)</span>
    <span><?= number_format($item["jumlah"], 0, ',', '.'); ?></span>
</div>
<?php endforeach; ?>
<!-- Total, Diskon, dan Total Pembayaran -->
<div class="total">
    <strong>Total:</strong>
    <span><?= number_format($totalKeseluruhan, 0, ',', '.'); ?></span>
</div>
<div class="discount">
    <strong>Diskon:</strong>
    <span><?= number_format($diskon, 0, ',', '.'); ?></span>
</div>
<div class="payment-total">
    <strong>Total Pembayaran:</strong>
    <span><?= number_format($totalPembayaran, 0, ',', '.'); ?></span>
</div>
<div class="footer">
    <p>Terima Kasih telah berbelanja!</p>
</div>
</body>
</html>