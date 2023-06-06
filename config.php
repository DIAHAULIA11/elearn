<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_uas";

$koneksi = mysqli_connect($host, $user, $pass, $db) or die("Error connecting to mysql");

if (!$koneksi) {
    die("Koneksi Gagal : " . mysqli_connect_errno());
}
