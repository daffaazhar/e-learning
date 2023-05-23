<?php
session_start();
require "../../php/connection.php";
require "../../php/functions.php";

$nip = $_GET["nip"];
$result = deleteAccountLecturer($nip);
if ($result["status"] > 0) {
  $_SESSION["message"] = $result["result"];
  unset($_SESSION["login_dosen"]);
  header("Location: ../../index.php");
}
