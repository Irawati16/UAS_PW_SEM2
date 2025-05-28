<?php
$conn = new mysqli("localhost", "root", "", "catatan_keuangan");

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM transaksi WHERE id=$id");
$data = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $tanggal = $_POST['tanggal'];
    $jenis = $_POST['jenis_transaksi'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];

    $conn->query("UPDATE transaksi SET tanggal='$tanggal', jenis_transaksi='$jenis', keterangan='$keterangan', jumlah='$jumlah' WHERE id=$id");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Catatan</title>
    <style>
       * {
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: rgb(255, 230, 254);
    margin: 0;
    padding: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

h2 {
    color: #2c3e50;
    margin-bottom: 25px;
}

form {
    width: 100%;
    max-width: 700px;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

form label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
}

input[type="text"],
input[type="number"],
input[type="date"],
select {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    transition: border-color 0.2s ease-in-out;
}

input:focus,
select:focus {
    border-color: #3498db;
    outline: none;
}

button {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    background-color: #DDA0DD;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #663399;
}

    </style>
</head>
<body>
<h2>Edit Catatan</h2>
<form method="POST">
    <label>Tanggal:</label>
    <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required><br>

    <label>Jenis:</label>
    <select name="jenis_transaksi">
        <option value="pemasukan" <?= $data['jenis_transaksi'] == 'pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
        <option value="pengeluaran" <?= $data['jenis_transaksi'] == 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
    </select><br>

    <label>Keterangan:</label>
    <input type="text" name="keterangan" value="<?= $data['keterangan'] ?>" required><br>

    <label>Jumlah:</label>
    <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" required><br>

    <button type="submit" name="update">Update Catatan</button>
</form>
</body>
</html>
