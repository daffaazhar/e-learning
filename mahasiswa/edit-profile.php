<?php
session_start();
require "../php/functions.php";

if (!isset($_SESSION["login_mhs"])) {
  header("Location: ../auth/login-mahasiswa.php");
  exit;
}

$queryStudent = mysqli_query($conn, "SELECT * FROM student WHERE nrp = '{$_SESSION["nrp"]}'");
$student = mysqli_fetch_assoc($queryStudent);
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
  <link rel="stylesheet" href="../css/style.css ?>">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Dashboard Dosen</title>
</head>

<body class="scroll-smooth overflow-x-hidden">
  <?php if (isset($_SESSION["message"])) : ?>
    <div class="toast table z-50">
      <div class="toast-content">
        <i class="bx bx-check check"></i>
        <div class="message">
          <span class="text text-1">
            <?= "Sukses" ?>
          </span>
          <span class="text text-2 text-black">
            <?= $_SESSION["message"] ?>
          </span>
        </div>
        <i class="bx bx-x close"></i>
        <div class="progress"></div>
      </div>
    </div>
  <?php endif ?>
  <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 border-r border-[#edeced]" aria-label="Sidebar">
    <div class="h-full py-4 overflow-y-auto bg-gray-50">
      <div class="flex items-center pl-4 mb-6">
        <img src="../img/logo-himit.png" class="w-14 mr-3" alt="Flowbite Logo" />
        <span class="self-center text-xl font-bold whitespace-nowrap">E-Learning</span>
      </div>
      <ul class="space-y-2 font-medium">
        <li class="group relative px-6 py-3">
          <span class="absolute inset-y-0 translate-x-[-28px] w-1 bg-[#2363DE] rounded-tr-lg rounded-br-lg group-hover:translate-x-[-24px] transition-transform"></span>
          <a href="./" class="flex items-center text-gray-900 rounded-lg">
            <i class="text-2xl text-[#707275] bx bx-home group-hover:text-black transition duration-200"></i>
            <span class="text-base text-[#707275] font-semibold ml-4 group-hover:text-black transition duration-200">Dashboard</span>
          </a>
        </li>
        <li class="group relative px-6 py-3">
          <span class="absolute inset-y-0 left-0 w-1 bg-[#2363DE] rounded-tr-lg rounded-br-lg"></span>
          <a href="#" class="flex items-center text-gray-900 rounded-lg">
            <i class="text-2xl bx bx-cog"></i>
            <span class="text-base font-semibold ml-4">Edit Profil</span>
          </a>
        </li>
        <li class="group relative px-6 py-3">
          <span class="absolute inset-y-0 translate-x-[-28px] w-1 bg-[#2363DE] rounded-tr-lg rounded-br-lg group-hover:translate-x-[-24px] transition-transform"></span>
          <a href="../auth/logout-mahasiswa.php" class="flex items-center text-gray-900 rounded-lg">
            <i class="text-2xl text-[#707275] bx bx-log-out group-hover:text-black transition duration-200"></i>
            <span class="text-base text-[#707275] font-semibold ml-4 group-hover:text-black transition duration-200">Keluar</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>

  <div class="bg-[#f9fafb] p-6 sm:ml-64 h-screen">
    <div class="flex items-center justify-between mb-8">
      <h1 class="text-3xl font-semibold">Edit Profil</h1>
      <div class="flex items-center gap-x-4">
        <div class="relative rounded-full bg-white w-9 h-9 flex items-center justify-center border border-gray-200 cursor-pointer">
          <i class="text-lg text-[#6b7280] bx bx-bell"></i>
          <span class="absolute bg-red-600 rounded-full w-2 h-2 top-0 right-0"></span>
        </div>
        <div class="relative rounded-full bg-white w-9 h-9 flex items-center justify-center border border-gray-200 cursor-pointer">
          <i class="text-lg text-[#6b7280] bx bx-comment-dots"></i>
          <span class="absolute bg-red-600 rounded-full w-2 h-2 top-0 right-0"></span>
        </div>
        <form class="flex items-center">
          <label for="simple-search" class="sr-only">Search</label>
          <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <input type="text" id="simple-search" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-2.5 focus:outline-none" placeholder="Cari sesuatu di sini..." required>
          </div>
        </form>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow-[0_0_0_1px_rgba(0,0,0,0.05)] p-4">
      <form action="./controller/update_profile.php" method="POST" class="grid grid-cols-2 gap-x-12 p-4 w-[60rem]" enctype="multipart/form-data">
        <input type="hidden" name="nrp" value="<?= $student["nrp"] ?>" />
        <input type="hidden" name="oldImage" value="<?= $student["image"] ?>" />
        <div>
          <h2 class="text-lg text-[#444] font-semibold mb-1">Informasi Pribadi</h2>
          <p class="mb-6">Edit informasi pribadi Anda.</p>
          <div class="mb-3.5">
            <div class="relative h-[50px]">
              <input type="number" name="nrp" id="nrp" class="form__input" autocomplete="off" placeholder=" " value="<?= $student["nrp"] ?>" disabled />
              <label for="nrp" class="form__label">NRP</label>
            </div>
          </div>
          <div class="mb-3.5">
            <div class="relative h-[50px]">
              <input type="text" name="name" id="name" class="form__input" autocomplete="off" placeholder=" " value="<?= $student["name"] ?>" required />
              <label for="name" class="form__label">Nama Lengkap</label>
            </div>
          </div>
          <div class="relative mb-3 h-[50px]">
            <select name="major" class="form__input dropdown" required>
              <option disabled selected>-- Pilih Program Studi --</option>
              <option <?= $student["major"] == "Teknik Informatika" ? "selected" : "" ?>>Teknik Informatika</option>
              <option <?= $student["major"] == "Sains Data Terapan" ? "selected" : "" ?>>Sains Data Terapan</option>
            </select>
            <label class="form__label" for="dropdown"></label>
          </div>
          <div class="mb-6">
            <div class="relative h-[50px]">
              <input type="text" name="phone_number" id="phone_number" class="form__input" autocomplete="off" placeholder=" " value="<?= $student["phone_number"] ?>" required />
              <label for="phone_number" class="form__label">Nomor Telpon</label>
            </div>
          </div>
        </div>
        <div>
          <h2 class="text-lg text-[#444] font-semibold mb-1">Informasi Akun E-Learning</h2>
          <p class="mb-6">Edit informasi akun E-Learning Anda.</p>
          <div class="mb-3.5">
            <div class="relative h-[50px]">
              <input type="email" name="email" id="email" class="form__input" autocomplete="off" placeholder=" " value="<?= $student["email"] ?>" onblur="validateInput('email')" required />
              <label for="email" class="form__label">Email</label>
            </div>
          </div>
          <div class="">
            <label class="block text-[#6f7780] mb-3" for="image">Foto Profil</label>
            <div class="flex justify-between items-center gap-x-6">
              <img src="../img/<?= $student["image"] ?>" alt="" id="image-preview" class="w-20 h-20 rounded-full object-cover">
              <div>
                <input type="file" accept="image/png, image/jpeg, image/jpg, image/webp" name="image" id="image" class="w-full relative py-2 px-3 flex items-center text-sm border-[1.5px] border-[#c2c8d0] rounded-md cursor-pointer focus:outline-none file:float-right file:ml-4 file:bg-[#2363DE] file:border-none file:absolute file:top-0 file:-right-1 file:text-white file:h-full file:px-4 file:cursor-pointer" onchange="imagePreview()">
                <p class="mt-1 text-sm text-gray-500">PNG, JPG, atau JPEG (Max. 3 MB)</p>
              </div>
            </div>
          </div>
        </div>
        <div class="">
          <button type="submit" name="edit" id="submit-button" class="px-6 mt-2 inline-block bg-[#2363DE] text-white px-4 py-2 rounded">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
  <script src="../js/main.js"></script>
  <?php if (isset($_SESSION["message"])) : ?>
    <script>
      showToast();
    </script>
  <?php endif ?>
  <?php unset($_SESSION["message"]) ?>
</body>

</html>