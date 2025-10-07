<?php
session_start();
include 'koneksi.php';

// Inisialisasi percobaan login
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// Jika akun terkunci, cek apakah sudah lewat 20 detik 
if (isset($_SESSION['lock_time'])) {
    $lock_duration = 20; // 20 detik
    $elapsed = time() - $_SESSION['lock_time'];

    if ($elapsed < $lock_duration) {
        $sisa = $lock_duration - $elapsed;
        $message = "Akun terkunci sementara. Silakan coba lagi setelah $sisa detik.";
        showMessage($message, $sisa, true); // mode terkunci
        exit;
    } else {
        // Reset percobaan jika sudah lewat
        $_SESSION['login_attempts'] = 0;
        unset($_SESSION['lock_time']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' LIMIT 1");
    $user   = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Reset percobaan login jika berhasil
        $_SESSION['login_attempts'] = 0;
        unset($_SESSION['lock_time']);

        $_SESSION['username'] = $user['username'];
        $_SESSION['level']    = $user['level'];

        // Redirect berdasarkan level
        switch ($user['level']) {
            case "admin":
                header("Location: admin/index.php");
                break;
            case "staff":
                header("Location: staff/index.php");
                break;
            case "user":
                header("Location: user/index.php");
                break;
            default:
                header("Location: index.php");
                break;
        }
        exit;
    } else {
        // Username / password salah → hitung percobaan
        $_SESSION['login_attempts'] += 1;
        $sisa = 3 - $_SESSION['login_attempts'];

        if ($sisa > 0) {
            $message = "Username atau Password salah. Kesempatan tersisa: $sisa kali.";
            showMessage($message);
        } else {
            // Jika sudah lebih dari 3 kali salah → kunci akun
            $_SESSION['lock_time'] = time();
            $message = "Akun terkunci sementara. Silakan coba lagi setelah 20 detik.";
            showMessage($message, 20, true); // mode terkunci
        }
    }
}

// Fungsi untuk menampilkan pesan dalam tampilan rapi
function showMessage($msg, $sisa = null, $locked = false) {
    echo '
    <!doctype html>
    <html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Login Gagal</title>
    </head>
    <body class="bg-light d-flex justify-content-center align-items-center" style="height:100vh;">
        <div class="card shadow p-4" style="max-width:400px; width:100%;">
            <h5 class="text-center text-danger mb-3">Login Gagal</h5>
            <div class="alert alert-danger text-center">
                <span id="pesan">'.$msg.'</span>
            </div>';

    // Tombol hanya muncul jika tidak dalam keadaan terkunci
    if (!$locked) {
        echo '
            <div class="d-grid">
                <a href="index.php" class="btn btn-primary">Kembali ke Login</a>
            </div>';
    }

    echo '
        </div>

        <script>
        let sisa = '.($sisa ?? 0).';
        if(sisa > 0){
            let pesan = document.getElementById("pesan");
            let timer = setInterval(()=>{
                if(sisa <= 0){
                    clearInterval(timer);
                    pesan.innerHTML = "Silakan coba login kembali.";
                    // Tambahkan tombol login setelah timer selesai
                    let btnDiv = document.createElement("div");
                    btnDiv.className = "d-grid mt-3";
                    btnDiv.innerHTML = \'<a href="index.php" class="btn btn-primary">Kembali ke Login</a>\';
                    document.querySelector(".card").appendChild(btnDiv);
                } else {
                    pesan.innerHTML = "Akun terkunci sementara. Silakan coba lagi setelah " + sisa + " detik.";
                    sisa--;
                }
            }, 1000);
        }
        </script>
    </body>
    </html>';
}
?>