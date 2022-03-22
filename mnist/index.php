<?php 
    session_start();
    //MNIST Logika - (Makai Balázs)
    $_SESSION['kerdesekSzama'] = 10;
    $_SESSION['jóMegoldások'] = 0;
?>

<html>
    <head>
        <title>Főoldal</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <?php
        // Felhasználó panel kiiratása, hogyha a felhasználó bevan jelentkezve
        if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
            echo '
            <nav class="navtop">
                    <div>
                        <h1>MNIST by humans</h1>
                        <a href="profile.php"><i class="fas fa-user-circle"></i>Profil</a>
                        <a href="mnist.php"><i class="fas fa-user-circle"></i>MNIST</a>
                        <a href="ki.php"><i class="fas fa-sign-out-alt"></i>Kijelentkezés</a>
                    </div>
                </nav>
                ';

            if(!empty($_SESSION['elozoJoMegoldasok'])) {
                echo "<p>Legutolsó alkalommal ".$_SESSION['elozoJoMegoldasok']." jó megoldása volt</p>";
            }
        }
        else {
            // Bejelentkezés/Regisztrációs sáv vendégeknek
            echo '
            <nav class="navtop">
                    <div>
                        <h1>MNIST by humans</h1>
                        <a href="login.php"><i class="fas fa-user-circle"></i>Bejelentkezés</a>
                        <a href="regisztral.php"><i class="fas fa-user-circle"></i>Regisztrálok</a>
                        <a href="mnist.php"><i class="fas fa-user-circle"></i>MNIST</a>
                    </div>
                </nav>
                ';

            // Felhívjük a felhasználó figyelmét, hogy nincsenek bejelentkezve
            echo '
                <div class="guestmessage">
                <p>Maga nincs bejelentkezve!</p>
                <p>Továbbra is használhatja az oldalt, de korábbi próbálkozásait nem tudja visszanézni, illetve felhasználónevét nem tudja megváltoztatni!</p>
                </div>
                ';
        }
        ?> 

        <!-- RANKLISTA KIÍRÁSA - (Galvács István) -->
        <div id="rangsor">
        <h1><u>Rangsor:</u></h1>
        <?php

        include("connection.php");
        $db = new dbObj();
        $connection = $db->getConnection();

        
        $query="SELECT felhasznalonev, pontszam FROM rangsor ORDER BY pontszam DESC";
       
        $response=array();
        $result=mysqli_query($connection, $query);
        $rank=1;
        echo "<table border=1>";
            echo "<tr>
            <th> Rang</th>
                <th>Felhasználónév</th>
                <th>Pontszám</th>
            </tr>";
        while($row=mysqli_fetch_assoc($result))
        { 
            echo"<tr>";
            echo "<td width=20 align=center>". $rank .".". "</td>";
            echo"<td width=100>" . $row['felhasznalonev'] . "</td>";
            echo"<td wdith=100 align=center>" . $row['pontszam'] ." Pt" . "</td>";
            echo "</tr>";
         $rank++;
        }  
        echo "</table>";
        ?>
    </body>
</html>
