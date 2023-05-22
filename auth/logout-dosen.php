<?php
session_start();
unset($_SESSION["login_dosen"]);
unset($_SESSION["nip"]);
$_SESSION["logout_message"] = "Anda telah logout";
setcookie("id", "", time() - 3600, "/");
setcookie("key", "", time() - 3600, "/");
header("Location: ./login-dosen.php");
