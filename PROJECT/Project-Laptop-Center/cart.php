<?php
// File: cart.php - File untuk mengelola keranjang belanja

// Load common functions
require_once 'functions.php';

// Mulai session jika belum dimulai
session_start();

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fungsi untuk menambahkan item ke keranjang
function addToCart($id, $qty = 1) {
    // Memuat data laptop
    include 'data/laptops.php';
    
    // Cari laptop berdasarkan id
    $laptop = null;
    foreach ($laptops as $item) {
        if ($item['id'] == $id) {
            $laptop = $item;
            break;
        }
    }
    
    // Jika laptop ditemukan
    if ($laptop) {
        // Cek apakah produk sudah ada di keranjang
        if (isset($_SESSION['cart'][$id])) {
            // Update jumlah jika stok mencukupi
            $newQty = $_SESSION['cart'][$id]['qty'] + $qty;
            if ($newQty <= $laptop['stok']) {
                $_SESSION['cart'][$id]['qty'] = $newQty;
            }
        } else {
            // Tambahkan produk baru ke keranjang jika stok mencukupi
            if ($qty <= $laptop['stok']) {
                $_SESSION['cart'][$id] = [
                    'id' => $laptop['id'],
                    'nama' => $laptop['nama'],
                    'harga' => $laptop['harga'],
                    'gambar' => $laptop['gambar'],
                    'qty' => $qty
                ];
            }
        }
        return true;
    }
    return false;
}

// Fungsi untuk mengupdate jumlah item
function updateCartItem($id, $qty) {
    // Memuat data laptop untuk cek stok
    include 'data/laptops.php';
    
    // Cari laptop berdasarkan id untuk cek stok
    $laptop = null;
    foreach ($laptops as $item) {
        if ($item['id'] == $id) {
            $laptop = $item;
            break;
        }
    }
    
    // Update jumlah jika stok mencukupi
    if ($laptop && $qty <= $laptop['stok'] && $qty > 0) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] = $qty;
            return true;
        }
    } else if ($qty == 0) {
        // Hapus item jika qty 0
        return removeCartItem($id);
    }
    return false;
}

// Fungsi untuk menghapus item dari keranjang
function removeCartItem($id) {
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
        return true;
    }
    return false;
}

// Fungsi untuk menghitung total harga keranjang
function getCartTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['harga'] * $item['qty'];
    }
    return $total;
}

// Fungsi untuk mendapatkan jumlah item di keranjang
function getCartCount() {
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['qty'];
    }
    return $count;
}

// Fungsi untuk mendapatkan semua item di keranjang
function getCartItems() {
    return $_SESSION['cart'];
}

// Fungsi untuk mengosongkan keranjang
function clearCart() {
    $_SESSION['cart'] = [];
    return true;
}

// Removed formatRupiah function as it's now in functions.php

// Handle AJAX request
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $response = ['success' => false, 'message' => '', 'count' => 0];
    
    switch ($action) {
        case 'add':
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
            
            if (addToCart($id, $qty)) {
                $response['success'] = true;
                $response['message'] = 'Produk berhasil ditambahkan ke keranjang';
                $response['count'] = getCartCount();
            } else {
                $response['message'] = 'Gagal menambahkan produk ke keranjang';
            }
            break;
            
        case 'update':
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
            
            if (updateCartItem($id, $qty)) {
                $response['success'] = true;
                $response['message'] = 'Keranjang berhasil diperbarui';
                $response['count'] = getCartCount();
            } else {
                $response['message'] = 'Gagal memperbarui keranjang';
            }
            break;
            
        case 'remove':
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            
            if (removeCartItem($id)) {
                $response['success'] = true;
                $response['message'] = 'Produk berhasil dihapus dari keranjang';
                $response['count'] = getCartCount();
            } else {
                $response['message'] = 'Gagal menghapus produk dari keranjang';
            }
            break;
            
        case 'clear':
            if (clearCart()) {
                $response['success'] = true;
                $response['message'] = 'Keranjang berhasil dikosongkan';
                $response['count'] = 0;
            } else {
                $response['message'] = 'Gagal mengosongkan keranjang';
            }
            break;
    }
    
    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}