<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_perkantoran");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk mengecek level user
function checkUserLevel($level)
{
    if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] != $level) {
        header("Location: userlogin.php");
        exit;
    }
}

// Proses Login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_level'] = $user['level'];

        header("Location: crud.php");
        exit;
    } else {
        echo "Login gagal. Periksa username atau password!";
    }
}

// Proses Tambah/Edit Calon Karyawan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $posisi = $_POST['posisi'];
    $pendidikan = $_POST['pendidikan'];
    $pengalaman = $_POST['pengalaman'];
    $foto = $_FILES['foto']['name'] ?? null;

    if ($foto) {
        $target_dir = "uploads/foto/";
        $target_file = $target_dir . basename($foto);
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            echo "File berhasil diunggah.";
        } else {
            echo "Gagal mengunggah file.";
        }
    }

    if ($id) {
        // Update data
        $sql = "UPDATE calon_karyawan SET nama='$nama', email='$email', telepon='$telepon', alamat='$alamat', tanggal_lahir='$tanggal_lahir', posisi='$posisi', pendidikan='$pendidikan', pengalaman='$pengalaman'";
        if ($foto) {
            $sql .= ", foto='$foto'";
        }
        $sql .= " WHERE id='$id'";
    } else {
        // Tambah data
        $sql = "INSERT INTO calon_karyawan (nama, email, telepon, alamat, tanggal_lahir, posisi, pendidikan, pengalaman, foto) VALUES ('$nama', '$email', '$telepon', '$alamat', '$tanggal_lahir', '$posisi', '$pendidikan', '$pengalaman', '$foto')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: crud.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Proses Hapus Calon Karyawan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM calon_karyawan WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: crud.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Proses Search
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
$query = "SELECT * FROM calon_karyawan WHERE nama LIKE '%$search%' OR posisi LIKE '%$search%'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD ADMIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h1 class="text-center">DASBOARD CRUD</h1>

    <form method="GET" class="mt-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari Calon Karyawan..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <table class="table table-bordered table-striped table-hover mt-10">
        <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Posisi</th>
            <th>Pendidikan</th>
            <th>Tanggal Daftar</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
            <tr class="table-secondary">
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['telepon']) ?></td>
                <td><?= htmlspecialchars($row['posisi']) ?></td>
                <td><?= htmlspecialchars($row['pendidikan']) ?></td>
                <td><?= htmlspecialchars($row['tggl_daftar']) ?></td>
                <td>
                    <?php if (!empty($row['foto'])): ?>
                        <img src="uploads/foto/<?= htmlspecialchars($row['foto']) ?>" alt="Foto karyawan" style="width: 80px; height: 80px; object-fit: cover;">
                    <?php else: ?>
                        Tidak ada foto
                    <?php endif; ?>
                </td>
                <td>
                    <a href="read.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-primary btn-sm">Read</a>
                    <a href="update.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-warning btn-sm">Update</a>
                    <a href="?delete=<?= htmlspecialchars($row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="dasboard.php" class="btn btn-danger">kembali</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
