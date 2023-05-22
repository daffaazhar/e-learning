<?php
require "connection.php";

function query($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function upload()
{
  $fileName = $_FILES["image"]["name"];
  $fileSize = $_FILES["image"]["size"];
  $error = $_FILES["image"]["error"];
  $tmpName = $_FILES["image"]["tmp_name"];
  $validExt = ['jpg', 'jpeg', 'png'];
  $tmp = explode(".", $fileName);
  $fileExt = strtolower(end($tmp));

  if ($error === 4)
    throw new Exception("Upload file gambar terlebih dahulu.");

  if (!in_array($fileExt, $validExt))
    throw new Exception("File gambar harus berekstensi jpg, jpeg, atau png.");

  if ($fileSize > 3145728)
    throw new Exception("Ukuran gambar tidak boleh melebihi 3 MB.");

  $newFileName = uniqid();
  $newFileName .= ".";
  $newFileName .= $fileExt;

  move_uploaded_file($tmpName, "../img/" . $newFileName);
  return $newFileName;
}

function registrationLecturer($data)
{
  global $conn;
  $nip = htmlspecialchars($data["nip"]);
  $name = htmlspecialchars($data["name"]);
  $email = htmlspecialchars($data["email"]);
  $position = htmlspecialchars($data["position"]);
  $phone_number = htmlspecialchars($data["phone_number"]);
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password = password_hash($password, PASSWORD_DEFAULT);

  // Cek apakah ada dosen yang telah terdaftar
  $userRegistered = mysqli_query($conn, "SELECT * FROM lecturer WHERE nip = '$nip' OR name = '$name' OR email = '$email'");
  if (mysqli_num_rows($userRegistered) > 0)
    return array("status" => -1, "result" => "Dosen telah terdaftar");

  try {
    $image = upload();
  } catch (Exception $e) {
    return array("status" => -1, "result" => $e->getMessage());
  }

  // Memasukkan data dosen ke tabel lecturer
  mysqli_query($conn, "INSERT INTO lecturer (nip, email, password, name, position, phone_number, image) VALUES('$nip', '$email', '$password', '$name', '$position', '$phone_number', '$image')");

  return array("status" => mysqli_affected_rows($conn), "result" => "Silakan lakukan login untuk melanjutkan");
}

function registrationStudent($data)
{
  global $conn;
  $nrp = htmlspecialchars($data["nrp"]);
  $name = htmlspecialchars($data["name"]);
  $email = htmlspecialchars($data["email"]);
  $major = htmlspecialchars($data["major"]);
  $phone_number = htmlspecialchars($data["phone_number"]);
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password = password_hash($password, PASSWORD_DEFAULT);

  // Cek apakah ada mahasiswa yang telah terdaftar
  $userRegistered = mysqli_query($conn, "SELECT * FROM student WHERE nrp = '$nrp' OR name = '$name' OR email = '$email'");
  if (mysqli_num_rows($userRegistered) > 0)
    return array("status" => -1, "result" => "Mahasiswa telah terdaftar");

  try {
    $image = upload();
  } catch (Exception $e) {
    return array("status" => -1, "result" => $e->getMessage());
  }

  // Memasukkan data dosen ke tabel student
  mysqli_query($conn, "INSERT INTO student (nrp, email, password, name, major, phone_number, image) VALUES('$nrp', '$email', '$password', '$name', '$major', '$phone_number', '$image')");

  return array("status" => mysqli_affected_rows($conn), "result" => "Silakan lakukan login untuk melanjutkan");
}

function editDataStudent($data)
{
  global $conn;
  $nrp = htmlspecialchars($data["nrp"]);
  $name = htmlspecialchars($data["name"]);
  $email = htmlspecialchars($data["email"]);
  $major = htmlspecialchars($data["major"]);
  $phone_number = htmlspecialchars($data["phone_number"]);
  $old_image = htmlspecialchars($data["oldImage"]);

  if ($_FILES["image"]["error"] === 4) {
    $image = $old_image;
  } else {
    try {
      $image = upload();
    } catch (Exception $e) {
      return array("status" => -1, "result" => $e->getMessage());
    }
  }

  $query = "UPDATE student SET name = '$name', major = '$major', email = '$email', phone_number = '$phone_number', image = '$image' WHERE nrp = '$nrp'";
  mysqli_query($conn, $query);

  return array("status" => mysqli_affected_rows($conn), "result" => "Data berhasil diubah");
}

function editDataLecturer($data)
{
  global $conn;
  $nip = htmlspecialchars($data["nip"]);
  $name = htmlspecialchars($data["name"]);
  $email = htmlspecialchars($data["email"]);
  $position = htmlspecialchars($data["position"]);
  $phone_number = htmlspecialchars($data["phone_number"]);
  $old_image = htmlspecialchars($data["oldImage"]);

  if ($_FILES["image"]["error"] === 4) {
    $image = $old_image;
  } else {
    try {
      $image = upload();
    } catch (Exception $e) {
      return array("status" => -1, "result" => $e->getMessage());
    }
  }

  $query = "UPDATE lecturer SET name = '$name', position = '$position', email = '$email', phone_number = '$phone_number', image = '$image' WHERE nip = '$nip'";
  mysqli_query($conn, $query);

  return array("status" => mysqli_affected_rows($conn), "result" => "Data berhasil diubah");
}

function createCourse($data)
{
  global $conn;
  $nip = $_SESSION["nip"];
  $course_name = htmlspecialchars($data["course_name"]);
  $sks = $data["sks"];

  mysqli_query($conn, "INSERT INTO course (course_id, course_name, nip, sks) VALUES (null, '$course_name', '$nip', $sks)");

  return array("status" => mysqli_affected_rows($conn), "result" => "Kelas berhasil ditambahkan");
}

function enrollCourse($data)
{
  global $conn;
  $id_course = $data["id"];
  $nrp = $data["nrp"];
  $grade = $data["grade"];
  $enrollment_date = date("Y-m-d H:i:s");

  $query = "INSERT INTO enrollment(enrollment_id, nrp, course_id, enrollment_date) VALUES (null, '$nrp', $id_course, '$enrollment_date');";
  $query .= "INSERT INTO grade(grade_id, enrollment_id, grade_value) VALUES (null, LAST_INSERT_ID(), $grade)";

  if (mysqli_multi_query($conn, $query)) {
    // Loop through the result sets to free them
    while (mysqli_next_result($conn)) {
    }
    return array("status" => mysqli_affected_rows($conn), "result" => "Mahasiswa berhasil di-enroll");
  } else {
    return array("status" => -1, "result" => mysqli_error($conn));
  }

  return array("status" => mysqli_affected_rows($conn), "result" => "Mahasiswa berhasil di-enroll");
}

function updateGrade($data)
{
  global $conn;
  $enrollment_id = $data["enrollmentId"];
  $newGrade = $data["newGrade"];

  mysqli_query($conn, "UPDATE grade SET grade_value = $newGrade WHERE enrollment_id = '{$enrollment_id}'");

  return array("status" => mysqli_affected_rows($conn), "result" => "Nilai berhasil diubah");
}

function dropEnrollment($enrollment_id)
{
  global $conn;

  mysqli_query($conn, "DELETE FROM enrollment WHERE enrollment_id = '$enrollment_id'");

  return array("status" => mysqli_affected_rows($conn), "result" => "Mahasiswa berhasil di-drop out");
}

function deleteCourse($course_id)
{
  global $conn;

  mysqli_query($conn, "DELETE FROM course WHERE course_id = '$course_id'");

  return array("status" => mysqli_affected_rows($conn), "result" => "Kelas berhasil dihapus");
}
