<?php
function renderNavbar($activePage) {
    $navItems = [
        "Home" => "dashboard.php",
        "Karyawan" => "karyawan.php",
        "Transaksi" => "transaksi.php",
        "Logout" => "logout.php"
    ];
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Penggajian</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php foreach ($navItems as $name => $url) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $activePage === $name ? 'active' : '' ?>" href="<?= $url ?>">
                            <?= $name ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
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
    <?php
}
?>
