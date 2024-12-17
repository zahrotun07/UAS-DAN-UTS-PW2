<?php
session_start();
include 'koneksi.php'; // File koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input dari form dan sanitasi untuk keamanan
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Pastikan username dan password tidak kosong
    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi.";
    } else {
        // Siapkan dan jalankan query untuk mendapatkan data user
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Verifikasi password
                if (password_verify($password, $user['password'])) {
                    // Login berhasil, set session
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect berdasarkan peran pengguna
                    switch ($user['role']) {
                        case 'calon_karyawan':
                            header('Location: pendaftaran.php');
                            break;
                        case 'admin':
                            header('Location: crud.php');
                            break;
                        case 'pimpinan':
                            header('Location: laporan.php');
                            break;
                        default:
                            $error = "Peran tidak valid.";
                    }
                    exit();
                } else {
                    $error = "Password salah.";
                }
            } else {
                $error = "Username tidak ditemukan.";
            }
        } else {
            $error = "Terjadi kesalahan pada query database.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #003366, #0099cc);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
            color: #333;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container input[type="checkbox"] {
            margin-right: 5px;
        }

        .login-container .remember-me {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            font-size: 14px;
            color: #666;
        }

        .login-container button {
            width: 100%;
            background: #00509e;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
            transition: background 0.3s;
        }

        .login-container button:hover {
            background: #003f7f;
        }

        .social-login {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .social-login .social-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 48%;
            background: #fff;
            color: #333;
            border: 1px solid #ccc;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            transition: background 0.3s;
        }

        .social-login .social-button:hover {
            background: #f5f5f5;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>LOGIN</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="remember-me">
                <input type="checkbox" id="remember-me">
                <label for="remember-me">Remember me</label>
            </div>
            <button type="submit">LOGIN</button>
        </form>

        <div class="social-login">
            <a href="https://www.facebook.com/login" target="_blank" class="social-button">
                <i class="fab fa-facebook-f"></i> Facebook
            </a>
            <a href="https://accounts.google.com/signin" target="_blank" class="social-button">
                <i class="fab fa-google"></i> Google
            </a>
        </div>

        <div class="signup-link">
            Not a member? <a href="signup.php">Sign up now</a>
        </div>
    </div>
</body>
</html>