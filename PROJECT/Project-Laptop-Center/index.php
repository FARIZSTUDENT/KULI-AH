<?php
// Load common functions first
require_once 'functions.php';

// Memuat file fungsi keranjang
include 'cart.php';
// Memuat data laptop dari file terpisah
include 'data/laptops.php';

// Cek apakah ada parameter id untuk detail laptop
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $laptop = null;
    
    // Cari laptop berdasarkan id
    foreach($laptops as $item) {
        if($item['id'] == $id) {
            $laptop = $item;
            break;
        }
    }
    
    // Jika laptop tidak ditemukan, redirect ke halaman utama
    if($laptop === null) {
        header('Location: index.php');
        exit;
    }
    
    // Tampilkan halaman detail
    include 'detail.php';
    exit;
}

// Removed formatRupiah function (it's now in functions.php)
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaptoKu - Toko Laptop Second Berkualitas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-laptop me-2"></i>LaptoKu
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="fas fa-home me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-info-circle me-1"></i> Tentang Kami
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-phone-alt me-1"></i> Hubungi Kami
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart-view.php">
                            <i class="fas fa-shopping-cart me-1"></i> Keranjang
                            <span class="badge bg-danger rounded-pill" id="cart-count"><?php echo getCartCount(); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://wa.me/628123456789" target="_blank">
                            <i class="fab fa-whatsapp me-1"></i> Chat WhatsApp
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Header / Banner -->
    <div class="header-banner text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold">LaptoKu</h1>
                    <p class="lead">Temukan laptop second berkualitas dengan harga terjangkau</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="#produk" class="btn btn-light btn-lg">Lihat Produk</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Produk -->
    <div class="container my-5" id="produk">
        <h2 class="text-center mb-4">Laptop Second Terbaik Kami</h2>
        
        <div class="row">
            <?php foreach($laptops as $laptop): ?>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <?php if($laptop['stok'] <= 2): ?>
                    <span class="badge bg-warning badge-stock">
                        Stok Terbatas: <?php echo $laptop['stok']; ?>
                    </span>
                    <?php endif; ?>
                    
                    <img src="<?php echo $laptop['gambar']; ?>" class="card-img-top" alt="<?php echo $laptop['nama']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $laptop['nama']; ?></h5>
                        <p class="card-text text-danger fw-bold"><?php echo formatRupiah($laptop['harga']); ?></p>
                        <p class="card-text small"><?php echo $laptop['spesifikasi']; ?></p>
                        <p class="card-text"><small class="text-muted">Kondisi: <?php echo $laptop['kondisi']; ?></small></p>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between">
                        <a href="index.php?id=<?php echo $laptop['id']; ?>" class="btn btn-primary">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                        <button class="btn btn-success add-to-cart" data-id="<?php echo $laptop['id']; ?>">
                            <i class="fas fa-cart-plus"></i> Keranjang
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Keunggulan -->
    <div class="container-fluid bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Mengapa Memilih LaptoKu?</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="feature-box p-4">
                        <i class="fas fa-check-circle fa-3x mb-3 text-primary"></i>
                        <h4>Kualitas Terjamin</h4>
                        <p>Semua laptop kami sudah melalui proses quality control yang ketat</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-box p-4">
                        <i class="fas fa-tags fa-3x mb-3 text-primary"></i>
                        <h4>Harga Bersaing</h4>
                        <p>Dapatkan laptop second berkualitas dengan harga yang sangat bersaing</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-box p-4">
                        <i class="fas fa-shield-alt fa-3x mb-3 text-primary"></i>
                        <h4>Garansi Toko</h4>
                        <p>Semua laptop mendapatkan garansi toko selama 1 bulan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5 class="mb-3">LaptoKu</h5>
                    <p>Toko laptop second terpercaya dengan pilihan berkualitas dan harga terjangkau. Kami menyediakan berbagai merk laptop second yang telah melalui proses quality control ketat.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="mb-3">Kontak Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Jl. Laptop No. 123, Kota Anda</li>
                        <li class="mb-2"><i class="fas fa-phone-alt me-2"></i> 0812-3456-789</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@laptoku.com</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="mb-3">Ikuti Kami</h5>
                    <div class="social-links">
                        <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-3 bg-light">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> LaptoKu. Semua Hak Dilindungi.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Notifikasi Toast -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="cart-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fas fa-shopping-cart me-2 text-success"></i>
                <strong class="me-auto">Keranjang Belanja</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Produk berhasil ditambahkan ke keranjang!
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Tambah ke keranjang
            $(".add-to-cart").click(function() {
                var id = $(this).data("id");
                
                $.ajax({
                    url: "cart.php",
                    type: "POST",
                    data: {
                        action: "add",
                        id: id,
                        qty: 1
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            // Update jumlah item keranjang
                            $("#cart-count").text(response.count);
                            
                            // Tampilkan notifikasi
                            var toast = new bootstrap.Toast(document.getElementById('cart-toast'));
                            toast.show();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>