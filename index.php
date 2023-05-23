<?php
session_start();

if (isset($_SESSION["login_dosen"]))
  header("Location: ./dosen/");
elseif (isset($_SESSION["login_mhs"]))
  header("Location: ./mahasiswa/");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.6/dist/full.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="./css/style.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>E-Learning HIMIT</title>
</head>

<body class="bg-white overflow-x-hidden">
  <?php if (isset($_SESSION["logout_message"]) || isset($_SESSION["message"])) : ?>
    <div class="toast table z-50">
      <div class="toast-content">
        <i class="bx bx-check check"></i>
        <div class="message">
          <span class="text text-1">
            Logout Berhasil
          </span>
          <span class="text text-2 text-black">
            <?= isset($_SESSION["logout_message"]) ? $_SESSION["logout_message"] : $_SESSION["message"] ?>
          </span>
        </div>
        <i class="bx bx-x close"></i>
        <div class="progress"></div>
      </div>
    </div>
  <?php endif ?>
  <header class="fixed w-full z-30 md:bg-opacity-90 transition duration-300 ease-in-out">
    <div class="max-w-6xl mx-auto px-5 sm:px-6">
      <div class="flex items-center justify-between h-16 md:h-20">
        <div class="shrink-0 mr-4">
          <a class="block" aria-label="Cruip" href="/"><svg class="w-8 h-8" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <radialGradient cx="21.152%" cy="86.063%" fx="21.152%" fy="86.063%" r="79.941%" id="footer-logo">
                  <stop stop-color="#4FD1C5" offset="0%"></stop>
                  <stop stop-color="#81E6D9" offset="25.871%"></stop>
                  <stop stop-color="#338CF5" offset="100%"></stop>
                </radialGradient>
              </defs>
              <rect width="32" height="32" rx="16" fill="url(#footer-logo)" fill-rule="nonzero"></rect>
            </svg></a>
        </div>
        <nav class="hidden md:flex md:grow">
          <ul class="flex grow justify-end flex-wrap items-center">
            <li>
              <label for="sign-in" data-modal-target="sign-in-modal" data-modal-toggle="sign-in-modal" class="font-medium text-gray-600 hover:text-gray-900 px-5 py-3 flex items-center transition duration-150 ease-in-out rounded cursor-pointer">
                Sign In
              </label>
            </li>
            <li>
              <label for="sign-up" data-modal-target="sign-up-modal" data-modal-toggle="sign-up-modal" class="text-gray-200 bg-gray-900 hover:bg-gray-800 ml-3 px-4 py-3 cursor-pointer rounded-md transition">
                Sign Up <i class='bx bx-right-arrow-alt'></i>
              </label>
            </li>
          </ul>
        </nav>
      </div>
    </div>

  </header>
  <main class="flex flex-col justify-center items-center h-screen">
    <h1 class="text-7xl font-extrabold mb-8 text-center leading-[1.3] text-[#191919]">Selamat Datang di<br><span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-teal-400">E-Learning HIMIT</span></h1>
    <p class="text-xl text-gray-600 mb-10">Platform manajemen nilai mahasiswa HIMIT Politeknik Elektronika Negeri Surabaya</p>
    <div class="flex items-center gap-x-6">
      <img src="https://cdn-icons-png.flaticon.com/512/174/174854.png" alt="" class="w-10">
      <img src="https://cdn-icons-png.flaticon.com/512/732/732190.png" alt="" class="w-10">
      <img src="https://img.icons8.com/?size=512&id=4PiNHtUJVbLs&format=png" alt="" class="w-10">
      <img src="https://cdn-icons-png.flaticon.com/512/5968/5968332.png" alt="" class="w-10">
    </div>
  </main>

  <input type="checkbox" id="sign-up" class="modal-toggle" />
  <label for="sign-up" class="modal cursor-pointer">
    <label class="modal-box relative bg-white p-8 w-[27rem]" for="">
      <label for="sign-up" class="btn btn-sm btn-circle absolute right-4 top-4 bg-[#e1e1e1] text-[#6B7280] border-0 hover:text-[#6B7280] hover:bg-[#e1e1e1]"><i class='bx bx-x text-2xl'></i></label>
      <h2 class="font-bold text-2xl text-[#2d333a] text-center mb-6 mt-2">Sign Up</h2>
      <div class="flex flex-col gap-y-2 grow">
        <a href="./auth/register-dosen.php" class="grow text-white bg-gray-900 hover:bg-gray-800 px-6 py-4 rounded-md text-center hover:bg-gray-800 transition duration-200">Sebagai Dosen</a>
        <a href="./auth/register-mahasiswa.php" class="grow text-white bg-gray-900 hover:bg-gray-800 px-6 py-4 rounded-md text-center">Sebagai Mahasiswa</a>
      </div>
    </label>
  </label>

  <input type="checkbox" id="sign-in" class="modal-toggle" />
  <label for="sign-in" class="modal cursor-pointer">
    <label class="modal-box relative bg-white p-8 w-[27rem]" for="">
      <label for="sign-in" class="btn btn-sm btn-circle absolute right-4 top-4 bg-[#e1e1e1] text-[#6B7280] border-0 hover:text-[#6B7280] hover:bg-[#e1e1e1]"><i class='bx bx-x text-2xl'></i></label>
      <h2 class="font-bold text-2xl text-[#2d333a] text-center mb-6 mt-2">Sign In</h2>
      <div class="flex flex-col gap-y-2 grow">
        <a href="./auth/login-dosen.php" class="grow text-white bg-gray-900 hover:bg-gray-800 px-6 py-4 rounded-md text-center hover:bg-gray-800 transition duration-200">Sebagai Dosen</a>
        <a href="./auth/login-mahasiswa.php" class="grow text-white bg-gray-900 hover:bg-gray-800 px-6 py-4 rounded-md text-center">Sebagai Mahasiswa</a>
      </div>
    </label>
  </label>

  <script src="./js/main.js"></script>
  <?php if (isset($_SESSION["logout_message"]) || isset($_SESSION["message"])) : ?>
    <script>
      showToast();
    </script>
  <?php endif ?>
  <?php unset($_SESSION["logout_message"]) ?>
  <?php unset($_SESSION["message"]) ?>
</body>

</html>