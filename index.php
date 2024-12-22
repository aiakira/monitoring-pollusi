<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "monitoring_polusi";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM data_sensor ORDER BY waktu DESC LIMIT 10";
$result = $conn->query($sql);

?>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Monitoring Polusi Udara UNM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="output.css" rel="stylesheet">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body id="page-top" class="bg-gray-200">
    <div id="wrapper">
        <div id="content-wrapper" class="flex flex-col">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow bg-gray-500 font-sans">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <h1 class="h4 mb-0 text-2xl text-black flex items-center">
                            <img src="https://pelajarinfo.id/wp-content/uploads/2022/08/Universitas-Negeri-Makassar-Logo.png" alt="UNM Logo" class="h-16 w-48 mr-2">
                            <span class="font-bold text-4xl shadow">Monitoring Polusi Udara UNM</span>
                        </h1>
                        <div class="navbar-text ml-auto text-black">
                            Lokasi: Kota Makassar, Jl. Andi Pangeran Pettarani
                            <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Andi+Pangeran+Pettarani,+Makassar" target="_blank" class="ml-2 btn btn-sm bg-black text-white">Lihat Peta</a>
                        </div>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4 bg-gray-500">
                                <div class="card-header py-3 text-center bg-gray-500">
                                    <h6 class="m-0 font-weight-bold text-black text-xl">Informasi Polusi Udara</h6>
                                </div>
                                <div class="card-body bg-gray-100">
                                    <div class="table-responsive">
                                        <table class="min-w-full bg-gray-500 text-black">
                                            <thead>
                                                <tr>
                                                    <th class="py-2 px-4">Tingkat Polusi Udara</th>
                                                    <th class="py-2 px-4">Indeks Kualitas Udara</th>
                                                    <th class="py-2 px-4">Polutan Utama</th>
                                                    <th class="py-2 px-4">Kelembaban</th>
                                                    <th class="py-2 px-4">Suhu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="bg-gray-100">
                                                    <td class="py-2 px-4">Sedang</td>
                                                    <td class="py-2 px-4">65 AQI US</td>
                                                    <td class="py-2 px-4">PM2.5</td>
                                                    <td class="py-2 px-4">75%</td>
                                                    <td class="py-2 px-4">25°C</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4 bg-white">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gray-500">
                                    <h6 class="m-0 font-weight-bold text-black">Grafik Gabungan Polusi Udara</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="combinedPollutionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card shadow mb-4 bg-gray-100">
                                <div class="card-header py-3 bg-gray-500">
                                    <h6 class="m-0 font-weight-bold text-black">Polutan Yang Terdeteksi</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold text-black text-lg">PM 2.5 <span class="float-right">24.3µg/m³</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-red-500" role="progressbar" style="width: 24.3%" aria-valuenow="24.3" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold text-black text-lg">PM10 <span class="float-right">48.3µg/m³</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-yellow-500" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold text-black text-lg">NO2 <span class="float-right">64.3µg/m³</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-blue-500" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold text-black text-lg">SO2 <span class="float-right">Complete!</span></h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-green-500" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card shadow mb-4 bg-white">
                                <div class="card-header py-3 bg-gray-500">
                                    <h6 class="m-0 font-weight-bold text-black">Rekomendasi Kesehatan</h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-black">Menjaga kesehatan di tengah tingkat polusi yang tinggi sangat penting. Berikut beberapa tips yang bisa Anda ikuti:</p>
                                    <ul class="text-black">
                                        <li>Menggunakan masker saat berada di luar ruangan.</li>
                                        <li>Menggunakan pembersih udara di dalam ruangan.</li>
                                        <li>Menghindari aktivitas luar ruangan saat tingkat polusi tinggi.</li>
                                        <li>Menjaga ventilasi udara yang baik di dalam rumah atau kantor.</li>
                                    </ul>
                                    <p class="text-black">Ikuti rekomendasi ini untuk membantu mengurangi risiko kesehatan akibat polusi udara.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow mb-4 bg-transparent">
                                <div class="card-header py-3 bg-gray-500">
                                    <h6 class="m-0 font-weight-bold text-black">Peta Interaktif</h6>
                                </div>
                                <div class="card-body">
                                    <div id="airQualityMap" class="h-96"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <div class="flex flex-col items-center justify-center">
                            <div class="flex items-center">
                                <span id="faculty-text" class="font-extrabold text-black text-4xl mr-4"></span>
                                <img src="https://ft.unm.ac.id/wp-content/uploads/2024/09/ft-unm-redg.png" alt="FTUNM Logo" class="h-16 w-56 animate-fadeIn">
                            </div>
                            <div class="ml-4 font-bold text-black text-xs">JURUSAN TEHNIK ELEKTRONIKA / PRODI PENDIDIKAN VOKASIONAL MEKATRONIKA</div>
                        </div>
                    </div>
                </div>
            </footer>
            <footer class="sticky-footer bg-gray-600">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Hak Cipta &copy; Universitas Negeri Makassar 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script>
        var dailyData = {
            label: 'Tingkat PM2.5 Harian',
            data: [20, 30, 40, 30, 20, 10, 50],
            type: 'line',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            fill: false
        };
        var monthlyData = {
            label: 'Tingkat PM10 Bulanan',
            data: [30, 20, 50, 20, 10],
            type: 'bar',
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        };
        var combinedData = {
            labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni"],
            datasets: [dailyData, monthlyData]
        };
        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
                responsive: true
            }
        };
        var ctxCombined = document.getElementById('combinedPollutionChart').getContext('2d');
        var combinedPollutionChart = new Chart(ctxCombined, {
            type: 'bar', 
            data: combinedData,
            options: options
        });
        var map = L.map('airQualityMap').setView([-5.16908, 119.43611], 16); 
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([-5.16908, 119.43611], { draggable: true }).addTo(map);

        marker.bindPopup("<b>Kualitas Udara Kota Makassar</b><br>PM2.5: Tinggi").openPopup();

        marker.on('click', function() {
            var popupContent = `
                <div>
                    <h4>Kualitas Udara</h4>
                    <p>Lokasi: ${marker.getLatLng().lat.toFixed(2)}° S, ${marker.getLatLng().lng.toFixed(2)}° E</p>
                    <p>Kecepatan Angin: 26 km/h</p>
                    <p>PM2.5: 3.2 µg/m³</p>
                </div>
            `;
            marker.bindPopup(popupContent).openPopup();
        });

        // Event listener untuk mengupdate popup saat marker digeser
        marker.on('dragend', function() {
            var position = marker.getLatLng();
            marker.bindPopup(`<b>Lokasi Baru:</b><br>${position.lat.toFixed(5)}, ${position.lng.toFixed(5)}`).openPopup();
        });
    </script>
    <script>
        let facultyText = "FACULTY OF ENGINEERING";
        let index = 0;

        function typeWriter() {
            if (index < facultyText.length) {
                document.getElementById("faculty-text").innerHTML += facultyText.charAt(index);
                index++;
                setTimeout(typeWriter, 150);
            }
        }

        window.onload = function() {
            typeWriter();
        };
    </script>
</body>
</html>