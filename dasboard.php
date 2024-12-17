<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Informasi Perkantoran</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link ke Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                        url('https://tse2.mm.bing.net/th?id=OIP.I8VWW-f49InI7PgnNrj0qAHaFa&pid=Api&P=0&h=180') no-repeat center center/cover;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        .menu-row {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 15px;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #333;
        }

        .card-title {
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .menu-icon {
            font-size: 2.5rem;
            color: #6a11cb;
        }

        footer {
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: white;
        }

        .description {
            max-width: 800px;
            margin: 20px auto;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <!-- Dashboard Content -->
    <div class="dashboard-container">
        <h1>Selamat datang di Sistem Informasi Perkantoran</h1>
        <p class="description">Perusahaan kami telah berdiri sejak lama dengan komitmen untuk memberikan layanan terbaik dalam bidang administrasi dan manajemen perkantoran. Sistem informasi ini dirancang untuk mempermudah proses pendaftaran, pengelolaan data, dan pembuatan laporan secara efisien dan terintegrasi, memastikan semua operasional berjalan lancar dan terstruktur.</p>

        <!-- Menu Horizontal -->
        <div class="menu-row">

            <!-- Menu Registrasi -->
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-user-plus menu-icon"></i>
                    <h2 class="card-title">Registrasi</h2>
                    <p> pendaftaran calon karyawan.</p>
                    <a href="pendaftaran.php" class="btn btn-primary w-100">Masuk</a>
                </div>
            </div>

            <!-- Menu CRUD -->
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-database menu-icon"></i>
                    <h2 class="card-title">CRUD</h2>
                    <p>Kelola data karyawan.</p>
                    <a href="crud.php" class="btn btn-warning w-100">Masuk</a>
                </div>
            </div>

            <!-- Menu Laporan Pimpinan -->
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-file-alt menu-icon"></i>
                    <h2 class="card-title">Pimpinan</h2>
                    <p>Lihat dan cetak laporan.</p>
                    <a href="laporan.php" class="btn btn-success w-100">Masuk</a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?= date("Y") ?> Perusahaan Perkantoran</p>
    </div>

    <!-- Logout Button -->
    <footer>
        <a href="logout.php" class="btn btn-danger btn-lg">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </footer>

    <!-- Link ke Bootstrap JS dan dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
