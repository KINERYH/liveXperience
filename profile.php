<?php
session_start();
// $check = (!isset($_SESSION['infoUtente']) || empty($_SESSION['infoUtente']));
if (!isset($_SESSION['infoUtente'])) { //Non riporta l'errore
    error_reporting(0);
    $valAdmin = 0;
    header("location:login.php"); // Se non sono loggato mi porta alla pagina del login
} else {
    $info = $_SESSION["infoUtente"]; //Mi da le informazioni dell'utente loggato
    $valAdmin = $info["isAdmin"];
}
if (empty(isset($_SESSION['infoUtente']))) {
    $session = "0";
} else {
    $session = isset($_SESSION['infoUtente']);
}

if (isset($_GET["change"])) {
    $isChanged = $_GET["change"];
} else {
    $isChanged = '0';
}

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

// Aggiorno le informazioni dell'utente se ho modificato la password
if ($isChanged == 1) {
    $email = $info["Mail"];
    $sql = "SELECT * FROM utente WHERE Mail = '$email'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $_SESSION['infoUtente'] = $row;
    }
    header("location: profile.php");
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo | liveXperience</title>
    <!-- ============= RESET STYLE ============= -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" integrity="sha512-NmLkDIU1C/C88wi324HBc+S2kLhi08PN5GDeUVVVC/BVt/9Izdsc9SVeVfA1UZbY3sHUlDSyRXhCzHfr6hmPPw==" crossorigin="anonymous" />
    <!-- ============= STYLE ============= -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/profile.css">
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
    <script src="main.js"></script>
    <!-- ============ SweetAlert =================-->
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>     SWEETALERT1 ORIGINALE -->
    <script src="sweetalert2.all.min.js"></script>
    <script src="crypto.js"></script>
</head>

<body onload="onLoad(<?php echo $session ?>, <?php echo $valAdmin ?>)">
    <!-- ============= HEADER ============= -->
    <header>
        <div class="hamburger">
            <i class="fas fa-bars" onclick="openLeftMenu()"></i>
        </div>
        <!-- logo -->
        <div class="logo">
            <a href="index.php">
                liveXperience
            </a>
        </div>
        <!-- barra di ricerca -->
        <div class="search-container">
            <div class="dropdown">
                <button class="dropBtn">Categorie <i class="fa fa-caret-down"></i></button>
                <div class="dropdown_content">
                    <a href="php/search.php?Categoria=Musica"><i class="fas fa-microphone-alt"></i> &nbsp;Concerti</a>
                    <a href="php/search.php?Categoria=Sport"><i class="fas fa-futbol"></i> &nbsp;Sport</a>
                    <a href="php/search.php?Categoria=Teatro"><i class="fas fa-theater-masks"></i> &nbsp;Teatro</a>
                    <a href="php/search.php?Categoria=Musei"><i class="fas fa-atom"></i> &nbspMostre e Musei</a>
                </div>
            </div>
            <form action="php/search.php" method="GET">
                <input name="search_bar" type="text" placeholder="Cerca il tuo evento" name="search">
                <button type="submit"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyLjAwNSA1MTIuMDA1IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIuMDA1IDUxMi4wMDU7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxnPg0KCTxnPg0KCQk8cGF0aCBkPSJNNTA1Ljc0OSw0NzUuNTg3bC0xNDUuNi0xNDUuNmMyOC4yMDMtMzQuODM3LDQ1LjE4NC03OS4xMDQsNDUuMTg0LTEyNy4zMTdjMC0xMTEuNzQ0LTkwLjkyMy0yMDIuNjY3LTIwMi42NjctMjAyLjY2Nw0KCQkJUzAsOTAuOTI1LDAsMjAyLjY2OXM5MC45MjMsMjAyLjY2NywyMDIuNjY3LDIwMi42NjdjNDguMjEzLDAsOTIuNDgtMTYuOTgxLDEyNy4zMTctNDUuMTg0bDE0NS42LDE0NS42DQoJCQljNC4xNiw0LjE2LDkuNjIxLDYuMjUxLDE1LjA4Myw2LjI1MXMxMC45MjMtMi4wOTEsMTUuMDgzLTYuMjUxQzUxNC4wOTEsNDk3LjQxMSw1MTQuMDkxLDQ4My45MjgsNTA1Ljc0OSw0NzUuNTg3eg0KCQkJIE0yMDIuNjY3LDM2Mi42NjljLTg4LjIzNSwwLTE2MC03MS43NjUtMTYwLTE2MHM3MS43NjUtMTYwLDE2MC0xNjBzMTYwLDcxLjc2NSwxNjAsMTYwUzI5MC45MDEsMzYyLjY2OSwyMDIuNjY3LDM2Mi42Njl6Ii8+DQoJPC9nPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=" height="13px" width="13px" /></button>
            </form>
        </div>

        <!-- utility per il profilo + carrello-->
        <ul class="profile">

            <div id="ciaoIndex">
                <p id="ciao"><?php echo "Ciao " . $info["Nome"] . " " . $info["Cognome"] . "!" ?></p>
            </div>
            <li><a href="add_event.php" id="add_event"><button><i class="fas fa-plus"> AGGIUNGI EVENTO</i></button></a></li>
            <li><a href="profile.php" id="profile"><button><i class="fas fa-user"></i></button></a></li>
            <!-- carrello -->
            <li>
                <div class="slide" id="carrello">
                    <button onclick="openSlideMenu()"><i class="fas fa-shopping-cart"></i></button>
                </div>
            </li>
        </ul>
    </header>

    <body onload="nascondoBtn( <?php echo (isset($_SESSION['infoUtente'])) ?>)">

        <!-- ========= LEFT MENU ========== -->
        <div id="left_menu">
            <!-- logo e chiusura -->
            <div class="space_between">
                <div class="logo">
                    <a href="index.php">
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
                    <a href="php/search.php?Categoria=Musica">
                        <li>
                            <i class="fas fa-microphone-alt"></i> &nbsp;Concerti
                        </li>
                    </a>
                    <a href="php/search.php?Categoria=Sport">
                        <li>
                            <i class="fas fa-futbol"></i> &nbsp;Sport
                        </li>
                    </a>
                    <a href="php/search.php?Categoria=Teatro">
                        <li>
                            <i class="fas fa-theater-masks"></i> &nbsp;Teatro
                        </li>
                    </a>
                    <a href="php/search.php?Categoria=Musei">
                        <li>
                            <i class="fas fa-atom"></i> &nbsp;Mostre e Musei
                        </li>
                    </a>
                    <li>
                        <form action="php/search.php" method="GET">
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
                    <a href="php/logout.php">
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

        <!-- ============= BODY ============= -->
        <div class="profile-body">
            <div id="profile-sx" class="profile-sx">
                <h1>Il mio profilo</h1>
                <h3 class="h3hover" onclick="arrowActive(arrow1)"> <i id="arrow1" class="fas fa-arrow-right"></i> &nbsp;Informazioni personali</h3>
                <h3 class="h3hover" onclick="arrowActive(arrow2)"> <i id="arrow2" class="fas fa-arrow-right"></i> &nbsp;I miei acquisti</h3>
                <?php $oldpass = $info["Password"]; ?>
                <h3 class="h3hover" onclick="arrowActive(arrow3); deleteAccountAlert('<?php echo $oldpass ?>')" style="color: red;"> <i id="arrow3" class="fas fa-arrow-right" style="color:black;"></i> &nbsp;Cancella registrazione</h3>
                <h3><a href="php/logout.php" class="h3hover" onclick="arrowActive(arrow4)" style="color: red;"> <i id="arrow4" class="fas fa-arrow-right" style="color:black;"></i> &nbsp;Logout</a></h3>


            </div>
            <div id="profile-dx_img" class="profile-dx_img">
                <img src="images/imgProfile.svg" alt="">
            </div>
            <div id="profile-dx_info" class="profile-dx_info">
                <div class="card-info">
                    <div class="center">
                        <img class="avatar" src="images/avatar.svg" alt="">
                    </div>
                    <h2>Nome</h2>
                    <p><?php echo $info["Nome"] ?></p>
                    <h2>Cognome</h2>
                    <p><?php echo $info["Cognome"] ?></p>
                    <h2>Data di nascita</h2>
                    <p><?php echo $info["Data_Nascita"] ?></p>
                    <h2>Email</h2>
                    <p> <?php echo $info["Mail"] ?> </p>
                    <h2>Password</h2>
                    <?php $oldpass = $info["Password"]; ?>
                    <p>***********<button onclick="changePasswordAlert('<?php echo $oldpass ?>')"><i class="fas fa-edit" style="color: rgb(202, 0, 0);"></i></button></p>
                </div>

            </div>
            <div id="profile-dx_orders" class="profile-dx_orders">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Prezzo</th>
                            <th>Data Evento</th>
                            <th>Data Acquisto</th>
                            <th>N° <span id ="bigl-none">biglietti<span></th>
                        </tr>
                    </thead>

                    <?php
                    $mail = $info["Mail"];
                    // Prendo tutti gli acquisti fatti dall'utente loggato
                    $sql = "SELECT evento.Nome, evento.Prezzo, evento.Data, acquisto.nBiglietti, acquisto.Data as DataAcquisto  FROM acquisto INNER JOIN evento ON acquisto.idEvento = evento.ID WHERE mailUtente = '$mail'";
                    $result = $conn->query($sql);
                    $acquisti = "";
                    while ($row = $result->fetch_assoc()) {
                        $timestampAcquisto = $row["DataAcquisto"];
                        $dataAcquisto = substr($dataAcquisto, 0, 10);
                        $acquisti .= "<tr><td>" . $row["Nome"] . "</td>
                        <td>€" . number_format($row["Prezzo"], 2) . "</td>
                        <td>" . $row["Data"] . "</td>
                        <td>" . $dataAcquisto . "</td>
                        <td>" . $row["nBiglietti"] . "</td></tr>";
                    }
                    ?>
                    <?php echo $acquisti ?>
                </table>
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