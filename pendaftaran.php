<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi apakah file foto diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        // Ambil data dari form dengan filter untuk mencegah XSS
        $nama = htmlspecialchars($_POST['nama']);
        $email = htmlspecialchars($_POST['email']);
        $telepon = htmlspecialchars($_POST['telepon']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir']);
        $posisi = htmlspecialchars($_POST['posisi']);
        $pendidikan = htmlspecialchars($_POST['pendidikan']);
        $pengalaman = htmlspecialchars($_POST['pengalaman']);

        // Proses unggah file foto
        $foto_dir = "uploads/foto/";
        if (!is_dir($foto_dir)) {
            mkdir($foto_dir, 0777, true);
        }

        $foto = uniqid() . "_" . basename($_FILES['foto']['name']);
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_path = $foto_dir . $foto;

        if (move_uploaded_file($foto_tmp, $foto_path)) {
            // Koneksi ke database
            $conn = new mysqli("localhost", "root", "", "db_perkantoran");

            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Gunakan prepared statement untuk mencegah SQL Injection
            $stmt = $conn->prepare("INSERT INTO calon_karyawan 
                (nama, email, telepon, alamat, tanggal_lahir, posisi, pendidikan, pengalaman, foto) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $nama, $email, $telepon, $alamat, $tanggal_lahir, $posisi, $pendidikan, $pengalaman, $foto);

            if ($stmt->execute()) {
                echo "<p style='color:green;'>Data berhasil disimpan!</p>";
            } else {
                echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "<p style='color:red;'>Gagal mengunggah foto. Pastikan folder memiliki izin yang sesuai.</p>";
        }
    } else {
        // Debugging error pengunggahan
        $upload_error = $_FILES['foto']['error'];
        switch ($upload_error) {
            case UPLOAD_ERR_NO_FILE:
                echo "<p style='color:red;'>Tidak ada file yang diunggah.</p>";
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "<p style='color:red;'>Ukuran file terlalu besar.</p>";
                break;
            default:
                echo "<p style='color:red;'>Terjadi kesalahan saat mengunggah file. Error kode: $upload_error.</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Calon Karyawan</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h2>Pendaftaran Calon Karyawan</h2>
                    </div>
                    <div class="card-body">
                        <form action="pendaftaran.php" method="POST" enctype="multipart/form-data">
                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                            </div>
                            <!-- Nomor Telepon -->
                            <div class="mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="telepon" name="telepon" placeholder="Masukkan nomor telepon" required>
                            </div>
                            <!-- Alamat -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                            </div>
                            <!-- Tanggal Lahir -->
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                            </div>
                            <!-- Posisi yang Dilamar -->
                            <div class="mb-3">
                                <label for="posisi" class="form-label">Posisi yang Dilamar</label>
                                <input type="text" class="form-control" id="posisi" name="posisi" placeholder="Masukkan posisi yang dilamar" required>
                            </div>
                            <!-- Pendidikan Terakhir -->
                            <div class="mb-3">
                                <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                                <input type="text" class="form-control" id="pendidikan" name="pendidikan" placeholder="Masukkan pendidikan terakhir" required>
                            </div>
                            <!-- Pengalaman Kerja -->
                            <div class="mb-3">
                                <label for="pengalaman" class="form-label">Pengalaman Kerja</label>
                                <input type="text" class="form-control" id="pengalaman" name="pengalaman" placeholder="Masukkan pengalaman kerja" required>
                            </div>
                            <!-- Unggah Foto -->
                            <div class="mb-3">
                                <label for="foto" class="form-label">Unggah Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                            </div>
                            <!-- Tombol Submit -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100">Daftar</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center text-muted">
                        <small>&copy; 2024 Sistem Informasi Perkantoran</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>