<?php
   $host="localhost";
   $user="root";
   $pass="";
   $database="catatan_keuangan";
   $koneksi = mysqli_connect($host,$user,$pass,$database);
   
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
