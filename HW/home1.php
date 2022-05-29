<?php
    require_once 'authentication.php';

    if (!$userid = authenticate())
    {
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>HW - HOME</title>
        <link rel="stylesheet" href="home-css.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
        <script src="https://kit.fontawesome.com/87e20f3ca7.js" crossorigin="anonymous"></script>
        <script defer="true" src="home-js.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
    </head>
    <body>
        <article>
            <header>
                <nav>
                    <ul class="menu">
                        <div>
                            <li class="logo"><a href="home1.php">PostZap</a></li>
                        </div>
                        <div>
                            <li><input type="text" class="search-box" placeholder="Cerca un contenuto"></li>
                        </div>
                        <div id="last-menu-block">
                            <li id="openModalBtn" class="menu-element btn"><a href="#">Nuovo Post</a></li>
                            <!-- <li class="menu-element btn profile"><a href="profile.php?q=myProfile"></a></li> -->
                            <li class="menu-element btn secondary"><a href="logout.php">Esci</a></li>
                        </div>
                    </ul>
                </nav>
            </header>
            <section>
                <div class="persProfile">
                    <a href="profile.php">Profilo</a>
                </div>
            </section>
            <div class="modal">
                <div class="modal-content">
                    <div class="header-modal">
                        <span class="close-modal"></span>
                    </div>
                    <div class="unsplash-section-modal hidden">
                        <div class="search-unsplash">
                            <input type="text" class="search-box" placeholder="Cerca un contenuto in inglese (Premere invio per cercare)">
                        </div>
                        <div class="container">
                        </div>
                        <div class="modal-btn confirm">Fatto</div>
                    </div>
                    <div class="body-modal">
                        <div class="title">
                            <h1>Crea un nuovo post!</h1>
                        </div>
                        <div class="main">
                            <h4>Descrizione <span class="info">(max. 255 caratteri)</span></h4>
                            <textarea placeholder="Inserisci una descrizione" class="max255"></textarea>
                            <h4>Inserisci un'immagine tramite</h4>
                            <div class="modal-btn"><i class="fa-brands fa-unsplash"></i> Unsplash</div>
                            <p class="error hidden">Inserisci un'immagine con unsplash!</p>
                            <div class="modal-btn submit" data-active="0">Crea Post</div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </body>
</html>