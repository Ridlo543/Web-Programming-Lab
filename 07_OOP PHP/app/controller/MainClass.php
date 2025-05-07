<?php

namespace App\controller;

use App\Utils\Helper as UtilsHelper; // Menggunakan alias untuk menghindari konflik nama

class MainClass
{
    public function __construct()
    {
        UtilsHelper::greet(); // Memanggil fungsi dari namespace App\Utils
    }
}

$class1 = new MainClass();
