<?php

    $image=$_SESSION['image'];
    $db = new dbObj();
    $connection = $db->getConnection();
    $result=$connection->query("SELECT SUM(number_of_guesses) AS 'sum' FROM stat GROUP BY filename HAVING filename='".$image."';");
    $row=$result->fetch_assoc();
    $numofguesses=$row['sum'];
    $result=$connection->query("SELECT number_of_guesses FROM stat GROUP BY filename,number HAVING filename='".$image."';");
    echo "<table>";
    echo "<tr>";
    for ($i=0; $i < 10; $i++) { 
        echo "<th>".$i."</th>";
    }
    echo "</tr>";
    echo "<tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<td>" . number_format(($row['number_of_guesses']/$numofguesses)*100,2)." %"."</td>";
    }
    echo "</tr>";
    echo "</table>";



?>