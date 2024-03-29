<?php
session_start();
// $check = (!isset($_SESSION['infoUtente']) || empty($_SESSION['infoUtente']));
if (!isset($_SESSION['infoUtente'])) { //Non riporta l'errore
    error_reporting(0);
    $valAdmin = 0;
} else {
    $info = $_SESSION["infoUtente"]; //Mi da le informazioni dell'utente loggato
    $valAdmin = $info["isAdmin"];
}
if (empty(isset($_SESSION['infoUtente'])) ){
    $session = "0";
}else{
    $session = isset($_SESSION['infoUtente']);
}
?>


<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- ============= RESET STYLE ============= -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" integrity="sha512-NmLkDIU1C/C88wi324HBc+S2kLhi08PN5GDeUVVVC/BVt/9Izdsc9SVeVfA1UZbY3sHUlDSyRXhCzHfr6hmPPw==" crossorigin="anonymous" />
    <!-- ============= STYLE ============= -->
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/event.css">
    <!-- ============= Google Font ============= -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&family=Rubik&display=swap" rel="stylesheet">
    <!-- ============= Slider ============= -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.2/flickity.pkgd.min.js" integrity="sha512-cA8gcgtYJ+JYqUe+j2JXl6J3jbamcMQfPe0JOmQGDescd+zqXwwgneDzniOd3k8PcO7EtTW6jA7L4Bhx03SXoA==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.2/flickity.min.css" integrity="sha512-BiFZ6oflftBIwm6lYCQtQ5DIRQ6tm02svznor2GYQOfAlT3pnVJ10xCrU3XuXnUrWQ4EG8GKxntXnYEdKY0Ugg==" crossorigin="anonymous" />
    <!-- ============= Font-Awesome ============= -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <script src="hhtps://kit.fontawesome.com/a81368914c.js"></script>
    <!-- ============ Javascript =================-->
    <script src="../main.js"></script>
    <!-- ============ SweetAlert =================-->
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>     SWEETALERT1 ORIGINALE -->
    <script src="../sweetalert2.all.min.js"></script>

</head>

<body>
    <!-- ============= HEADER ============= -->
    <header>
        <div class="hamburger">
            <i class="fas fa-bars" onclick="openLeftMenu()"></i>
        </div>
        <!-- logo -->
        <div class="logo">
            <a href="../index.php">
                liveXperience
            </a>
        </div>
        <!-- barra di ricerca -->
        <div class="search-container">
            <div class="dropdown">
                <button class="dropBtn">Categorie <i class="fa fa-caret-down"></i></button>
                <div class="dropdown_content">
                    <a href="search.php?Categoria=Musica"><i class="fas fa-microphone-alt"></i> &nbsp;Concerti</a>
                    <a href="search.php?Categoria=Sport"><i class="fas fa-futbol"></i> &nbsp;Sport</a>
                    <a href="search.php?Categoria=Teatro"><i class="fas fa-theater-masks"></i> &nbsp;Teatro</a>
                    <a href="search.php?Categoria=Musei"><i class="fas fa-atom"></i> &nbspMostre e Musei</a>
                </div>
            </div>
            <form action="search.php" method="GET">
                <input type="text" placeholder="Cerca il tuo evento" name="search_bar">
                <button type="submit"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyLjAwNSA1MTIuMDA1IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIuMDA1IDUxMi4wMDU7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxnPg0KCTxnPg0KCQk8cGF0aCBkPSJNNTA1Ljc0OSw0NzUuNTg3bC0xNDUuNi0xNDUuNmMyOC4yMDMtMzQuODM3LDQ1LjE4NC03OS4xMDQsNDUuMTg0LTEyNy4zMTdjMC0xMTEuNzQ0LTkwLjkyMy0yMDIuNjY3LTIwMi42NjctMjAyLjY2Nw0KCQkJUzAsOTAuOTI1LDAsMjAyLjY2OXM5MC45MjMsMjAyLjY2NywyMDIuNjY3LDIwMi42NjdjNDguMjEzLDAsOTIuNDgtMTYuOTgxLDEyNy4zMTctNDUuMTg0bDE0NS42LDE0NS42DQoJCQljNC4xNiw0LjE2LDkuNjIxLDYuMjUxLDE1LjA4Myw2LjI1MXMxMC45MjMtMi4wOTEsMTUuMDgzLTYuMjUxQzUxNC4wOTEsNDk3LjQxMSw1MTQuMDkxLDQ4My45MjgsNTA1Ljc0OSw0NzUuNTg3eg0KCQkJIE0yMDIuNjY3LDM2Mi42NjljLTg4LjIzNSwwLTE2MC03MS43NjUtMTYwLTE2MHM3MS43NjUtMTYwLDE2MC0xNjBzMTYwLDcxLjc2NSwxNjAsMTYwUzI5MC45MDEsMzYyLjY2OSwyMDIuNjY3LDM2Mi42Njl6Ii8+DQoJPC9nPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=" height="13px" width="13px" /></button>
            </form>
        </div>
        <!-- utility per il profilo + carrello-->
        <ul class="profile">
            <div id="ciaoIndex">
                <p id="ciao"><?php echo "Ciao " . $info["Nome"] . " " . $info["Cognome"] . "!" ?></p>
            </div>
            <li><a href="../add_event.php" id="add_event"><button><i class="fas fa-plus-circle"> AGGIUNGI EVENTO</i></button></a></li>
            <li><a href="../login.php" id="login"> Log in </a></li>
            <li><a href="../signup.php" id="SignUp"> Sign Up </a></li>
            <li><a href="../profile.php" id="profile"><button><i class="fas fa-user"></i></button></a></li>
            <!-- carrello -->
            <li>
                <div class="slide" id="carrello">
                    <button onclick="openSlideMenu()"><i class="fas fa-shopping-cart"></i></button>
                </div>
            </li>
        </ul>


    </header>

    <body onload="onLoad(<?php echo $session ?>, <?php echo $valAdmin ?>)">

        <!-- ========= LEFT MENU ========== -->
    <div id="left_menu">
        <!-- logo e chiusura -->
        <div class="space_between">
            <div class="logo">
                <a href="../index.php">
                    liveXperience
                </a>
            </div>
            <div id="close_left_menu">
                <i class="fas fa-times" onclick="closeLeftMenu()"></i>
            </div>
        </div>
        <!-- menu -->
        <div class="space_around">
            <ul>
                <a href="search.php?Categoria=Musica">
                    <li>
                        <i class="fas fa-microphone-alt"></i> &nbsp;Concerti
                    </li>
                </a>
                <a href="search.php?Categoria=Sport">
                    <li>
                        <i class="fas fa-futbol"></i> &nbsp;Sport
                    </li>
                </a>
                <a href="search.php?Categoria=Teatro">
                    <li>
                        <i class="fas fa-theater-masks"></i> &nbsp;Teatro
                    </li>
                </a>
                <a href="search.php?Categoria=Musei">
                    <li>
                        <i class="fas fa-atom"></i> &nbsp;Mostre e Musei
                    </li>
                </a>
                <li>
                    <form action="search.php" method="GET">
                        <input name="search_bar" type="text" placeholder="Cerca il tuo evento" name="search">
                        <button type="submit"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyLjAwNSA1MTIuMDA1IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIuMDA1IDUxMi4wMDU7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxnPg0KCTxnPg0KCQk8cGF0aCBkPSJNNTA1Ljc0OSw0NzUuNTg3bC0xNDUuNi0xNDUuNmMyOC4yMDMtMzQuODM3LDQ1LjE4NC03OS4xMDQsNDUuMTg0LTEyNy4zMTdjMC0xMTEuNzQ0LTkwLjkyMy0yMDIuNjY3LTIwMi42NjctMjAyLjY2Nw0KCQkJUzAsOTAuOTI1LDAsMjAyLjY2OXM5MC45MjMsMjAyLjY2NywyMDIuNjY3LDIwMi42NjdjNDguMjEzLDAsOTIuNDgtMTYuOTgxLDEyNy4zMTctNDUuMTg0bDE0NS42LDE0NS42DQoJCQljNC4xNiw0LjE2LDkuNjIxLDYuMjUxLDE1LjA4Myw2LjI1MXMxMC45MjMtMi4wOTEsMTUuMDgzLTYuMjUxQzUxNC4wOTEsNDk3LjQxMSw1MTQuMDkxLDQ4My45MjgsNTA1Ljc0OSw0NzUuNTg3eg0KCQkJIE0yMDIuNjY3LDM2Mi42NjljLTg4LjIzNSwwLTE2MC03MS43NjUtMTYwLTE2MHM3MS43NjUtMTYwLDE2MC0xNjBzMTYwLDcxLjc2NSwxNjAsMTYwUzI5MC45MDEsMzYyLjY2OSwyMDIuNjY3LDM2Mi42Njl6Ii8+DQoJPC9nPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=" height="13px" width="13px" /></button>
                    </form>
                </li>
            </ul>
            <ul>
                <a href="login.php">
                    <li>
                        <i class="fas fa-sign-in-alt"></i> &nbsp;Log in
                    </li>
                </a>
                <a href="signup.php">
                    <li>
                        <i class="fas fa-user-plus"></i>&nbsp;Sign Up
                    </li>
                </a>
                <a href="profile.php">
                    <li>
                        <i class="fas fa-user"></i> &nbsp;Profilo
                    </li>
                </a>
                <a href="logout.php">
                    <li>
                        <i class="fas fa-sign-out-alt"></i> &nbsp;Log out
                    </li>
                </a>
            </ul>
        </div>
    </div>
        <!-- ============= SLIDE SIDE CART ============= -->

        <div id="slcontent">
            <div id="menu" class="nav">
                <h13>Carrello</h13>
                <a href="#" class="close" onclick="closeSlideMenu()">
                    <i class="fas fa-times"></i>
                </a>
                <div class="cart-space-bet">
                <div id="cart-events">
                    <div class="cart-event">
                        <div class="img">
                            <img src="../images/concerto.jpeg" alt="">
                        </div>
                        <div class="dx">
                            <div class="info">
                                <span>Titolo</span>
                                <br>
                                <span>Data</span> <span>15/18/50</span>
                            </div>
                            <div class="prezzo">
                                <span>
                                    <i class="fas fa-minus" onclick="riduci_cart(this)"></i>
                                    <span id="numero_biglietti_cart">1</span>
                                    <i class="fas fa-plus" onclick="aumenta_cart(this)"></i>
                                </span>
                                <span>€58,60</span><span style="display:none;">disp</span><span style="display:none;">unit_price</span><span style="display:none;">id</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="center">
                    <span>Totale: €</span><span id="total-price">0</span>
                    <button type="submit" class="btn" onclick="acquista()"><i class="fas fa-lock"></i>&nbsp;&nbsp;Acquista</button>
                </div>
            </div>
            </div>
        </div>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "my_livexperience";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Recupero l'Id col metodo get, dopo aver selezionato l'evento dalla ricerca o dallo slider
        $id = $_GET['id'];

        //Query da eseguire
        $sql = "SELECT * FROM evento WHERE ID = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $description = $row["Descrizione"];
                $image_url = $row["Img"];
                $price = $row["Prezzo"];
                $title = $row["Nome"];
                $place = $row["Luogo"];
                $limitePosti = $row["Disp"];
                $date = $row["Data"];
                $category = $row["Categoria"];
            }
        } else {
            echo "0 results";
        }
        ?>


        <!-- ============= PROVA BLUR ============= -->
        <div class="bg_blur">
            <img src="<?php echo $image_url ?>" />
        </div>
        <div class="overlay">

        </div>



        <!-- ============= BODY EVENT ============= -->
        <div class="main_event">
            <div class="main_sx">
                <img id="cart-img" src="<?php echo $image_url ?>" />
            </div>
            <div class="main_dx">
                <h1 id="cart-title"> <?php echo $title?> </h1>
                <span id="cart-place"><?php echo $place ?></span>
                <span id="cart-date"><?php echo $date ?></span>
                <br>
                <span id="cart-price">€<?php echo number_format($price, 2) ?></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <br>
                <div class=center>
                    <i class="fas fa-minus" onclick="riduci(<?php echo $price ?>,this)"></i>
                    <span id="numero_biglietti">1</span>
                    <i class="fas fa-plus" onclick="aumenta(<?php echo $price ?>, <?php echo $limitePosti ?>,this)"></i>
                </div>
                <span id="avvisoPosti">Solo <?php echo $limitePosti ?> posti disponibili</span>
                <div class="center">
                    <button onclick="addToCart(<?php echo $id ?>, <?php echo $limitePosti ?>, <?php echo $price ?>)"><i class="fas fa-shopping-cart" style="color:white;"></i> Aggiungi al carrello </button>
                </div>
            </div>
        </div>

        <!-- ============= Descrizione ============= -->

        <div class="description">
            <h1>Descrizione</h1>
            <p> <?php echo $description ?> </p>
        </div>

        <!-- ============= Eventi correlati ============= -->

        <?php
        // Seleziono randomicamente 4 eventi correlati della stessa categoria, escludendo quello che è gia mostrato nella pagina, 
        // da visualizzare sotto la descrizione
        $sql = "SELECT * FROM evento WHERE Categoria = '$category' AND ID <> '$id'";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $eventi[] = $row;
        }
        // Ho preso tutti gli eventi della stessa categoria, li mescolo e poi prendo i primi 4
        shuffle($eventi);
        ?>

        <div class="ev_correlati">
            <h1>Potrebbero interessarti anche questi eventi</h1>
            <div class="center">
                <?php $row = $eventi["0"];
                $id = $row["ID"]; ?>
                <div class="evento" onclick="apriEvento(<?php echo $id ?>)">
                    <div class="blur_img">
                        <img src="<?php echo $row["Img"] ?>" />
                        <img src="<?php echo $row["Img"] ?>" />
                        <span class="info">
                            <?php echo $row["Luogo"] ?>
                            <br />
                            <?php echo $row["Data"] ?>
                            <br />
                            €<?php $prezzo = $row["Prezzo"];
                                echo number_format($prezzo, 2) ?>
                        </span>
                    </div>
                    <span class="title" id="titolo"><?php echo $row["Nome"] ?> </span>
                </div>
                <?php $row = $eventi["1"];
                $id = $row["ID"]; ?>
                <div class="evento" onclick="apriEvento(<?php echo $id ?>)">
                    <div class="blur_img">
                        <img src="<?php echo $row["Img"] ?>" />
                        <img src="<?php echo $row["Img"] ?>" />
                        <span class="info">
                            <?php echo $row["Luogo"] ?>
                            <br />
                            <?php echo $row["Data"] ?>
                            <br />
                            €<?php $prezzo = $row["Prezzo"];
                                echo number_format($prezzo, 2) ?>
                        </span>
                    </div>
                    <span class="title"><?php echo $row["Nome"] ?> </span>
                </div>
                <?php $row = $eventi["2"];
                $id = $row["ID"]; ?>
                <div class="evento" onclick="apriEvento(<?php echo $id ?>)">
                    <div class="blur_img">
                        <img src="<?php echo $row["Img"] ?>" />
                        <img src="<?php echo $row["Img"] ?>" />
                        <span class="info">
                            <?php echo $row["Luogo"] ?>
                            <br />
                            <?php echo $row["Data"] ?>
                            <br />
                            €<?php $prezzo = $row["Prezzo"];
                                echo number_format($prezzo, 2) ?>
                        </span>
                    </div>
                    <span class="title"><?php echo $row["Nome"] ?> </span>
                </div>
                <?php $row = $eventi["3"];
                $id = $row["ID"]; ?>
                <div class="evento" onclick="apriEvento(<?php echo $id ?>)">
                    <div class="blur_img">
                        <img src="<?php echo $row["Img"] ?>" />
                        <img src="<?php echo $row["Img"] ?>" />
                        <span class="info">
                            <?php echo $row["Luogo"] ?>
                            <br />
                            <?php echo $row["Data"] ?>
                            <br />
                            €<?php $prezzo = $row["Prezzo"];
                                echo number_format($prezzo, 2) ?>
                        </span>
                    </div>
                    <span class="title"><?php echo $row["Nome"] ?> </span>
                </div>
            </div>
        </div>

        <!-- ============= FOOTER ============= -->
        <footer>
            <div class="container">
                <!-- about us -->
                <div class="sec aboutus">
                    <h8>About Us</h8>
                    <p>LiveXperience è specializzato nella vendita di biglietti <br>
                        per eventi di musica, cultura e sport, <br>
                        rivolto a qualsiasi tipo di utente che vuole vivere le emozioni <br>
                        di partecipare a un evento pubblico acquistando il proprio biglietto <br>
                        in modo facile e sicuro.</p>
                </div>
                <!-- link utili -->
                <div class="sec link">
                    <h8>Link Utili</h8>
                    <ul>
                        <li><a href="https://www.garanteprivacy.it/documents/10160/0/Regolamento+UE+2016+679.+Arricchito+con+riferimenti+ai+Considerando+Aggiornato+alle+rettifiche+pubblicate+sulla+Gazzetta+Ufficiale++dell%27Unione+europea+127+del+23+maggio+2018">Privacy</a></li>
                        <li><a href="#">Informative Cookie</a></li>
                    </ul>
                </div>
                <!-- contatti -->
                <div class="sec contatti">
                    <h8>Contatti</h8>
                    <ul class="info">
                        <li>
                            <span><i class="fas fa-envelope" aria-hidden="true"></i></span>
                            <p><a href="mailto:livexperience123@gmail.com">livexperience123@gmail.com</a></p>
                        </li>
                        <li>
                            <span><i class="fas fa-phone" aria-hidden="true"></i></span>
                            <p><a href="tel:080612224">080 612 224</a><br>
                                <a href="tel:332622778">+39 332 622 778</a>
                            </p>
                        </li>
                        <li>
                            <span><i class="fas fa-balance-scale" aria-hidden="true"></i></span>
                            <p> PIVA: 12345678910</p>
                        </li>
                    </ul>
                </div>
            </div>

        </footer>
        <!-- ========= COPYRIGHT ========= -->
        <div class="copyright">
            <p>Copyright © 2021 | Tutti i diritti sono riservati.</p>
        </div>


    </body>

</html>