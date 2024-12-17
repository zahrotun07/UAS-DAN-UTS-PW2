<?php
// Array multidimensi
$products = [
    ["nama" => "Buavita", "stok" => 30, "harga" => 7890],
    ["nama" => "Bango", "stok" => 21, "harga" => 21890],
    ["nama" => "Sariwangi", "stok" => 10, "harga" => 9990],
    ["nama" => "Shampo", "stok" => 23, "harga" => 32450],
    ["nama" => "Bedak", "stok" => 11, "harga" => 15760],
    ["nama" => "Baju", "stok" => 13, "harga" => 55450],
    ["nama" => "Jumper", "stok" => 2, "harga" => 52430]
];
// Tampilkan tabel dari array multidimensi
echo "<h3>Tabel dari Array Multidimensi</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>
        <tr>
            <th>Produk</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>";
foreach ($products as $product) {
    $jumlah = $product['stok'] * $product['harga'];
    echo "<tr>
            <td>{$product['nama']}</td>
            <td>{$product['stok']}</td>
            <td>" . number_format($product['harga'], 0, ',', '.') . "</td>
            <td>" . number_format($jumlah, 0, ',', '.') . "</td>
          </tr>";
}
echo "</table>";
?>