<?php
session_start();
require "../php/functions.php";

if (!isset($_SESSION["login_dosen"])) {
  header("Location: ../auth/login-dosen.php");
  exit;
}

$queryDosen = mysqli_query($conn, "SELECT * FROM lecturer WHERE nip = '{$_SESSION["nip"]}'");
$dosen = mysqli_fetch_assoc($queryDosen);
$enrolledStudents = query("SELECT DISTINCT s.nrp, s.name, s.image, s.major FROM enrollment e JOIN student s ON e.nrp = s.nrp JOIN course c ON e.course_id = c.course_id LEFT JOIN grade g ON e.enrollment_id = g.enrollment_id WHERE c.nip = '{$_SESSION["nip"]}';");
$courses = query("SELECT * FROM course WHERE nip = '{$_SESSION["nip"]}'");
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

<body class="scroll-smooth">
  <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 border-r border-[#edeced]" aria-label="Sidebar">
    <div class="h-full py-4 overflow-y-auto bg-gray-50">
      <div class="flex items-center pl-4 mb-6">
        <img src="../img/logo-himit.png" class="w-14 mr-3" alt="Flowbite Logo" />
        <span class="self-center text-xl font-bold whitespace-nowrap">E-Learning</span>
      </div>
      <ul class="space-y-2 font-medium">
        <li class="relative px-6 py-3">
          <span class="absolute inset-y-0 left-0 w-1 bg-[#2363DE] rounded-tr-lg rounded-br-lg"></span>
          <a href="#" class="flex items-center text-gray-900 rounded-lg">
            <i class="text-2xl bx bx-home"></i>
            <span class="text-base font-semibold ml-4">Dashboard</span>
          </a>
        </li>
        <li class="group relative px-6 py-3">
          <span class="absolute inset-y-0 translate-x-[-28px] w-1 bg-[#2363DE] rounded-tr-lg rounded-br-lg group-hover:translate-x-[-24px] transition-transform"></span>
          <a href="./daftar-kelas.php" class="flex items-center text-gray-900 rounded-lg">
            <i class="text-2xl text-[#707275] bx bx-book group-hover:text-black transition duration-200"></i>
            <span class="text-base text-[#707275] font-semibold ml-4 group-hover:text-black transition duration-200">Daftar Kelas</span>
          </a>
        </li>
        <li class="group relative px-6 py-3">
          <span class="absolute inset-y-0 translate-x-[-28px] w-1 bg-[#2363DE] rounded-tr-lg rounded-br-lg group-hover:translate-x-[-24px] transition-transform"></span>
          <a href="./daftar-mahasiswa.php" class="flex items-center text-gray-900 rounded-lg">
            <i class="text-2xl text-[#707275] bx bx-user group-hover:text-black transition duration-200"></i>
            <span class="text-base text-[#707275] font-semibold ml-4 group-hover:text-black transition duration-200">Daftar Mahasiswa</span>
          </a>
        </li>
        <li class="group relative px-6 py-3">
          <span class="absolute inset-y-0 translate-x-[-28px] w-1 bg-[#2363DE] rounded-tr-lg rounded-br-lg group-hover:translate-x-[-24px] transition-transform"></span>
          <a href="./edit-profile.php" class="flex items-center text-gray-900 rounded-lg">
            <i class="text-2xl text-[#707275] bx bx-cog group-hover:text-black transition duration-200"></i>
            <span class="text-base text-[#707275] font-semibold ml-4 group-hover:text-black transition duration-200">Edit Profil</span>
          </a>
        </li>
        <li class="group relative px-6 py-3">
          <span class="absolute inset-y-0 translate-x-[-28px] w-1 bg-[#2363DE] rounded-tr-lg rounded-br-lg group-hover:translate-x-[-24px] transition-transform"></span>
          <a href="../auth/logout-dosen.php" class="flex items-center text-gray-900 rounded-lg">
            <i class="text-2xl text-[#707275] bx bx-log-out group-hover:text-black transition duration-200"></i>
            <span class="text-base text-[#707275] font-semibold ml-4 group-hover:text-black transition duration-200">Keluar</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>

  <div class="bg-[#f9fafb] p-6 sm:ml-64 h-screen">
    <div class="flex items-center justify-between mb-8">
      <h1 class="text-3xl font-semibold">Dashboard</h1>
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

    <div class="mb-6">
      <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-[0_0_0_1px_rgba(0,0,0,0.05)]">
          <img src="../img/<?= $dosen["image"] ?>" alt="" class="w-12 h-12 rounded-full object-cover mr-4">
          <div>
            <p class="text-sm font-medium text-gray-600">
              Selamat datang,
            </p>
            <p class="text-lg font-semibold text-gray-700">
              <?= $dosen["name"] ?>
            </p>
          </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-[0_0_0_1px_rgba(0,0,0,0.05)]">
          <div class="w-12 h-12 mr-4 text-blue-500 bg-blue-100 rounded-full flex justify-center items-center">
            <i class='bx bxs-pencil text-lg'></i>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">
              Jabatan Fungsional
            </p>
            <p class="text-lg font-semibold text-gray-700">
              <?= $dosen["position"] ?>
            </p>
          </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-[0_0_0_1px_rgba(0,0,0,0.05)]">
          <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">
              Jumlah Mahasiswa
            </p>
            <p class="text-lg font-semibold text-gray-700">
              <?= count($enrolledStudents) ?>
            </p>
          </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-[0_0_0_1px_rgba(0,0,0,0.05)]">
          <div class="w-12 h-12 mr-4 text-green-500 bg-green-100 rounded-full flex justify-center items-center">
            <i class='bx bxs-chalkboard text-lg'></i>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">
              Jumlah Kelas
            </p>
            <p class="text-lg font-semibold text-gray-700">
              <?= count($courses) ?>
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-x-6">
      <div class="bg-white rounded-lg shadow-[0_0_0_1px_rgba(0,0,0,0.05)]">
        <div class="flex items-center justify-between mb-4 px-6 pt-6">
          <h2 class="font-semibold text-xl">Mahasiswa yang Diampu</h2>
          <a href="./daftar-mahasiswa.php" class="text-sm text-[#2363DE] font-semibold">Lihat semua</a>
        </div>
        <div class="overflow-hidden pb-6">
          <?php if (count($enrolledStudents) == 0) : ?>
            <p class="text-sm ml-6 text-[#4b5563]">Tidak ada mahasiswa yang dapat ditampilkan</p>
          <?php else : ?>
            <div class="w-full overflow-x-auto">
              <table class="w-full whitespace-no-wrap">
                <thead>
                  <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b">
                    <th class="pl-6 pr-4 py-3">Nama</th>
                    <th class="pl-6 pr-4 py-3">NRP</th>
                    <th class="pl-6 pr-4 py-3">Program Studi</th>
                  </tr>
                </thead>
                <tbody class="divide-y">
                  <?php foreach ($enrolledStudents as $enrolledStudent) : ?>
                    <tr class="text-gray-700">
                      <td class="pl-6 pr-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                            <img class="object-cover w-full h-full rounded-full" src="../img/<?= $enrolledStudent["image"] ?>" alt="" loading="lazy" />
                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                          </div>
                          <p class="font-semibold"><?= $enrolledStudent["name"] ?></p>
                        </div>
                      </td>
                      <td class="pl-6 pr-4 py-3 text-sm"><?= $enrolledStudent["nrp"] ?></td>
                      <td class="pl-6 pr-4 py-3 text-sm"><?= $enrolledStudent["major"] ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          <?php endif ?>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow-[0_0_0_1px_rgba(0,0,0,0.05)] p-6">
        <div class="flex items-center justify-between mb-4">
          <h2 class="font-semibold text-xl">Kelas yang Diampu</h2>
          <a href="./daftar-kelas.php" class="text-sm text-[#2363DE] font-semibold">Lihat semua</a>
        </div>
        <div class="flex flex-wrap gap-4">
          <?php if (count($courses) == 0) : ?>
            <p class="text-sm text-[#4b5563]">Tidak ada kelas yang dapat ditampilkan</p>
          <?php else : ?>
            <?php foreach ($courses as $course) : ?>
              <a href="#" class="group flex items-center grow gap-x-6 px-5 py-3 bg-white rounded-lg shadow-[0_0_0_1px_rgba(0,0,0,0.05)] hover:bg-[#2363DE] transition duration-200">
                <div>
                  <p class="text-base font-semibold text-gray-700 mb-1 group-hover:text-white"><?= $course["course_name"] ?></p>
                  <p class="text-sm text-gray-600 group-hover:text-white">Jumlah SKS: <?= $course["sks"] ?></p>
                </div>
              </a>
            <?php endforeach ?>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>

</html>