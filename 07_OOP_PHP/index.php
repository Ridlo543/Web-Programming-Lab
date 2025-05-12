<?php
class Builder
{
    private $text = "";

    public function tambahTeks($teks)
    {
        $this->text .= $teks . " ";
        return $this; // Mengembalikan objek saat ini
    }

    public function cetak()
    {
        echo trim($this->text) . "\n";
        return $this;
    }
}

// Penggunaan method chaining
$kalimat = new Builder();
$kalimat->tambahTeks("Halo")
    ->tambahTeks("dunia")
    ->tambahTeks("PHP!")
    ->cetak(); // Output: Halo dunia PHP!