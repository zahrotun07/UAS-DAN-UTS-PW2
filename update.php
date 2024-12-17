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

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $posisi = $_POST['posisi'];
    $pendidikan = $_POST['pendidikan'];
    $pengalaman = $_POST['pengalaman'];

    $foto = $_FILES['foto']['name'] ?? $data['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/foto/";
        $target_file = $target_dir . basename($foto);
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            echo "Foto berhasil diperbarui.";
        }
    }

    $sql = "UPDATE calon_karyawan SET 
        nama='$nama',
        email='$email',
        telepon='$telepon',
        alamat='$alamat',
        tanggal_lahir='$tanggal_lahir',
        posisi='$posisi',
        pendidikan='$pendidikan',
        pengalaman='$pengalaman',
        foto='$foto'
        WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: crud.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Calon Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h1 class="text-center">EDIT DATA</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="<?= htmlspecialchars($data['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" name="telepon" class="form-control" id="telepon" value="<?= htmlspecialchars($data['telepon']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" id="alamat" rows="3" required><?= htmlspecialchars($data['alamat']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" value="<?= htmlspecialchars($data['tanggal_lahir']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="posisi" class="form-label">Posisi</label>
            <input type="text" name="posisi" class="form-control" id="posisi" value="<?= htmlspecialchars($data['posisi']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="pendidikan" class="form-label">Pendidikan</label>
            <input type="text" name="pendidikan" class="form-control" id="pendidikan" value="<?= htmlspecialchars($data['pendidikan']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="pengalaman" class="form-label">Pengalaman</label>
            <textarea name="pengalaman" class="form-control" id="pengalaman" rows="3" required><?= htmlspecialchars($data['pengalaman']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" class="form-control" id="foto">
            <?php if (!empty($data['foto'])): ?>
                <img src="uploads/foto/<?= htmlspecialchars($data['foto']) ?>" alt="Foto karyawan" style="width: 100px; height: 100px; object-fit: cover;" class="mt-2">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="crud.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html