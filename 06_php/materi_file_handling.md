## 10. Pengenalan File Handling

PHP menyediakan berbagai fungsi untuk bekerja dengan file dan direktori.

### Membaca File

```php
<?php
    // 1. file_get_contents() - Membaca seluruh file ke dalam string
    $content = file_get_contents("data.txt");
    echo $content;

    // Dengan URL
    $html = file_get_contents("https://www.example.com");
    echo $html;

    // 2. file() - Membaca file ke dalam array (per baris)
    $lines = file("data.txt");
    foreach ($lines as $line_num => $line) {
        echo "Line #" . ($line_num + 1) . ": " . htmlspecialchars($line) . "<br>";
    }

    // 3. fopen(), fread(), fclose() - Untuk kontrol lebih detail
    $file = fopen("data.txt", "r");

    if ($file) {
        // Membaca seluruh file
        $content = fread($file, filesize("data.txt"));
        echo $content;

        // Menutup file
        fclose($file);
    } else {
        echo "Tidak dapat membuka file";
    }

    // 4. fgets() - Membaca file per baris
    $file = fopen("data.txt", "r");

    if ($file) {
        // Membaca baris per baris
        while (!feof($file)) {
            $line = fgets($file);
            echo $line . "<br>";
        }

        fclose($file);
    }

    // 5. fgetcsv() - Membaca CSV file
    $file = fopen("data.csv", "r");

    if ($file) {
        while (($data = fgetcsv($file, 1000, ",")) !== false) {
            echo $data[0] . " - " . $data[1] . "<br>";
        }

        fclose($file);
    }
?>
```

### Menulis File

```php
<?php
    // 1. file_put_contents() - Menulis string ke file
    $content = "Hello, World!";
    file_put_contents("output.txt", $content);

    // Append ke file yang sudah ada
    file_put_contents("output.txt", "\nNew line", FILE_APPEND);

    // 2. fopen(), fwrite(), fclose() - Untuk kontrol lebih detail
    $file = fopen("output.txt", "w"); // w: write (overwrite), a: append

    if ($file) {
        fwrite($file, "First line\n");
        fwrite($file, "Second line\n");

        fclose($file);
    }

    // 3. fputcsv() - Menulis CSV file
    $data = [
        ["John", "Doe", "john@example.com"],
        ["Jane", "Smith", "jane@example.com"]
    ];

    $file = fopen("data.csv", "w");

    if ($file) {
        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    }
?>
```

### Mode Akses File

| Mode | Deskripsi                                                         |
| ---- | ----------------------------------------------------------------- |
| r    | Baca saja. Pointer di awal file.                                  |
| r+   | Baca dan tulis. Pointer di awal file.                             |
| w    | Tulis saja. Hapus isi file jika ada, buat baru jika tidak.        |
| w+   | Baca dan tulis. Hapus isi file jika ada, buat baru jika tidak.    |
| a    | Tulis saja. Pointer di akhir file. Buat baru jika tidak ada.      |
| a+   | Baca dan tulis. Pointer di akhir file. Buat baru jika tidak ada.  |
| x    | Tulis saja. Buat file baru. Return false jika file sudah ada.     |
| x+   | Baca dan tulis. Buat file baru. Return false jika file sudah ada. |

### File System Functions

```php
<?php
    // Operasi file
    copy("source.txt", "destination.txt"); // Menyalin file
    rename("old_name.txt", "new_name.txt"); // Mengganti nama file
    unlink("file.txt"); // Menghapus file

    // Informasi file
    echo filesize("file.txt"); // Ukuran file dalam bytes
    echo filetype("file.txt"); // Tipe file (file, dir, etc)
    echo filemtime("file.txt"); // Waktu modifikasi terakhir
    echo fileatime("file.txt"); // Waktu akses terakhir
    echo fileowner("file.txt"); // Owner ID
    echo fileperms("file.txt"); // Permission

    // Memeriksa file
    echo file_exists("file.txt"); // Cek apakah file ada
    echo is_file("file.txt"); // Cek apakah file (bukan direktori)
    echo is_dir("folder"); // Cek apakah direktori
    echo is_readable("file.txt"); // Cek apakah dapat dibaca
    echo is_writable("file.txt"); // Cek apakah dapat ditulis
    echo is_executable("file.txt"); // Cek apakah dapat dieksekusi

    // Operasi direktori
    mkdir("new_folder"); // Membuat direktori
    mkdir("nested/folder", 0777, true); // Rekursif
    rmdir("folder"); // Menghapus direktori (harus kosong)

    // Membaca direktori
    $dir = "folder";
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                echo "Filename: $file<br>";
            }
            closedir($dh);
        }
    }

    // Menggunakan scandir
    $files = scandir("folder");
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            echo $file . "<br>";
        }
    }

    // Recursively remove directory
    function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object))
                        rrmdir($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            rmdir($dir);
        }
    }

    // glob() - Mencari file dengan pattern
    $php_files = glob("*.php");
    $txt_files = glob("*.txt");
    $img_files = glob("images/*.{jpg,png,gif}", GLOB_BRACE);

    // pathinfo() - Informasi path file
    $path_info = pathinfo("/var/www/html/index.php");
    echo $path_info['dirname']; // /var/www/html
    echo $path_info['basename']; // index.php
    echo $path_info['extension']; // php
    echo $path_info['filename']; // index
?>
```

### Upload File

```php
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["fileToUpload"])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Cek jika file sudah ada
            if (file_exists($target_file)) {
                echo "File already exists.<br>";
                $uploadOk = 0;
            }

            // Cek ukuran file (limit to 5MB)
            if ($_FILES["fileToUpload"]["size"] > 5000000) {
                echo "File is too large.<br>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" &&
                $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "Only JPG, JPEG, PNG & GIF files are allowed.<br>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "File was not uploaded.<br>";
            } else {
                // Upload file
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.<br>";
                } else {
                    echo "There was an error uploading your file.<br>";
                }
            }
        }
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <label>Select file to upload:</label>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload File" name="submit">
</form>
```
