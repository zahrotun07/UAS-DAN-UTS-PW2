<?php
session_start();
$conn = new mysqli("localhost", "root", "", "db_perkantoran");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID dari parameter URL
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID tidak ditemukan.";
    exit;
}

// Ambil data berdasarkan ID
$query = "SELECT * FROM calon_karyawan WHERE id = '$id'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    echo "Data tidak ditemukan.";
    exit;
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Calon Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h1 class="text-center">Detail Calon Karyawan</h1>
    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <td><?= htmlspecialchars($data['nama']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($data['email']) ?></td>
        </tr>
        <tr>
            <th>Telepon</th>
            <td><?= htmlspecialchars($data['telepon']) ?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><?= htmlspecialchars($data['alamat']) ?></td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th>
            <td><?= htmlspecialchars($data['tanggal_lahir']) ?></td>
        </tr>
        <tr>
            <th>Posisi</th>
            <td><?= htmlspecialchars($data['posisi']) ?></td>
        </tr>
        <tr>
            <th>Pendidikan</th>
            <td><?= htmlspecialchars($data['pendidikan']) ?></td>
        </tr>
        <tr>
            <th>Pengalaman</th>
            <td><?= htmlspecialchars($data['pengalaman']) ?></td>
        </tr>
        <tr>
            <th>Tanggal Daftar</th>
            <td><?= htmlspecialchars($data['tggl_daftar']) ?></td>
        </tr>
        <tr>
            <th>Foto</th>
            <td>
                <?php if (!empty($data['foto'])): ?>
                    <img src="uploads/foto/<?= htmlspecialchars($data['foto']) ?>" alt="Foto karyawan" style="width: 150px; height: 150px; object-fit: cover;">
                <?php else: ?>
                    Tidak ada foto
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <a href="crud.php" class="btn btn-secondary">Kembali</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
