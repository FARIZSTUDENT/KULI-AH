<?php
// File: cart-view.php - Halaman untuk melihat keranjang belanja

// Load common functions first
require_once 'functions.php';

// Memuat file cart.php untuk fungsi keranjang
include 'cart.php';

// Memuat data laptop untuk cek stok terbaru
include 'data/laptops.php';

// Mengambil item keranjang
$cartItems = getCartItems();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - LaptoKu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
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
                        <a class="nav-link" href="index.php">
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
                        <a class="nav-link active" href="cart-view.php">
                            <i class="fas fa-shopping-cart me-1"></i> Keranjang
                            <span class="badge bg-danger rounded-pill"><?php echo getCartCount(); ?></span>
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
    
    <!-- Konten Keranjang -->
    <div class="container my-5">
        <h2 class="mb-4">Keranjang Belanja</h2>
        
        <?php if (count($cartItems) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama']; ?>" class="img-thumbnail me-3" style="width: 80px;">
                                        <div>
                                            <h6 class="mb-0"><?php echo $item['nama']; ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo formatRupiah($item['harga']); ?></td>
                                <td>
                                    <div class="input-group" style="width: 120px;">
                                        <button class="btn btn-sm btn-outline-secondary qty-btn" data-action="decrease" data-id="<?php echo $item['id']; ?>">-</button>
                                        <input type="text" class="form-control text-center qty-input" value="<?php echo $item['qty']; ?>" data-id="<?php echo $item['id']; ?>" readonly>
                                        <button class="btn btn-sm btn-outline-secondary qty-btn" data-action="increase" data-id="<?php echo $item['id']; ?>">+</button>
                                    </div>
                                </td>
                                <td><?php echo formatRupiah($item['harga'] * $item['qty']); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-danger remove-item" data-id="<?php echo $item['id']; ?>">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total:</td>
                            <td colspan="1" class="fw-bold"><?php echo formatRupiah(getCartTotal()); ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="index.php" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Lanjutkan Belanja
                </a>
                <div>
                    <button class="btn btn-outline-danger me-2" id="clear-cart">
                        <i class="fas fa-trash me-2"></i>Kosongkan Keranjang
                    </button>
                    <a href="#" class="btn btn-success">
                        <i class="fas fa-credit-card me-2"></i>Checkout
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center p-5">
                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                <h4>Keranjang Belanja Kosong</h4>
                <p class="mb-0">Belum ada produk di keranjang belanja Anda.</p>
                <a href="index.php" class="btn btn-primary mt-3">Mulai Belanja</a>
            </div>
        <?php endif; ?>
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

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Update jumlah item
            $(".qty-btn").click(function() {
                var id = $(this).data("id");
                var action = $(this).data("action");
                var qtyInput = $(".qty-input[data-id='" + id + "']");
                var currentQty = parseInt(qtyInput.val());
                var newQty = currentQty;
                
                if (action === "increase") {
                    newQty = currentQty + 1;
                } else if (action === "decrease" && currentQty > 1) {
                    newQty = currentQty - 1;
                }
                
                if (newQty !== currentQty) {
                    updateCartItemQty(id, newQty);
                }
            });
            
            // Hapus item
            $(".remove-item").click(function() {
                var id = $(this).data("id");
                
                if (confirm("Apakah Anda yakin ingin menghapus produk ini dari keranjang?")) {
                    updateCartItemQty(id, 0); // qty 0 akan menghapus item
                }
            });
            
            // Kosongkan keranjang
            $("#clear-cart").click(function() {
                if (confirm("Apakah Anda yakin ingin mengosongkan keranjang belanja?")) {
                    $.ajax({
                        url: "cart.php",
                        type: "POST",
                        data: {
                            action: "clear"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }
            });
            
            // Fungsi untuk update jumlah item
            function updateCartItemQty(id, qty) {
                $.ajax({
                    url: "cart.php",
                    type: "POST",
                    data: {
                        action: "update",
                        id: id,
                        qty: qty
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>