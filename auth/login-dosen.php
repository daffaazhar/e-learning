<?php
session_start();
require "../php/connection.php";

if (isset($_SESSION["login_dosen"])) {
  header("Location: ../dosen/");
  exit;
}

if (isset($_POST["login"])) {
  global $conn;
  $email = $_POST["email"];
  $password = $_POST["password"];
  $result = mysqli_query($conn, "SELECT * FROM lecturer WHERE email = '$email'");
  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      $_SESSION["login_dosen"] = true;
      $_SESSION["nip"] = $row["nip"];
      header("Location: ../dosen/");
      exit;
    } else {
      $_SESSION["error_message"] = "Email atau password salah";
    }
  } else {
    $_SESSION["error_message"] = "Email tidak ditemukan";
  }
}

if (isset($_SESSION["login_dosen"])) {
  header("Location: ../dosen/");
  exit;
} elseif (isset($_SESSION["login_mhs"])) {
  header("Location: ../mahasiswa/");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../css/style.css">
  <title>HIMIT Satu Atap - Register</title>
</head>

<body class="overflow-x-hidden">
  <?php if (isset($_SESSION["message"]) || isset($_SESSION["logout_message"])) : ?>
    <div class="toast">
      <div class="toast-content">
        <i class="bx bx-check check"></i>
        <div class="message">
          <span class="text text-1">
            <?= isset($_SESSION["logout_message"]) ? "Logout berhasil" : "Akun berhasil dibuat" ?>
          </span>
          <span class="text text-2">
            <?= isset($_SESSION["logout_message"]) ? $_SESSION["logout_message"] : $_SESSION["message"] ?>
          </span>
        </div>
        <i class="bx bx-x close"></i>
        <div class="progress"></div>
      </div>
    </div>
  <?php endif ?>

  <div class="flex justify-center items-center bg-gradient-to-r from-cyan-500 to-blue-500">
    <div class="flex justify-center items-center h-screen">
      <form action="" method="POST" class="bg-white w-96 px-8 pt-8 pb-6 rounded-xl shadow-[0_10px_25px_rgba(92,99,105,0.2)]">
        <img src="../img/logo-himit.png" alt="Logo HIMIT" class="w-20">
        <h1 class="mt-2 text-3xl font-bold text-[#34364a] leading-relaxed">Login Dosen.</h1>
        <p class="text-base text-[#868686] mb-4">Yuk isi data berikut untuk masuk!</p>
        <?php if (isset($_SESSION["error_message"])) : ?>
          <div class="flex justify-center bg-red-200 border border-red-600 rounded-md py-4 mb-4 transition-all ease-in">
            <p class="text-red-600"><?= $_SESSION["error_message"] ?></p>
          </div>
        <?php endif ?>
        <div class="mb-3.5">
          <div class="relative h-[50px]">
            <input type="text" name="email" id="email" class="form__input" autocomplete="off" placeholder=" " required />
            <label for="email" class="form__label">Email</label>
          </div>
        </div>
        <div class="mb-4">
          <div class="relative h-[50px]">
            <input type="password" name="password" id="password" class="form__input" autocomplete="off" placeholder=" " required />
            <i class='eye-icon bx bx-hide absolute text-xl text-[#939393] cursor-pointer right-3 inset-y-1/4' onclick="togglePasswordVisibility('password')"></i>
            <label for="password" class="form__label">Password</label>
          </div>
        </div>
        <label class="container-checkbox mb-3.5">
          <input type="checkbox" name="remember" id="remember">
          <div class="checkmark"></div>
          <label for="remember">Ingat saya</label>
        </label>
        <div class="mb-9">
          <button type="submit" name="login" class="w-full mt-2 inline-block bg-[#2363DE] text-white px-4 py-2 rounded">Login</button>
        </div>
        <div class="flex justify-center">
          <p class="text-sm text-[#868686]">Belum punya akun? <a class="font-semibold text-[#2363DE]" href="./register-dosen.php">Daftar Disini</a></p>
        </div>
      </form>
    </div>
  </div>

  <script src="../js/main.js"></script>

  <?php if (isset($_SESSION["message"]) || isset($_SESSION["logout_message"])) : ?>
    <script>
      showToast();
    </script>
  <?php endif ?>
  <?php unset($_SESSION["message"]) ?>
  <?php unset($_SESSION["error_message"]) ?>
  <?php unset($_SESSION["logout_message"]) ?>
</body>

</html>