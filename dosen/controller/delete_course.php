<?php
session_start();
require "../../php/connection.php";
require "../../php/functions.php";

$course_id = $_GET["courseId"];
$result = deleteCourse($course_id);
if ($result["status"] > 0) {
  $_SESSION["message"] = $result["result"];
  header("Location: ../daftar-kelas.php");
}
