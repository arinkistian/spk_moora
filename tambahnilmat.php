<?php
//koneksi
session_start();
include("koneksi.php");

$id_alter   = $_POST['altern'];
$id_krit   = $_POST['krit'];
$nilai_kr = $_POST['nilai_kr'];

$tambah = $koneksi->query('SELECT * FROM tab_topsis');

if ($row = $tambah->fetch_row()) {

  $masuk = "INSERT INTO tab_topsis VALUES ('".$id_alter."','".$id_krit."','".$nilai_kr."')";
  $buat  = $koneksi->query($masuk);

  echo "<script>alert('Input Data Berhasil') </script>";
  echo "<script>window.location.href = \"nilmat.php\" </script>";
}

 ?>
