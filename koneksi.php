<?php
$server = "localhost";
$user = "root";
$password = "";
$nama_db = "db_librec";

$db = mysqli_connect($server, $user, $password, $nama_db);

if (!$db) {
    die("Gagal terhubung" . mysqli_connect_error());
}
