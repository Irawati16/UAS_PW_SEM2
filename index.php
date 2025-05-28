<?php
$conn = new mysqli("localhost", "root", "", "catatan_keuangan");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// tambah catatan
if (isset($_POST['tambah'])) {
    $tanggal = $_POST['tanggal'];
    $jenis_transaksi = $_POST['jenis_transaksi'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];

    $conn->query("INSERT INTO transaksi (tanggal, jenis_transaksi, keterangan, jumlah) VALUES
     ('$tanggal', '$jenis_transaksi', '$keterangan', '$jumlah')");
}

// hapus catatan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM transaksi WHERE id=$id");
}

// mengambil data
$hasil = $conn->query("SELECT * FROM transaksi ORDER BY tanggal DESC");

// menghitung saldo
$saldo = 0;
$transaksi = [];
while ($row = $hasil->fetch_assoc()) {
    $transaksi[] = $row;
    if ($row['jenis_transaksi'] == 'pemasukan') {
        $saldo += $row['jumlah'];
    } else {
        $saldo -= $row['jumlah'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Catatan Keuangan Pribadi</title>
    <style>
        * {
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color:rgb(255, 230, 254);
    margin: 0;
    padding: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

h2 {
    color: #2c3e50;
    margin-bottom: 20px;
}

form {
    width: 100%;
    max-width: 700px;
    background: #ffffff;
    padding: 20px 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
}

form label {
    font-weight: 600;
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
    color: #333;
}

input, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    transition: border-color 0.2s ease;
}

input:focus, select:focus {
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
    margin-top: 10px;
}

button:hover {
    background-color: #663399;
}

table {
    width: 100%;
    max-width: 700px;
    border-collapse: collapse;
    background-color: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #EE82EE;
    color: white;
    font-weight: 600;
}

tr:hover {
    background-color: #f0f8ff;
}

.pemasukan {
    color: green;
    font-weight: 500;
}

.pengeluaran {
    color: red;
    font-weight: 500;
}

a {
    text-decoration: none;
    margin-right: 10px;
    font-weight: bold;
}

.edit {
    color: #2980b9;
}

a:hover {
    text-decoration: underline;
}

.saldo {
    font-size: 20px;
    font-weight: bold;
    color: #2c3e50;
    margin-top: 20px;
}
    </style>
</head>
<body>

<h2><b>Aplikasi Catatan Keuangan Pribadi</b></h2>

<form method="POST">
    <label>Tanggal:</label>
    <input type="date" name="tanggal" required>

    <label>Jenis Transaksi:</label>
    <select name="jenis_transaksi" required>
        <option value="pemasukan">Pemasukan</option>
        <option value="pengeluaran">Pengeluaran</option>
    </select>

    <label>Keterangan:</label>
    <input type="text" name="keterangan" required>

    <label>Jumlah:</label>
    <input type="number" name="jumlah" required>

    <button type="submit" name="tambah">Masuk Catatan</button>
</form>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jenis Transaksi</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transaksi as $t): ?>
        <tr>
            <td><?= $t['tanggal'] ?></td>
            <td class="<?= $t['jenis_transaksi'] ?>"><?= ucfirst($t['jenis_transaksi']) ?></td>
            <td><?= $t['keterangan'] ?></td>
            <td><?= number_format($t['jumlah']) ?></td>
            <td>
                <a class="edit" href="edit.php?id=<?= $t['id'] ?>">Edit</a>
                <a href="?hapus=<?= $t['id'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="saldo">Saldo Saat Ini: Rp <?= number_format($saldo) ?></div>
</body>
</html>
