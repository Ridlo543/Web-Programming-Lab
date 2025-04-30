<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // While loop dasar
    $i = 0;
    while ($i < 5) {
        echo "Iterasi ke-$i <br>";
        $i++;
    }

    // Sintaks alternatif
    $i = 0;
    while ($i < 5):
        echo "Iterasi ke-$i <br>";
        $i++;
    endwhile;
    ?>



</body>

</html>