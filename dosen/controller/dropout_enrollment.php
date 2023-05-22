<?php
session_start();
require "../../php/connection.php";
require "../../php/functions.php";

$enrollment_id = $_GET["enrollmentId"];
$result = dropEnrollment($enrollment_id);
if ($result["status"] > 0) {
  $_SESSION["message"] = $result["result"];
  header("Location: ../daftar-mahasiswa.php");
}
