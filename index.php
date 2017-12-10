<html>
<head>
    <title> Jar of Honey Shop </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="HU" />
    <meta name="description" content="Méhészetünk, a Jar of Honey családi vállalkozás Szabadkán, termékeink természetes alapanyagokat tartalmaznak és saját termesztésű hozzávalókkal készülnek." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="méz, akác, méhészet, méhviasz, édesítőszer" />
    <meta name="robots" content="index,follow" />
    <meta name="googlebot" content="index,follow" />
    <meta name="author" content="Bozsik Árpád & Vékony Attila" />
    <meta charset="UTF-8" >
    <meta property="og:image" content="img/honey-background.jpg" />
    <meta property="og:url" content="https://jarofhoneyshop.info" />
    <meta property="og:title" content="Jar of Honey Shop"/>
    <meta property="og:description" content="Méhészetünk, a Jar of Honey családi vállalkozás Szabadkán, termékeink természetes alapanyagokat tartalmaznak és saját termesztésű hozzávalókkal készülnek." />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="hu_HU" />
    <link rel="canonical" href="https://jarofhoneyshop.info" /> 
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="img/honeyicon.png" type="image/png" />
    <?php
    $page = (isset($_GET['page']) ? $_GET['page'] : "");

    switch($page){
        case "offers": $title="Ajánlataink"; break;
        case "contact": $title="Elérhetőségek"; break;
        case "partners": $title="Partnerek"; break;
        case "info": $title="Rólunk"; break;
        default: $title="Főoldal"; break;
    }
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109295195-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-109295195-1');
    </script>
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/responsiveslides.min.js"></script>
    <link rel="stylesheet" href="js/responsiveslides.css">
</head>
<body>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v2.11';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="container">
    <div id="top"><img src="img/creative-2984342_1920.jpg" ></div>
    <div id="header">
        <ul>
            <li><a href="index.php">Főoldal</a></li>
            <li><a name="offers" href="?page=offers">Ajánlataink</a></li>
            <li><a href="?page=partners">Partnerek</a></li>
            <li><a href="?page=contact">Elérhetőségek</a></>
            <li><a href="?page=info">Rólunk</a></li>
            <li><a name="admin" href="mindegy">Admin</a></li>
        </ul>
        <div id="left"><?php include "slider.php"; ?></div>
    </div>
    <div id="right">
        <?php
        switch($page){
            case "offers": include "offers.php"; break;
            case "contact": include "contact.php"; break;
            case "partners": include "partners.php"; break;
            case "info": include "info.php"; break;
            default: include "main.php"; break;
        }
        ?>
    </div>
    <div id="footer">
       <div class="fb-share-button" data-href="https://jarofhoneyshop.info/" data-layout="button" data-size="small" data-mobile-iframe="false"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fjarofhoneyshop.info%2F&amp;src=sdkpreparse">Megosztás</a></div>
        <?php
        $fromYear = 2017;
        $thisYear = (int)date('Y');
        echo $fromYear . (($fromYear != $thisYear) ? '-' . $thisYear : '');
        ?> Jar of Honey Shop. (Oldalunk egy iskolai projekthez készült, nem árulunk mézet!)
    </div>
</div>
</body>
</html>
