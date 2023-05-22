<?php
session_start();
require "../php/connection.php";
require "../php/functions.php";

if (isset($_SESSION["login_mhs"])) {
  header("Location: ../mahasiswa/");
  exit;
}

if (isset($_POST["register"])) {
  $result = registrationStudent($_POST);
  if ($result["status"] > 0) {
    $_SESSION["message"] = $result["result"];
    header("Location: ./login-mahasiswa.php");
  } else
    $_SESSION["error_message"] = $result["result"];
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
  <?php if (isset($_SESSION["error_message"])) : ?>
    <div class="toast-warning">
      <div class="toast-content">
        <i class='bx bx-x warning'></i>
        <div class="message">
          <span class="text text-1">Registrasi Gagal</span>
          <span class="text text-2"><?= $_SESSION["error_message"] ?></span>
        </div>
        <i class="bx bx-x close"></i>
        <div class="progress-warning"></div>
      </div>
    </div>
  <?php endif ?>

  <div class="flex justify-center items-center bg-gradient-to-r from-cyan-500 to-blue-500">
    <div class="flex justify-center py-14">
      <form action="" method="POST" class="bg-white w-[30rem] px-8 pt-8 pb-6 rounded-xl shadow-[0_10px_25px_rgba(92,99,105,0.2)]" enctype="multipart/form-data">
        <img src="../img/logo-himit.png" alt="Logo HIMIT" class="w-20">
        <h1 class="mt-2 text-3xl font-bold text-[#34364a] leading-relaxed">Buat Akun Mahasiswa.</h1>
        <p class="text-base text-[#868686] mb-6">Yuk isi data berikut untuk menjadi mahasiswa!</p>
        <div class="mb-3.5">
          <div class="relative h-[50px]">
            <input type="text" name="nrp" id="nrp" class="form__input" autocomplete="off" placeholder=" " required />
            <label for="nrp" class="form__label">NRP</label>
          </div>
        </div>
        <div class="mb-3.5">
          <div class="relative h-[50px]">
            <input type="text" name="name" id="name" class="form__input" autocomplete="off" placeholder=" " required />
            <label for="name" class="form__label">Nama Lengkap</label>
          </div>
        </div>
        <div class="mb-3.5">
          <div class="relative h-[50px]">
            <input type="email" name="email" id="email" class="form__input" autocomplete="off" placeholder=" " onblur="validateInput('email')" required />
            <label for="email" class="form__label">Email</label>
          </div>
          <div id="email-message"></div>
        </div>
        <div class="relative mb-3 h-[50px]">
          <select id="dropdown" name="major" class="form__input" required>
            <option disabled selected>-- Pilih Jurusan --</option>
            <option>Teknik Informatika</option>
            <option>Sains Data Terapan</option>
          </select>
          <label class="form__label" for="dropdown"></label>
        </div>
        <div class="mb-3.5">
          <div class="relative h-[50px]">
            <input type="text" name="phone_number" id="phone_number" class="form__input" autocomplete="off" placeholder=" " required />
            <label for="phone_number" class="form__label">Nomor Telpon</label>
          </div>
        </div>
        <div class="mb-3.5">
          <div class="relative h-[50px]">
            <input type="password" name="password" id="password" class="form__input" autocomplete="off" placeholder=" " onblur="validateInput('password')" required />
            <i class='eye-icon bx bx-hide absolute text-xl text-[#939393] cursor-pointer right-3 inset-y-1/4' onclick="togglePasswordVisibility('password')"></i>
            <label for="password" class="form__label">Password</label>
          </div>
        </div>
        <div class="mb-6">
          <label class="block text-[#6f7780] mb-3" for="image">Foto Profil</label>
          <div class="flex justify-between items-center gap-x-6">
            <img src="../img/avatar-placeholder.jpeg" alt="" id="image-preview" class="w-20 h-20 rounded-full object-cover">
            <div>
              <input type="file" accept="image/png, image/jpeg, image/jpg, image/webp" name="image" id="image" class="w-full relative py-2 px-3 flex items-center text-sm border-[1.5px] border-[#c2c8d0] rounded-md cursor-pointer focus:outline-none file:float-right file:ml-4 file:bg-[#2363DE] file:border-none file:absolute file:top-0 file:-right-1 file:text-white file:h-full file:px-4 file:cursor-pointer" onchange="imagePreview()">
              <p class="mt-1 text-sm text-gray-500">PNG, JPG, atau JPEG (Max. 3 MB)</p>
            </div>
          </div>
        </div>
        <div class="mb-9">
          <button type="submit" name="register" id="submit-button" class="w-full mt-2 inline-block bg-[#2363DE] text-white px-4 py-2 rounded">Daftar</button>
        </div>
        <div class="flex justify-center">
          <p class="text-sm text-[#868686]">Sudah punya akun? <a class="font-semibold text-[#2363DE]" href="./login-mahasiswa.php">Login Disini</a></p>
        </div>
      </form>
    </div>
  </div>

  <script src="../js/main.js"></script>
  <?php if (isset($_SESSION["error_message"])) : ?>
    <script>
      showToast();
    </script>
  <?php endif ?>
  <?php unset($_SESSION["error_message"]) ?>
</body>

</html>