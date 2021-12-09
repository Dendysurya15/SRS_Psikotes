<?php
session_start();
unset($_SESSION['kerja_soal']);
$_SESSION['kerja_soal'] = '';
header('location:login');
?>