<?php
session_start();
require "../php/connection.php";
require "../php/functions.php";

if (!isset($_SESSION["login_dosen"])) {
  header("Location: ..auth/login-dosen.php");
  exit;
}

if (isset($_POST["submit"])) {
  $result = enrollCourse($_POST);
  if ($result["status"] > 0)
    $_SESSION["message"] = $result["result"];
  else
    echo "<script>alert('Mahasiswa gagal di-enroll')</script>";
}

$courses = query("SELECT * FROM course WHERE nip = '{$_SESSION["nip"]}'");
$students = query("SELECT * FROM student");
$enrolledStudents = query("SELECT * FROM enrollment e JOIN student s ON e.nrp = s.nrp JOIN course c ON e.course_id = c.course_id LEFT JOIN grade g ON e.enrollment_id = g.enrollment_id WHERE c.nip = '{$_SESSION["nip"]}';");
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
  <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.6/dist/full.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../css/style.css ?>">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Buat Kelas</title>
</head>

<body class="overflow-x-hidden">
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
        <span class="self-center text-xl text-black font-bold whitespace-nowrap">E-Learning</span>
      </div>
      <ul class="space-y-2 font-medium">
        <li class="group relative px-6 py-3">
          <span class="absolute inset-y-0 translate-x-[-28px] w-1 bg-[#2363DE] rounded-tr-lg rounded-br-lg group-hover:translate-x-[-24px] transition-transform"></span>
          <a href="./index.php" class="flex items-center text-gray-900 rounded-lg">
            <i class="text-2xl text-[#707275] bx bx-home group-hover:text-black transition duration-200"></i>
            <span class="text-base text-[#707275] font-semibold ml-4 group-hover:text-black transition duration-200">Dashboard</span>
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
          <span class="absolute inset-y-0 left-0 w-1 bg-[#2363DE] rounded-tr-lg rounded-br-lg"></span>
          <a href="#" class="flex items-center text-gray-900 rounded-lg">
            <i class="text-2xl bx bx-user"></i>
            <span class="text-base font-semibold ml-4 group-hover:text-black transition duration-200">Daftar Mahasiswa</span>
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
  <div class="bg-[#f9fafb] p-6 sm:ml-64 h-screen z-0">
    <div class="flex items-center justify-between mb-8">
      <div class="flex items-center">
        <h1 class="text-3xl font-semibold text-black">Daftar Mahasiswa yang Diampu</h1>
        <label for="enroll-student" data-modal-target="enroll-student-modal" data-modal-toggle="enroll-student-modal" class="group ml-4 w-9 h-9 flex items-center justify-center bg-white border border-gray-200 cursor-pointer rounded-full hover:bg-[#2363DE] transition">
          <i class='bx bx-plus group-hover:text-white transition text-black'></i>
        </label>
      </div>
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
    <div class="mb-8">
      <div class="overflow-hidden rounded-lg shadow-[0_0_0_1px_rgba(0,0,0,.05)]">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap bg-white">
            <thead>
              <tr class="text-sm font-semibold text-left text-gray-500 uppercase border-b">
                <th class="px-4 py-3">NRP</th>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Kelas</th>
                <th class="px-4 py-3">Nilai</th>
                <th class="px-4 py-3 w-[120px]">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              <?php if (count($enrolledStudents) == 0) : ?>
                <tr class="text-gray-700">
                  <td colspan="4" class="text-center py-4">Sepertinya belum ada data yang dapat ditampilkan. Coba untuk tambahkan data terlebih dahulu.</td>
                </tr>
              <?php else : ?>
                <?php foreach ($enrolledStudents as $enrolledStudent) : ?>
                  <tr class="text-gray-700">
                    <td class="px-4 py-3"><?= $enrolledStudent["nrp"] ?></td>
                    <td class="px-4 py-3"><?= $enrolledStudent["name"] ?></td>
                    <td class="px-4 py-3"><?= $enrolledStudent["course_name"] ?></td>
                    <td class="px-4 py-3 flex items-center gap-x-2 mt-1.5 w-[100px]">
                      <span id="gradeSpan_<?= $enrolledStudent['enrollment_id'] ?>"><?= $enrolledStudent["grade_value"] ?></span>
                      <i class='bx bxs-pencil text-sm text-[#6b7280]' onclick="editGrade(<?= $enrolledStudent['enrollment_id'] ?>)"></i>
                    </td>
                    <td class="px-4 py-3 w-[120px]">
                      <a class='w-full' href="./controller/dropout_enrollment.php?enrollmentId=<?= $enrolledStudent["enrollment_id"] ?>" onclick="return confirm('Apakah Anda yakin ingin melakukan drop out mahasiswa ini?')">
                        <div class="bg-red-600 rounded p-1 flex justify-center items-center">
                          <i class='bx bxs-trash text-white text-lg'></i>
                        </div>
                      </a>
                    </td>
                  </tr>
                <?php endforeach ?>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <input type="checkbox" id="enroll-student" class="modal-toggle" />
  <label for="enroll-student" class="modal cursor-pointer">
    <label class="modal-box relative bg-white w-[32rem] p-8" for="">
      <label for="enroll-student" class="btn btn-sm btn-circle absolute right-4 top-4 bg-[#e1e1e1] text-[#6B7280] border-0 hover:text-[#6B7280] hover:bg-[#e1e1e1]"><i class='bx bx-x text-2xl'></i></label>
      <h3 class="font-bold text-2xl text-[#2d333a] text-center mb-1 mt-2">Enroll Mahasiswa</h3>
      <p class="text-[#2d333a] mb-6 text-center">Isi kolom untuk memasukkan mahasiswa ke dalam kelas</p>
      <form class="relative" action="" method="POST">
        <div class="relative mb-3 h-[50px]">
          <select id="dropdown1" name="id" class="form__input dropdown" required>
            <option disabled selected>-- Pilih Kelas --</option>
            <?php foreach ($courses as $course) : ?>
              <option value="<?= $course["course_id"] ?>"><?= $course["course_id"] ?> - <?= $course["course_name"] ?></option>
            <?php endforeach ?>
          </select>
          <label class="form__label" for="dropdown"></label>
        </div>
        <div class="relative mb-3 h-[50px]">
          <select id="dropdown2" name="nrp" class="form__input dropdown" required>
            <option disabled selected>-- Pilih Mahasiswa --</option>
            <?php foreach ($students as $student) : ?>
              <option value="<?= $student["nrp"] ?>"><?= $student["nrp"] ?> - <?= $student["name"] ?></option>
            <?php endforeach ?>
          </select>
          <label class="form__label" for="dropdown"></label>
        </div>
        <div class="relative mb-4 h-[50px]">
          <input id="grade" class="form__input" name="grade" type="number" min="0" max="100" autocomplete="off" placeholder=" " required />
          <label class="form__label" for="grade">Nilai</label>
        </div>

        <button type="submit" name="submit" class="w-full inline-block bg-[#2363DE] text-white px-4 py-2 rounded">Tambah</button>
      </form>
    </label>
  </label>

  <script src="../js/main.js"></script>
  <?php if (isset($_SESSION["message"])) : ?>
    <script>
      showToast();
    </script>
  <?php endif ?>
  <?php unset($_SESSION["message"]) ?>
</body>

</html>