<?php
session_start();
require "../../php/connection.php";
require "../../php/functions.php";

$nrp = $_GET["nrp"];
$result = deleteAccountStudent($nrp);
if ($result["status"] > 0) {
  $_SESSION["message"] = $result["result"];
  unset($_SESSION["login_mhs"]);
  header("Location: ../../index.php");
}
