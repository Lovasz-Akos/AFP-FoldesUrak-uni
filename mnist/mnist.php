<?php
    // MNIST LOGIKA (Makai Balázs) 
    require 'connection.php';
    session_start();

        // Ha beadtunk egy számot..
        if(isset($_GET["number"])){
            $ertek = intval($_GET["number"]);
            // És a szám helyes..
            if($ertek == $_SESSION['helyesErtek']) {
                $_SESSION["jóMegoldások"] = $_SESSION["jóMegoldások"] + 1;
                $_SESSION["kerdesekSzama"] = $_SESSION["kerdesekSzama"] - 1;
                header("Location: mnist.php");
            }
            // És a szám helytelen..
            else {
                $_SESSION["kerdesekSzama"] = $_SESSION["kerdesekSzama"] - 1;
                header("Location: mnist.php");
            }
        }
        

    $_SESSION['imageSrc'] = "\Project\images\&";
        //Generálunk egy random számot                  
        $index = rand(0, 2000);

        //Készítünk egy tömböt
        $path = 'Resources/Images';
        $files = scandir($path);

        $randomImage = $files[$index];
        $_SESSION["helyesErtek"] = substr($randomImage, -6, 1);
        $_SESSION["image"]=$randomImage;

    //Dobja fel adatbázisba az eredményt
    if($_SESSION['kerdesekSzama'] <= 0) {
        $_SESSION['elozoJoMegoldasok'] = $_SESSION['jóMegoldások'];

        $db = new dbObj();
        $connection = $db->getConnection();

        if(!isset($_SESSION['userLoggedIn']) || !$_SESSION['userLoggedIn']) {
            $_SESSION["user"] = "Vendég";
        }

        $query = "INSERT INTO rangsor SET felhasznalonev = ' ".$_SESSION["user"]." ', pontszam =' ".$_SESSION["jóMegoldások"]." ' ";

        if(mysqli_query($connection, $query)){
            $response = array(
                'status' => 1,
                'status_message' => 'score uploaded successfully'
            );
        }else{
            $response = array(
                'status' => 0,
                'status_message' => 'score upload failed'
            );
        }
        header("Location: index.php");
    }

    $db = new dbObj();
    $connection = $db->getConnection();
    $image=$_SESSION['image'];
    $result=$connection->query("SELECT SUM(number_of_guesses) AS 'sum' FROM stat GROUP BY filename HAVING filename='".$image."';");
    $row=$result->fetch_assoc();
    $numofguesses=$row['sum'];
    $result=$connection->query("SELECT number_of_guesses FROM stat GROUP BY filename,number HAVING filename='".$image."';");
    $index=0;
    $datas = array();
    while(($row =  mysqli_fetch_assoc($result))) {
    $datas[$index] = $row['number_of_guesses'];
    $index++;
}

    $dataPoints = array( 
        array("label"=>"0", "y"=>number_format(($datas[0]/(int)$numofguesses)*100,2)),
        array("label"=>"1", "y"=>number_format(($datas[1]/(int)$numofguesses)*100,2)),
        array("label"=>"2", "y"=>number_format(($datas[2]/(int)$numofguesses)*100,2)),
        array("label"=>"3", "y"=>number_format(($datas[3]/(int)$numofguesses)*100,2)),
        array("label"=>"4", "y"=>number_format(($datas[4]/(int)$numofguesses)*100,2)),
        array("label"=>"5", "y"=>number_format(($datas[5]/(int)$numofguesses)*100,2)),
        array("label"=>"6", "y"=>number_format(($datas[6]/(int)$numofguesses)*100,2)),
        array("label"=>"7", "y"=>number_format(($datas[7]/(int)$numofguesses)*100,2)),
        array("label"=>"8", "y"=>number_format(($datas[8]/(int)$numofguesses)*100,2)),
        array("label"=>"9", "y"=>number_format(($datas[9]/(int)$numofguesses)*100,2)));
?>

<html>
    <head>
    
        <link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="./Resources/button.css">
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script>

        function graph() {       
            var chart = new CanvasJS.Chart("chartContainer", {
	        animationEnabled: true,
	        title: {text: "Tippek eloszlása"},
	        data: [{
		        type: "pie",
		        yValueFormatString: "#,##0.00\"%\"",
		        indexLabel: "{label} ({y})",
		        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>}]
            });
            chart.render();
        }
            

        // SZÁMBILLENTYŰZET (Galvács István)

        function input(e) {
            var tbInput = document.getElementById("tbInput");
            tbInput.value = e.value;
        }

        function del() {
            var tbInput = document.getElementById("tbInput");
            tbInput.value = tbInput.value.
            substr(0, tbInput.value.length - 1);
        }
        </script>

        <title>Mnist</title>
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
        }
        else {
            // Bejelentkezés/Regisztrációs sáv
            echo'
            <nav class="navtop">
                    <div>
                        <h1>MNIST by humans</h1>
                        <a href="login.php"><i class="fas fa-user-circle"></i>Bejelentkezés</a>
                        <a href="regisztral.php"><i class="fas fa-user-circle"></i>Regisztrálok</a>
                        <a href="mnist.php"><i class="fas fa-user-circle"></i>MNIST</a>
                    </div>
                </nav>
                ';

            // Felhívjük a felhasználó figyelmét, hogy nincs bejelentkezve
            echo'
                <div class="guestmessage">
                <p>MNIST vendégként</p>
                ';
        }
        ?> 
        <div class="mnist">
        <div class="mnist-half">
                <img class="mnistpic" src="Resources\Images\<?php echo $_SESSION["image"] ?>">
                <p> Helyes válaszok száma: <?php echo $_SESSION["jóMegoldások"] ?> </p>
                <p> Hátralévő kérdések száma: <?php echo $_SESSION["kerdesekSzama"] ?> </p>
  
            <form class="calc">
                <input class="button-4 calc" type = "number" id ="tbInput" name ="number" min="0" max = "9" step = "1" required>
         

        <!-- SZÁMBILLENTYŰZET (Galvács István) -->
        
        <div id="VirtualKey">
            <input class="button-4"id="btn1" type="button" value="1" onclick="input(this);" />
            <input class="button-4"id="btn2" type="button" value="2" onclick="input(this);"/>
            <input class="button-4"id="btn3" type="button"value="3" onclick="input(this);" />
            <br />
            <input class="button-4"id="btn4" type="button"value="4" onclick="input(this);" />
            <input class="button-4"id="btn5" type="button"value="5" onclick="input(this);" />
            <input class="button-4"id="btn6" type="button"value="6" onclick="input(this);" />
            <br />
            <input class="button-4"id="btn7" type="button"value="7" onclick="input(this);" />
            <input class="button-4"id="btn8" type="button"value="8" onclick="input(this);" />
            <input class="button-4"id="btn9" type="button"value="9" onclick="input(this);" />
            <br />
            <input class="button-4"id="btn0" type="button"value="0" onclick="input(this)" />
            <input class="button-4 del"id="btnDel" type="button" value="Töröl " onclick="del();" /><br>
            <input type = "submit" class="button-4 sub" value="Submit">
            </form>
        </div><br />
        </div>
        </div>

        <div class="mnist">
        <b><input type='submit' onclick="graph();" class='btn' value='Statisztika'></b><br>

        <div id='include'></div><br><br>
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        </div>
    </div>
    </body>
</html>
