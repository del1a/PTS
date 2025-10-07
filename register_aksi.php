<?php
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];
$level    = $_POST['level'];

// enkripsi password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// masukkan ke database
$query = "INSERT INTO user (username, password, level) VALUES ('$username', '$hashedPassword', '$level')";
if (mysqli_query($koneksi, $query)) {
    echo "Registrasi berhasil! <a href='index.php'>Login sekarang</a>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>
