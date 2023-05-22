<?php
session_start();
require "../../php/functions.php";

if (isset($_POST["edit"])) {
  $result = editDataLecturer($_POST);
  if ($result["status"] >= 0) {
    $_SESSION["message"] = $result["result"];
    header("Location: ../edit-profile.php");
  }
}
