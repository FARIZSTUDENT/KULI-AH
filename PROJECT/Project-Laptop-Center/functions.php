<?php
/**
 * Common utility functions for the LaptoKu website
 */

// Format harga dalam rupiah
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// You can add more common functions here as needed
?>