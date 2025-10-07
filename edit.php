<?php include 'koneksi.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM gudang WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = $_POST['nama'];
    $lokasi   = $_POST['lokasi'];
    $kapasitas= $_POST['kapasitas'];

    $conn->query("UPDATE gudang SET nama='$nama', lokasi='$lokasi', kapasitas=$kapasitas WHERE id=$id");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Gudang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

<h2>Edit Gudang</h2>
<form method="POST">
    <div class="mb-3">
        <label>Nama Gudang</label>
        <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Lokasi</label>
        <input type="text" name="lokasi" class="form-control" value="<?= $data['lokasi'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Kapasitas</label>
        <input type="number" name="kapasitas" class="form-control" value="<?= $data['kapasitas'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

</body>
</html>
