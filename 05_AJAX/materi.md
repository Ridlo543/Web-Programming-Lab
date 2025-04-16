# Praktikum Pemrograman Web 5: AJAX - Panduan Lengkap

## Pengenalan AJAX

AJAX (Asynchronous JavaScript and XML) adalah teknologi yang memungkinkan website untuk berkomunikasi dengan server dan memperbarui data secara asinkronus, tanpa perlu me-reload seluruh halaman web. Ini memberikan pengalaman pengguna yang lebih baik dan responsif.

### Konsep Utama AJAX

- **Asynchronous**: Operasi berjalan di latar belakang tanpa mengganggu interaksi pengguna
- **JavaScript**: Digunakan untuk mengirim permintaan dan memproses respons
- **XML/JSON**: Format data yang umum digunakan (meskipun sekarang JSON lebih populer)

### Keunggulan AJAX

1. Meningkatkan kecepatan dan performa website
2. Mengurangi lalu lintas server (hanya memuat data yang diperlukan)
3. Pengalaman pengguna yang lebih mulus tanpa refresh halaman

## 1. Dasar Pemrograman Asinkronus

Pemrograman asinkronus memungkinkan kode untuk melanjutkan eksekusi tanpa harus menunggu operasi lain selesai.

```javascript
console.log("Mulai");

// Operasi asinkronus dengan setTimeout
setTimeout(() => {
  console.log("Operasi asinkronus selesai setelah 2 detik");
}, 2000);

console.log("Proses lain berjalan tanpa menunggu");
```

Output:

```
Mulai
Proses lain berjalan tanpa menunggu
Operasi asinkronus selesai setelah 2 detik
```

## 2. XMLHttpRequest API

XMLHttpRequest adalah objek JavaScript yang menjadi fondasi AJAX. Meskipun namanya mengandung "XML", objek ini dapat digunakan untuk bekerja dengan berbagai format data termasuk JSON, HTML, dan teks biasa.

### Metode GET dengan XMLHttpRequest

```javascript
function ambilDataDenganXHR() {
  // 1. Buat objek XMLHttpRequest
  const xhr = new XMLHttpRequest();

  // 2. Konfigurasi: metode GET, URL, asinkronus (true)
  xhr.open("GET", "https://jsonplaceholder.typicode.com/users/1", true);

  // 3. Atur handler untuk merespons perubahan status
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      // 4 berarti request selesai
      if (xhr.status === 200) {
        // 200 berarti sukses
        const responseData = JSON.parse(xhr.responseText);
        console.log("Data user:", responseData);
        document.getElementById("hasil").textContent = responseData.name;
      } else {
        console.error("Error dengan status:", xhr.status);
      }
    }
  };

  // 4. Kirim request
  xhr.send();
}
```

### Metode POST dengan XMLHttpRequest

```javascript
function kirimDataDenganXHR() {
  // 1. Buat objek XMLHttpRequest
  const xhr = new XMLHttpRequest();

  // 2. Konfigurasi: metode POST, URL, asinkronus (true)
  xhr.open("POST", "https://jsonplaceholder.typicode.com/posts", true);

  // 3. Set header untuk mengirim JSON
  xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

  // 4. Atur handler untuk respons
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 201) {
        // 201 Created
        const responseData = JSON.parse(xhr.responseText);
        console.log("Post berhasil dibuat:", responseData);
      } else {
        console.error("Error dengan status:", xhr.status);
      }
    }
  };

  // 5. Siapkan data dan kirim request
  const data = {
    title: "Judul Post Baru",
    body: "Isi post yang ingin disimpan",
    userId: 1,
  };

  xhr.send(JSON.stringify(data));
}
```

## 3. Fetch API

Fetch API adalah antarmuka modern untuk melakukan request AJAX yang lebih bersih dan menggunakan Promise untuk menangani operasi asinkronus.

### Metode GET dengan Fetch

```javascript
function ambilDataDenganFetch() {
  fetch("https://jsonplaceholder.typicode.com/users/1")
    .then((response) => {
      // Periksa apakah respons berhasil (status 200-299)
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json(); // Parse respons JSON
    })
    .then((data) => {
      console.log("Data user:", data);
      document.getElementById("hasil").textContent = data.name;
    })
    .catch((error) => {
      console.error("Fetch error:", error);
    });
}
```

### Metode POST dengan Fetch

```javascript
function kirimDataDenganFetch() {
  fetch("https://jsonplaceholder.typicode.com/posts", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      title: "Judul Post Baru",
      body: "Isi post yang ingin disimpan",
      userId: 1,
    }),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      console.log("Post berhasil dibuat:", data);
    })
    .catch((error) => {
      console.error("Fetch error:", error);
    });
}
```

### Async/Await dengan Fetch

Async/await menyederhanakan kode asinkronus dan membuatnya terlihat lebih seperti kode sinkronus.

```javascript
async function ambilDataDenganAsyncAwait() {
  try {
    const response = await fetch(
      "https://jsonplaceholder.typicode.com/users/1"
    );

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const data = await response.json();
    console.log("Data user:", data);
    document.getElementById("hasil").textContent = data.name;
  } catch (error) {
    console.error("Fetch error:", error);
  }
}
```

## 4. Pengolahan Data JSON

JSON (JavaScript Object Notation) adalah format data ringan yang mudah dibaca oleh manusia dan diproses oleh mesin. JSON adalah standar de facto untuk pertukaran data dalam aplikasi web modern.

### Parsing JSON dari Respons Server

```javascript
fetch("https://jsonplaceholder.typicode.com/users")
  .then((response) => response.json())
  .then((users) => {
    console.log("Jumlah users:", users.length);

    // Akses properti JSON
    users.forEach((user) => {
      console.log(`Nama: ${user.name}, Email: ${user.email}`);
    });

    // Filter data
    const filteredUsers = users.filter((user) => user.name.startsWith("L"));
    console.log("Users dengan nama berawalan L:", filteredUsers);
  });
```

### Mengkonversi Objek JavaScript ke JSON

```javascript
const userBaru = {
  name: "John Doe",
  email: "john@example.com",
  address: {
    street: "Jalan Contoh",
    city: "Jakarta",
  },
  hobbies: ["Coding", "Reading"],
};

// Konversi ke string JSON
const jsonString = JSON.stringify(userBaru);
console.log(jsonString);

// Konversi JSON string kembali ke objek
const parsedObject = JSON.parse(jsonString);
console.log(parsedObject.name); // "John Doe"
```

## 5. Mengambil dan Menampilkan Data dari API

Berikut contoh praktis untuk mengambil data dari API publik dan menampilkannya di halaman web:

```html
<!DOCTYPE html>
<html>
  <head>
    <title>Demo AJAX - Data Users</title>
    <style>
      .user-card {
        border: 1px solid #ddd;
        margin: 10px;
        padding: 15px;
        border-radius: 5px;
      }
      .loading {
        display: none;
        color: blue;
      }
    </style>
  </head>
  <body>
    <h1>Daftar Pengguna</h1>
    <button id="loadUsers">Muat Data Pengguna</button>
    <div id="loading" class="loading">Memuat data...</div>
    <div id="userList"></div>

    <script>
      document.getElementById("loadUsers").addEventListener("click", loadUsers);

      async function loadUsers() {
        const loadingElement = document.getElementById("loading");
        const userListElement = document.getElementById("userList");

        // Tampilkan loading state
        loadingElement.style.display = "block";
        userListElement.innerHTML = "";

        try {
          const response = await fetch(
            "https://jsonplaceholder.typicode.com/users"
          );

          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }

          const users = await response.json();

          // Render masing-masing user
          users.forEach((user) => {
            const userCard = document.createElement("div");
            userCard.className = "user-card";
            userCard.innerHTML = `
            <h3>${user.name}</h3>
            <p><strong>Email:</strong> ${user.email}</p>
            <p><strong>Phone:</strong> ${user.phone}</p>
            <p><strong>Website:</strong> ${user.website}</p>
            <p><strong>Company:</strong> ${user.company.name}</p>
          `;
            userListElement.appendChild(userCard);
          });
        } catch (error) {
          console.error("Error:", error);
          userListElement.innerHTML = `<p style="color: red">Error: ${error.message}</p>`;
        } finally {
          // Sembunyikan loading state
          loadingElement.style.display = "none";
        }
      }
    </script>
  </body>
</html>
```

## 6. AJAX dengan jQuery

jQuery menyediakan metode AJAX yang mudah digunakan yang menyederhanakan penggunaan XMLHttpRequest.

### Metode $.ajax() - Paling Fleksibel

```html
<!DOCTYPE html>
<html>
  <head>
    <title>jQuery AJAX Demo</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <h2>Demo jQuery AJAX</h2>
    <button id="loadBtn">Muat Data</button>
    <div id="loading" style="display:none;">Memuat...</div>
    <div id="result"></div>

    <script>
      $(document).ready(function () {
        $("#loadBtn").click(function () {
          $("#loading").show();
          $("#result").empty();

          $.ajax({
            url: "https://jsonplaceholder.typicode.com/posts/1",
            method: "GET",
            dataType: "json",
            success: function (data) {
              $("#result").html(`
              <h3>${data.title}</h3>
              <p>${data.body}</p>
            `);
            },
            error: function (xhr, status, error) {
              $("#result").html(`<p style="color:red">Error: ${error}</p>`);
            },
            complete: function () {
              $("#loading").hide();
            },
            timeout: 5000, // 5 detik timeout
          });
        });
      });
    </script>
  </body>
</html>
```

### Metode $.get() - Untuk Request GET

```html
<body>
  <button id="getBtn">Ambil Data</button>
  <div id="result"></div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
```

```javascript
// Versi singkat untuk GET request
$("#getBtn").click(function () {
  $.get("https://jsonplaceholder.typicode.com/posts/1", function (data) {
    $("#result").html(`<h3>${data.title}</h3><p>${data.body}</p>`);
  }).fail(function (xhr, status, error) {
    $("#result").html(`<p style="color:red">Error: ${error}</p>`);
  });
});
```

### Metode $.post() - Untuk Request POST

```html
<body>
  <button id="postBtn">Kirim Data</button>
  <div id="result"></div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
```

```javascript
$("#postBtn").click(function () {
  const newPost = {
    title: "Judul Post Baru",
    body: "Isi post baru",
    userId: 1,
  };

  $.post(
    "https://jsonplaceholder.typicode.com/posts",
    newPost,
    function (data) {
      $("#result").html(`
      <h3>Post berhasil dibuat!</h3>
      <p>ID: ${data.id}</p>
      <p>Judul: ${data.title}</p>
    `);
    }
  ).fail(function (xhr, status, error) {
    $("#result").html(`<p style="color:red">Error: ${error}</p>`);
  });
});
```

## 7. Praktik Penggunaan Form dengan AJAX

Form adalah cara umum untuk mengumpulkan dan mengirim data di web. Dengan AJAX, kita dapat mengirim data form tanpa reload halaman.

```html
<!DOCTYPE html>
<html>
  <head>
    <title>AJAX Form Demo</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
      .form-group {
        margin-bottom: 15px;
      }
      label {
        display: block;
        margin-bottom: 5px;
      }
      input,
      textarea {
        width: 300px;
        padding: 5px;
      }
      .error {
        color: red;
      }
      .success {
        color: green;
      }
    </style>
  </head>
  <body>
    <h2>Tambah Post Baru</h2>

    <form id="postForm">
      <div class="form-group">
        <label for="title">Judul:</label>
        <input type="text" id="title" name="title" required />
      </div>

      <div class="form-group">
        <label for="body">Isi:</label>
        <textarea id="body" name="body" rows="5" required></textarea>
      </div>

      <div class="form-group">
        <button type="submit">Simpan</button>
      </div>
    </form>

    <div id="loading" style="display:none;">Menyimpan data...</div>
    <div id="message"></div>

    <script>
      $(document).ready(function () {
        $("#postForm").submit(function (event) {
          event.preventDefault();

          // Validasi form sederhana
          if (!$("#title").val() || !$("#body").val()) {
            $("#message").html('<p class="error">Semua field harus diisi!</p>');
            return;
          }

          // Tampilkan loading state
          $("#loading").show();
          $("#message").empty();

          // Kumpulkan data form
          const postData = {
            title: $("#title").val(),
            body: $("#body").val(),
            userId: 1, // Hardcoded untuk contoh
          };

          // Kirim data dengan AJAX
          $.ajax({
            url: "https://jsonplaceholder.typicode.com/posts",
            method: "POST",
            data: JSON.stringify(postData),
            contentType: "application/json",
            success: function (response) {
              $("#message").html(`
              <p class="success">Post berhasil dibuat dengan ID: ${
                response.id
              }</p>
              <pre>${JSON.stringify(response, null, 2)}</pre>
            `);
              // Reset form
              $("#postForm")[0].reset();
            },
            error: function (xhr, status, error) {
              $("#message").html(`<p class="error">Error: ${error}</p>`);
            },
            complete: function () {
              $("#loading").hide();
            },
          });
        });
      });
    </script>
  </body>
</html>
```

## 8. Error Handling yang Efektif

Menangani error dengan baik sangat penting dalam aplikasi AJAX untuk memberikan feedback yang tepat kepada pengguna.

```html
<body>
  <button id="fetchBtn">Ambil Data</button>
  <div id="result"></div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
```

```javascript
function fetchDataWithErrorHandling() {
  // Tampilkan status loading
  const resultElement = document.getElementById("result");
  resultElement.innerHTML = '<div class="loading">Memuat data...</div>';

  fetch("https://jsonplaceholder.typicode.com/posts/999999") // ID yang tidak ada
    .then((response) => {
      // Periksa status HTTP
      if (!response.ok) {
        // Tangani berdasarkan kode status
        switch (response.status) {
          case 404:
            throw new Error("Data tidak ditemukan (404)");
          case 401:
            throw new Error("Tidak diizinkan mengakses data ini (401)");
          case 403:
            throw new Error("Akses ditolak (403)");
          case 500:
            throw new Error("Server error (500)");
          default:
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
      }
      return response.json();
    })
    .then((data) => {
      resultElement.innerHTML = `<h3>${data.title}</h3><p>${data.body}</p>`;
    })
    .catch((error) => {
      // Tampilkan pesan error
      resultElement.innerHTML = `
        <div class="error">
          <p><strong>Error:</strong> ${error.message}</p>
          <p>Silakan coba lagi nanti atau hubungi administrator.</p>
        </div>
      `;
      console.error("Fetch error details:", error);
    });
}
```

## 9. Praktik Terbaik AJAX

Berikut beberapa praktik terbaik saat mengimplementasikan AJAX:

### 1. Selalu Tampilkan Status Loading

```javascript
function fetchDataWithLoading() {
  const resultElement = document.getElementById("result");
  const loadingElement = document.getElementById("loading");

  // Tampilkan loading
  loadingElement.style.display = "block";
  resultElement.innerHTML = "";

  fetch("https://jsonplaceholder.typicode.com/users")
    .then((response) => response.json())
    .then((data) => {
      // Tampilkan data
      data.forEach((user) => {
        const userElement = document.createElement("div");
        userElement.className = "user-item";
        userElement.textContent = user.name;
        resultElement.appendChild(userElement);
      });
    })
    .catch((error) => {
      resultElement.innerHTML = `<p class="error">${error.message}</p>`;
    })
    .finally(() => {
      // Sembunyikan loading, baik sukses maupun gagal
      loadingElement.style.display = "none";
    });
}
```

### 2. Implementasi Throttling atau Debouncing

Untuk mencegah terlalu banyak request AJAX, gunakan teknik throttling atau debouncing:

```html
<body>
  <input type="text" id="search" placeholder="Cari pengguna..." />
  <div id="results"></div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
```

```javascript
// Debouncing: Delay permintaan sampai pengguna selesai mengetik
function debounce(func, wait) {
  let timeout;
  return function (...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(this, args), wait);
  };
}

// Contoh penggunaan dengan search input
const searchInput = document.getElementById("search");
const searchResults = document.getElementById("results");

const searchUsers = debounce(function (query) {
  if (query.length < 3) return;

  searchResults.innerHTML = "<p>Mencari...</p>";

  fetch(`https://jsonplaceholder.typicode.com/users?q=${query}`)
    .then((response) => response.json())
    .then((users) => {
      searchResults.innerHTML = "";
      if (users.length === 0) {
        searchResults.innerHTML = "<p>Tidak ada hasil</p>";
        return;
      }

      users.forEach((user) => {
        const item = document.createElement("div");
        item.textContent = user.name;
        searchResults.appendChild(item);
      });
    });
}, 500); // Tunggu 500ms setelah pengguna berhenti mengetik

searchInput.addEventListener("input", (e) => searchUsers(e.target.value));
```

### 3. Caching Hasil Request

Menyimpan hasil request dapat meningkatkan performa dan mengurangi beban server:
