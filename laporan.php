<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_perkantoran");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil semua data dari tabel `calon_karyawan`
$query = "SELECT * FROM calon_karyawan";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN PENDAFTARAN CALON KARYAWAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            flex: 1;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            background-color: #f8f9fa;
            padding: 10px 20px;
            width: auto;
            border-top: 1px solid #ccc;
            font-size: 14px;
        }

        .table thead {
            background-color: #0d6efd; /* Warna biru untuk header */
            color: #fff;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa; /* Warna abu-abu muda */
        }

        .table tbody tr:nth-of-type(even) {
            background-color: #e9ecef; /* Warna abu-abu lebih terang */
        }

        @media print {
            .no-print {
                display: none;
            }

            .footer {
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                background-color: #fff;
                border: none;
            }
        }
    </style>
</head>
<body>
<div class="header text-center">
    <h1>Laporan Data Calon Karyawan</h1>
    <p>Tanggal Cetak: <?= date("d-m-Y") ?></p>
</div>

<div class="container py-5">
    <div class="text-end mb-3 no-print">
        <button onclick="window.print()" class="btn btn-success">Cetak Laporan</button>
        <a href="dasboard.php" class="btn btn-secondary">Kembali</a>
    </div>
    <table class="table table-striped">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Tanggal Lahir</th>
            <th>Posisi</th>
            <th>Pendidikan</th>
            <th>Pengalaman</th>
            <th>Tanggal Daftar</th>
            <th>Foto</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="table-secondary">
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['telepon']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_lahir']) ?></td>
                <td><?= htmlspecialchars($row['posisi']) ?></td>
                <td><?= htmlspecialchars($row['pendidikan']) ?></td>
                <td><?= htmlspecialchars($row['pengalaman']) ?></td>
                <td><?= htmlspecialchars($row['tggl_daftar']) ?></td>
                <td>
                    <?php if (!empty($row['foto'])): ?>
                        <img src="uploads/foto/<?= htmlspecialchars($row['foto']) ?>" alt="Foto" style="width: 80px; height: 80px; object-fit: cover;">
                    <?php else: ?>
                        Tidak ada foto
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="footer">
    <p>&copy; <?= date("Y") ?> Perusahaan Perkantoran</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
