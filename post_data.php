<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "monitoring_polusi";

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari request
$suhu = $_POST['suhu'];
$kelembaban = $_POST['kelembaban'];
$mq2_ppm = $_POST['mq2_ppm'];
$mq7_ppm = $_POST['mq7_ppm'];

// Simpan data ke database
$sql = "INSERT INTO data_sensor (suhu, kelembaban, mq2_ppm, mq7_ppm) 
        VALUES ('$suhu', '$kelembaban', '$mq2_ppm', '$mq7_ppm')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
