<?php
session_start();
require "../../php/connection.php";
require "../../php/functions.php";

if (isset($_POST["enrollmentId"]) && isset($_POST["newGrade"])) {
  $result = updateGrade($_POST);
  $_SESSION["message"] = $result["result"];
  if ($result["status"] < 0) {
    http_response_code(500); // Set response code to indicate failure
    exit("Failed to update grade");
  }
} else {
  http_response_code(400); // Set response code to indicate bad request
  exit("Invalid request parameters");
}
