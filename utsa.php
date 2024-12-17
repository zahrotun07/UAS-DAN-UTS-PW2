<?php
// Array satu dimensi
$nama_produk = ["Buavita", "Bango", "Sariwangi", "Shampo", "Bedak", "Baju", "Jumper"];
$stok_produk = [30, 21, 10, 23, 11, 13, 2];
$harga_produk = [7890, 21890, 9990, 32450, 15760, 55450, 52430];
echo "<h3>Tabel dari Array Biasa</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>
        <tr>
            <th>Produk</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>";
for ($i = 0; $i < count($nama_produk); $i++) {
    $jumlah = $stok_produk[$i] * $harga_produk[$i];
    echo "<tr>
            <td>{$nama_produk[$i]}</td>
            <td>{$stok_produk[$i]}</td>
            <td>" . number_format($harga_produk[$i], 0, ',', '.') . "</td>
            <td>" . number_format($jumlah, 0, ',', '.') . "</td>
          </tr>";
}
echo "</table>";
?>