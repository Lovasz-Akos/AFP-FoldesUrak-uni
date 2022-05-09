<?php
    // Statisztikai tábla feltöltő, NE HASZNÁLD HA NEM ÜRES A 'stat' TÁBLÁD! Csakis tesztelés miatt töltöttem fel.
    require 'connection.php';
    $db = new dbObj();
    $connection = $db->getConnection();
    $path = 'Resources/Images';
    $files = scandir($path, SCANDIR_SORT_NONE);
    for ($i=2; $i < 2002; $i++) { 
        $image = $files[$i];
        $actualvalue = substr($image, -6, 1);
        for ($j=0; $j < 10; $j++) { 
            if($actualvalue==$j) {
                $true=1;
                $connection->query("INSERT INTO stat(filename,number,actualvalue) VALUES('".$image."','".$j."','".$true."');");
            }
            else{
                $true=0;
                $connection->query("INSERT INTO stat(filename,number,actualvalue) VALUES('".$image."','".$j."','".$true."');");
            }
        }
    }
?>

