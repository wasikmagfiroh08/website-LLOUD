<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Detail koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "LLOUD";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan data POST ada
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    die("Harap isi email dan password.");
}

// Ambil data formulir
$email = $_POST['email'];
$password = $_POST['password'];

// Cegah SQL Injection
$email = $conn->real_escape_string($email);

// Query SQL untuk memeriksa apakah pengguna ada
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

// Pemeriksaan kesalahan query
if (!$result) {
    die("Error in query: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Ambil data pengguna
    $user = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Password benar, mulai sesi
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];

        // Alihkan ke halaman landing
        header("Location: landing.html");
        exit();
   
    }}

$conn->close();
?>
