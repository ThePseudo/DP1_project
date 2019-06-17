<?php
require_once("settings.php");

function cookiesEnabled()
{
    setcookie("testCookies", "true", time() + 3600, "/");
    if (count($_COOKIE) > 0) {
        return true;
    }
    return false;
}

$getPageBase = function ($title) use ($timeOut) {
    $loggedIn = false;
    if (session_status() == PHP_SESSION_NONE)
        session_start();
    if (isset($_SESSION['id'])) {
        if (isset($_COOKIE['time'])) {
            if (time() - $_COOKIE['time'] > $timeOut) {
                session_unset();
                session_destroy();
                header("Location: ../");
            } else {
                setcookie("time", time(), 0, "/");
                $loggedIn = true;
            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en-US">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>

        <link href="base/style.css" rel=" stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="base/scripts.js"></script>

    </head>

    <body>

        <h1 class="header">
            PlaneR
        </h1>
        <span id="navOpener" class="openNavButton visibleIfSmall" onclick="openNav()">&#9776;
        </span>

        <!-- Use any element to open the sidenav -->
        <div class="sidenav" id="sidenav">
            <a href="javascript:void(0)" class="closebtn visibleIfSmall" onclick="closeNav()">&times;</a>
            <?php
            if (!$loggedIn) {
                ?>
                <a href="index.php">Home</a>
                <a href="login.php">Log in</a>
                <a href="registration.php">Registration</a>
            <?php
        } else {
            ?>
                <h1 class="loggedInText"><?= $_SESSION['email'] ?></h1>
                <a href="index.php">Home</a>
                <a href="personal.php">Personal page</a>
                <a href="actions/action_logout.php">Logout</a>
            <?php
        }
        ?>
        </div>

        <script>
            function areCookiesEnabled() {
                try {
                    document.cookie = 'cookietest=1';
                    var cookiesEnabled = document.cookie.indexOf('cookietest=') !== -1;
                    document.cookie = 'cookietest=1; expires=Thu, 01-Jan-1970 00:00:01 GMT';
                    return cookiesEnabled;
                } catch (e) {
                    return false;
                }
            }

            $(document).ready(function() {
                $(window).resize();
                $("#main").css("display", "block");
                if (!areCookiesEnabled()) {
                    var invite =
                        "<h1 style=\"text-align:center;margin-top:50px\">You don't have cookies enabled.</h1>" +
                        "<p style=\"text-align:center\">Please, enable cookies to enjoy the website experience</p>"
                    $("#main").html(invite);
                }

            });

            $(window).resize(function() {
                if ($(window).width() > 768) {
                    document.getElementById("sidenav").style.width = "15%";
                    document.getElementById("navOpener").style.visibility = "hidden";
                    document.getElementById("navOpener").style.marginLeft = "-2000px";
                    document.getElementById("sidenav").style.opacity = "0.9";
                } else {
                    document.getElementById("sidenav").style.width = "0%";
                    document.getElementById("navOpener").style.visibility = "visible";
                    document.getElementById("navOpener").style.marginLeft = "15px";
                    document.getElementById("sidenav").style.opacity = "1";

                }
            });

            /* Set the width of the side navigation to 250px and the left margin 
            of the page content to 250px and add a black background color to body */
            function openNav() {
                document.getElementById("sidenav").style.width = "100%";
                document.getElementById("navOpener").style.marginLeft = "-2000px";
            }

            /* Set the width of the side navigation to 0 and the left margin 
            of the page content to 0, and the background color of body to white */
            function closeNav() {
                document.getElementById("sidenav").style.width = "0px";
                document.getElementById("navOpener").style.marginLeft = "15px";
            }

            <?php
            if ($loggedIn) : ?>
                // inactivity periods. Useless if not logged in, so avoiding checks if not necessary
                $(document).bind("change select keydown keypress keyup error resize scroll unload click mousedown mouseup mousemove", function(e) {

                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && (this.status == 200 || this.status == 0)) {
                            if (this.responseText === "NOK") {
                                location.reload(true);
                            }
                        }
                    };
                    xhttp.open("POST", "actions/ajax/updateSession.php", true);
                    xhttp.send();

                });
            <?php endif ?>
        </script>
        <noscript>
            <div class="noscriptmsg">
                <h1 style="text-align:center;margin-top:100px">
                    You don't have Javascript enabled.</h1>
                <p style="text-align:center">
                    Please, enable Javascript to enjoy the website experience</p>
            </div>
        </noscript>
        <div class="mainBG">
        </div>

        <div id="main" class="main">
        <?php
    };

    function closeHTML()
    {
        ?>
        </div>
    </body>

    </html>

<?php
}
?>