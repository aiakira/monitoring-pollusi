<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "monitoring_polusi";

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data polusi harian dan bulanan
$query = "SELECT DATE_FORMAT(waktu, '%Y-%m') as bulan, 
                 AVG(pm10) as avg_pm10, 
                 AVG(pm2_5) as avg_pm2_5 
          FROM data_sensor 
          GROUP BY DATE_FORMAT(waktu, '%Y-%m')";
$result = $conn->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>