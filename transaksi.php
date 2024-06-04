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

function generateTransactionID($conn) {
    $sql = "SELECT COUNT(*) AS count FROM tbl_gaji";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $count = $row['count'] + 1;
    $transaction_id = "TR-" . str_pad($count, 2, "0", STR_PAD_LEFT) . "-" . date("m") . "-" . date("Y");
    return $transaction_id;
}

$transaction_id = generateTransactionID($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Gaji</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .navbar-nav .nav-item .nav-link.active {
            background-color: #007bff;
            color: white;
        }
        .navbar-nav .nav-item .nav-link:hover {
            background-color: #0056b3;
            color: white;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#Nama_Karyawan').change(function() {
                var karyawan_id = $(this).val();
                if (karyawan_id) {
                    $.ajax({
                        type: 'POST',
                        url: 'get_karyawan_data.php',
                        data: 'karyawan_id=' + karyawan_id,
                        success: function(data) {
                            var karyawanData = JSON.parse(data);
                            $('#Jabatan').val(karyawanData.Nama_Jabatan);
                            $('#Gaji_Pokok').val(karyawanData.Gaji_Pokok);
                            $('#Tunjangan_Jabatan').val(karyawanData.Tunjangan_Jabatan);
                            $('#Status').val(karyawanData.Status);
                            $('#Jumlah_Anak').val(karyawanData.Jumlah_Anak);
                            $('#Tunjangan_Anak').val(karyawanData.Tunjangan_Anak);
                            $('#BPJS').val(karyawanData.BPJS);
                            $('#PPh21').val(karyawanData.PPh21);
                            calculateGajiBersih();
                        }
                    });
                }
            });

            function calculateGajiBersih() {
                var gaji_pokok = parseFloat($('#Gaji_Pokok').val()) || 0;
                var tunjangan_jabatan = parseFloat($('#Tunjangan_Jabatan').val()) || 0;
                var tunjangan_anak = parseFloat($('#Tunjangan_Anak').val()) || 0;
                var bpjs = gaji_pokok * 0.04;
                var pph21 = gaji_pokok * 0.02;
                var total_pendapatan = gaji_pokok + tunjangan_jabatan + tunjangan_anak;
                var total_potongan = bpjs + pph21;
                var gaji_bersih = total_pendapatan - total_potongan;

                $('#BPJS').val(bpjs.toFixed(2));
                $('#PPh21').val(pph21.toFixed(2));
                $('#Total_Pendapatan').val(total_pendapatan.toFixed(2));
                $('#Total_Potongan').val(total_potongan.toFixed(2));
                $('#Gaji_Bersih').val(gaji_bersih.toFixed(2));
            }

            $('#Jumlah_Anak').change(function() {
                var jumlah_anak = $(this).val();
                var gaji_pokok = parseFloat($('#Gaji_Pokok').val()) || 0;
                var tunjangan_anak = jumlah_anak * 0.05 * gaji_pokok;
                $('#Tunjangan_Anak').val(tunjangan_anak.toFixed(2));
                calculateGajiBersih();
            });

            $('#Status').change(function() {
                if ($(this).val() === "Kawin") {
                    $('#Jumlah_Anak').prop('readonly', false);
                } else {
                    $('#Jumlah_Anak').prop('readonly', true).val(0);
                    $('#Tunjangan_Anak').val(0);
                    calculateGajiBersih();
                }
            });
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Penggajian</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="karyawan.php">Karyawan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="transaksi.php">Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Transaksi Gaji</h1>
        <form action="save_transaksi.php" method="post">
            <div class="form-group">
                <label for="ID_Gaji">ID Gaji</label>
                <input type="text" class="form-control" id="ID_Gaji" name="ID_Gaji" value="<?php echo $transaction_id; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="Tanggal">Tanggal</label>
                <input type="date" class="form-control" id="Tanggal" name="Tanggal" required>
            </div>
            <div class="form-group">
                <label for="Nama_Karyawan">Nama Karyawan</label>
                <select class="form-control" id="Nama_Karyawan" name="Nama_Karyawan" required>
                    <option value="">Pilih Nama Karyawan</option>
                    <?php
                    $sql = "SELECT id, Nama FROM tbl_karyawan";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['Nama']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Jabatan">Jabatan</label>
                <input type="text" class="form-control" id="Jabatan" name="Jabatan" readonly>
            </div>
            <div class="form-group">
                <label for="Gaji_Pokok">Gaji Pokok</label>
                <input type="text" class="form-control" id="Gaji_Pokok" name="Gaji_Pokok" readonly>
            </div>
            <div class="form-group">
                <label for="Tunjangan_Jabatan">Tunjangan Jabatan</label>
                <input type="text" class="form-control" id="Tunjangan_Jabatan" name="Tunjangan_Jabatan" readonly>
            </div>
            <div class="form-group">
                <label for="Status">Status</label>
                <input type="text" class="form-control" id="Status" name="Status" readonly>
            </div>
            <div class="form-group">
                <label for="Jumlah_Anak">Jumlah Anak</label>
                <input type="text" class="form-control" id="Jumlah_Anak" name="Jumlah_Anak" readonly>
            </div>
            <div class="form-group">
                <label for="Tunjangan_Anak">Tunjangan Anak</label>
                <input type="text" class="form-control" id="Tunjangan_Anak" name="Tunjangan_Anak" readonly>
            </div>
            <div class="form-group">
                <label for="BPJS">BPJS</label>
                <input type="text" class="form-control" id="BPJS" name="BPJS" readonly>
            </div>
            <div class="form-group">
                <label for="PPh21">PPh21</label>
                <input type="text" class="form-control" id="PPh21" name="PPh21" readonly>
            </div>
            <div class="form-group">
                <label for="Total_Pendapatan">Total Pendapatan</label>
                <input type="text" class="form-control" id="Total_Pendapatan" name="Total_Pendapatan" readonly>
            </div>
            <div class="form-group">
                <label for="Total_Potongan">Total Potongan</label>
                <input type="text" class="form-control" id="Total_Potongan" name="Total_Potongan" readonly>
            </div>
            <div class="form-group">
                <label for="Gaji_Bersih">Gaji Bersih</label>
                <input type="text" class="form-control" id="Gaji_Bersih" name="Gaji_Bersih" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="dashboard.php" class="btn btn-secondary">Close</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
