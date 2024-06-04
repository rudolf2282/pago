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

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $NIK = $_POST['NIK'];
    $Nama = $_POST['Nama'];
    $Id_Jabatan = $_POST['Id_Jabatan'];
    $Status = $_POST['Status'];
    $Jumlah_Anak = $_POST['Jumlah_Anak'];
    $Tunjangan_Anak = $_POST['Tunjangan_Anak'];
    $Gaji_Pokok = $_POST['Gaji_Pokok'];
    $Tunjangan_Jabatan = $_POST['Tunjangan_Jabatan'];

    $sql = "UPDATE tbl_karyawan 
            SET NIK='$NIK', Nama='$Nama', Id_Jabatan='$Id_Jabatan', Status='$Status', Jumlah_Anak='$Jumlah_Anak', Tunjangan_Anak='$Tunjangan_Anak', Gaji_Pokok='$Gaji_Pokok', Tunjangan_Jabatan='$Tunjangan_Jabatan'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: karyawan.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM tbl_karyawan WHERE id=$id";
$result = $conn->query($sql);
$karyawan = $result->fetch_assoc();

$sql = "SELECT id, Nama_Jabatan, Gaji_Pokok, Tunjangan_Jabatan FROM tbl_jabatan";
$jabatans = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Karyawan</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <h1>Edit Karyawan</h1>
        <form action="edit_karyawan.php?id=<?= $id ?>" method="post">
            <div class="form-group">
                <label for="NIK">NIK:</label>
                <input type="text" name="NIK" class="form-control" value="<?= $karyawan['NIK'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="Nama">Nama:</label>
                <input type="text" name="Nama" class="form-control" value="<?= $karyawan['Nama'] ?>" required>
            </div>
            <div class="form-group">
                <label for="Id_Jabatan">Jabatan:</label>
                <select name="Id_Jabatan" id="Id_Jabatan" class="form-control" required>
                    <?php while($jabatan = $jabatans->fetch_assoc()): ?>
                        <option value="<?= $jabatan['id']; ?>" <?= $jabatan['id'] == $karyawan['Id_Jabatan'] ? 'selected' : '' ?>><?= $jabatan['Nama_Jabatan']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Gaji_Pokok">Gaji Pokok:</label>
                <input type="text" name="Gaji_Pokok" id="Gaji_Pokok" class="form-control" value="<?= $karyawan['Gaji_Pokok'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="Tunjangan_Jabatan">Tunjangan Jabatan:</label>
                <input type="text" name="Tunjangan_Jabatan" id="Tunjangan_Jabatan" class="form-control" value="<?= $karyawan['Tunjangan_Jabatan'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="Status">Status:</label>
                <select name="Status" id="Status" class="form-control" required>
                    <option value="Kawin" <?= $karyawan['Status'] == 'Kawin' ? 'selected' : '' ?>>Kawin</option>
                    <option value="Belum Kawin" <?= $karyawan['Status'] == 'Belum Kawin' ? 'selected' : '' ?>>Belum Kawin</option>
                </select>
            </div>
            <div class="form-group" id="Jumlah_Anak_Group">
                <label for="Jumlah_Anak">Jumlah Anak:</label>
                <input type="number" name="Jumlah_Anak" id="Jumlah_Anak" class="form-control" value="<?= $karyawan['Jumlah_Anak'] ?>">
            </div>
            <div class="form-group" id="Tunjangan_Anak_Group">
                <label for="Tunjangan_Anak">Tunjangan Anak:</label>
                <input type="text" name="Tunjangan_Anak" id="Tunjangan_Anak" class="form-control" value="<?= $karyawan['Tunjangan_Anak'] ?>" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="karyawan.php" class="btn btn-secondary">Close</a>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            if ($('#Status').val() == 'Kawin') {
                $('#Jumlah_Anak_Group, #Tunjangan_Anak_Group').show();
            } else {
                $('#Jumlah_Anak_Group, #Tunjangan_Anak_Group').hide();
            }

            $('#Id_Jabatan').change(function() {
                var jabatanId = $(this).val();
                if (jabatanId) {
                    $.ajax({
                        url: 'get_jabatan.php',
                        type: 'GET',
                        data: { id: jabatanId },
                        success: function(response) {
                            var data = JSON.parse(response);
                            $('#Gaji_Pokok').val(data.Gaji_Pokok);
                            $('#Tunjangan_Jabatan').val(data.Tunjangan_Jabatan);
                        }
                    });
                } else {
                    $('#Gaji_Pokok, #Tunjangan_Jabatan').val('');
                }
            });

            $('#Status').change(function() {
                if ($(this).val() == 'Kawin') {
                    $('#Jumlah_Anak_Group, #Tunjangan_Anak_Group').show();
                } else {
                    $('#Jumlah_Anak_Group, #Tunjangan_Anak_Group').hide();
                    $('#Jumlah_Anak').val(0);
                    $('#Tunjangan_Anak').val(0);
                }
            });

            $('#Jumlah_Anak').change(function() {
                var jumlahAnak = $(this).val();
                var gajiPokok = $('#Gaji_Pokok').val();
                var tunjanganAnak = jumlahAnak * 0.05 * gajiPokok;
                $('#Tunjangan_Anak').val(tunjanganAnak);
            });
        });
    </script>
</body>
</html>
