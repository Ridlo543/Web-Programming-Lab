<?php
include "file1.php";
echo $greeting; // Output: Hello, World!
sapa(); // Output: Selamat Datang!

// Path relatif
include "folder/file.php";

// Path absolut
include "/var/www/html/file.php";

// include_once - Seperti include, tetapi hanya disertakan sekali
include_once "file1.php"; // File akan disertakan
include_once "file1.php"; // File tidak akan disertakan lagi