function setFont(event) {
  const dropdown = event.target;
  dropdown.style.color = "#000000";
  dropdown.removeEventListener("click", setFont);
}

const dropdowns = document.querySelectorAll(".dropdown");
for (let i = 0; i < dropdowns.length; i++) {
  const dropdown = dropdowns[i];
  dropdown.addEventListener("click", setFont);
}

function showToast() {
  const currentLocation = window.location.href;
  const toastClass =
    currentLocation == "http://localhost/e-learning/auth/login-dosen.php" ||
    currentLocation == "http://localhost/e-learning/dosen/daftar-kelas.php" ||
    currentLocation == "http://localhost/e-learning/auth/login-mahasiswa.php" ||
    currentLocation == "http://localhost/e-learning/dosen/daftar-mahasiswa.php" ||
    currentLocation == "http://localhost/e-learning/mahasiswa/edit-profile.php" ||
    currentLocation == "http://localhost/e-learning/dosen/edit-profile.php" ||
    currentLocation == "http://localhost/e-learning/index.php"
      ? ".toast"
      : ".toast-warning";
  const progressClass =
    currentLocation == "http://localhost/e-learning/auth/login-dosen.php" ||
    currentLocation == "http://localhost/e-learning/dosen/daftar-kelas.php" ||
    currentLocation == "http://localhost/e-learning/auth/login-mahasiswa.php" ||
    currentLocation == "http://localhost/e-learning/dosen/daftar-mahasiswa.php" ||
    currentLocation == "http://localhost/e-learning/mahasiswa/edit-profile.php" ||
    currentLocation == "http://localhost/e-learning/dosen/edit-profile.php" ||
    currentLocation == "http://localhost/e-learning/index.php"
      ? ".progress"
      : ".progress-warning";

  const toast = document.querySelector(toastClass);
  const progress = document.querySelector(progressClass);
  const closeIcon = document.querySelector(`${toastClass} .close`);
  toast.classList.add("active");
  progress.classList.add("active");

  setTimeout(() => {
    toast.classList.remove("active");
  }, 5000);
  setTimeout(() => {
    progress.classList.remove("active");
  }, 5300);

  closeIcon.addEventListener("click", () => {
    toast.classList.remove("active");
    setTimeout(() => {
      progress.classList.remove("active");
    }, 300);
  });
}

function imagePreview() {
  var fileInput = document.getElementById("image");
  var preview = document.getElementById("image-preview");
  var file = fileInput.files[0];
  var reader = new FileReader();

  reader.onloadend = function () {
    preview.src = reader.result;
  };

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
}

function togglePasswordVisibility(inputFieldId) {
  const inputField = document.getElementById(inputFieldId);
  const eyeIcon = document.querySelector(`#${inputFieldId} ~ .eye-icon`);

  if (inputField.type === "password") {
    inputField.type = "text";
    eyeIcon.classList.remove("bx-hide");
    eyeIcon.classList.add("bx-show");
  } else {
    inputField.type = "password";
    eyeIcon.classList.remove("bx-show");
    eyeIcon.classList.add("bx-hide");
  }
}

function editGrade(enrollmentId) {
  var gradeSpan = document.getElementById("gradeSpan_" + enrollmentId);
  var gradeValue = gradeSpan.innerText;

  var inputElement = document.createElement("input");
  inputElement.type = "number";
  inputElement.value = gradeValue;
  inputElement.name = "newGrade";
  inputElement.max = "100";
  inputElement.min = "0";
  inputElement.id = "gradeInput_" + enrollmentId;
  inputElement.style.width = gradeSpan.offsetWidth + 32 + "px";
  inputElement.style.backgroundColor = "#ffffff";
  inputElement.onblur = function () {
    saveGrade(enrollmentId);
  };

  gradeSpan.parentNode.replaceChild(inputElement, gradeSpan);
  inputElement.focus();
}

function saveGrade(enrollmentId) {
  var inputElement = document.getElementById("gradeInput_" + enrollmentId);
  var newGrade = inputElement.value;

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../dosen/controller/update_grade.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      var gradeSpan = document.createElement("span");
      gradeSpan.id = "gradeSpan_" + enrollmentId;
      gradeSpan.innerText = newGrade;
      gradeSpan.onclick = function () {
        editGrade(enrollmentId);
      };

      inputElement.parentNode.replaceChild(gradeSpan, inputElement);
      showToast();
    } else {
      console.error("Failed to update grade value");
    }
  };
  xhr.onerror = function () {
    console.error("Failed to send AJAX request");
  };
  xhr.send("enrollmentId=" + encodeURIComponent(enrollmentId) + "&newGrade=" + encodeURIComponent(newGrade));
  window.location.reload();
}
