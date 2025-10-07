<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Gudang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

<h2>Data Gudang</h2>


<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Lokasi</th>
        <th>Kapasitas</th>
        <th>Aksi</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM gudang");
    $no = 1;
    while($row = $result->fetch_assoc()) {
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['nama'] ?></td>
        <td><?= $row['lokasi'] ?></td>
        <td><?= $row['kapasitas'] ?></td>
        <td>
            
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
