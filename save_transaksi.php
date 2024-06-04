<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "gaji");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_gaji = $_POST['ID_Gaji'];
$tanggal = $_POST['Tanggal'];
$karyawan_id = $_POST['Nama_Karyawan'];
$jabat = $_POST['Jabatan'];
$gaji_pokok = $_POST['Gaji_Pokok'];
$tunjangan_jabat = $_POST['Tunjangan_Jabatan'];
$status = $_POST['Status'];
$jumlah_anak = $_POST['Jumlah_Anak'];
$tunjangan_anak = $_POST['Tunjangan_Anak'];
$bpjs = $_POST['BPJS'];
$pph21 = $_POST['PPh21'];
$total_pendapatan = $_POST['Total_Pendapatan'];
$total_potongan = $_POST['Total_Potongan'];
$gaji_bersih = $_POST['Gaji_Bersih'];
$id_user = 1; // Sesuaikan dengan Id_User yang sesuai

// Bersihkan input sebelum digunakan dalam query
$id_gaji = mysqli_real_escape_string($conn, $id_gaji);
$tanggal = mysqli_real_escape_string($conn, $tanggal);
$karyawan_id = mysqli_real_escape_string($conn, $karyawan_id);
$jabat = mysqli_real_escape_string($conn, $jabat);
$gaji_pokok = mysqli_real_escape_string($conn, $gaji_pokok);
$tunjangan_jabat = mysqli_real_escape_string($conn, $tunjangan_jabat);
$status = mysqli_real_escape_string($conn, $status);
$jumlah_anak = mysqli_real_escape_string($conn, $jumlah_anak);
$tunjangan_anak = mysqli_real_escape_string($conn, $tunjangan_anak);
$bpjs = mysqli_real_escape_string($conn, $bpjs);
$pph21 = mysqli_real_escape_string($conn, $pph21);
$total_pendapatan = mysqli_real_escape_string($conn, $total_pendapatan);
$total_potongan = mysqli_real_escape_string($conn, $total_potongan);
$gaji_bersih = mysqli_real_escape_string($conn, $gaji_bersih);
$id_user = mysqli_real_escape_string($conn, $id_user);

$sql = "INSERT INTO tbl_gaji (ID_Gaji, Tanggal, Id_Karyawan, Jabatan, Gaji_Pokok, Tunjangan_Jabatan, Status, Jumlah_Anak, Tunjangan_Anak, BPJS, PPh21, Total_Pendapatan, Total_Potongan, Gaji_Bersih, Id_User) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error: " . $conn->error); // Handle error prepared statement
}

$stmt->bind_param("sssssssssssssss", $id_gaji, $tanggal, $karyawan_id, $jabat, $gaji_pokok, $tunjangan_jabat, $status, $jumlah_anak, $tunjangan_anak, $bpjs, $pph21, $total_pendapatan, $total_potongan, $gaji_bersih, $id_user);

if ($stmt->execute()) {
    header("Location: dashboard.php");
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
