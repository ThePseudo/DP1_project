<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/base/settings.php");
$getPageBase = function ($title) use ($timeOut) {
    $loggedIn = false;
    session_start();
    if (isset($_SESSION['id'])) {
        if (isset($_COOKIE['time'])) {
            if (time() - $_COOKIE['time'] > $timeOut) {
                session_unset();
                session_destroy();
                session_start();
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

        <link href=<?= "\"//" . $_SERVER['SERVER_NAME'] . "/base/style.css\"" ?> rel=" stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

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
                <a href=<?= "\"//" . $_SERVER['SERVER_NAME'] . "\"" ?>>
                    Home</a>
                <a href=<?= "\"//" . $_SERVER['SERVER_NAME'] . "/login.php\"" ?>>
                    Log in</a>
                <a href=<?= "\"//" . $_SERVER['SERVER_NAME'] . "/registration.php\"" ?>>
                    Registration</a>
            <?php
        } else {
            ?>
                <a href=<?= "\"//" . $_SERVER['SERVER_NAME'] . "\"" ?>>
                    Home</a>
                <a href=<?= "\"//" . $_SERVER['SERVER_NAME'] . "/personal.php\"" ?>>
                    Personal page</a>
                <a href=<?= "\"//" . $_SERVER['SERVER_NAME'] .
                            "/actions/action_logout.php\"" ?> style="bottom:0px">
                    Logout</a>
            <?php
        }
        ?>
        </div>

        <script>
            $(document).ready(function() {
                $(window).resize();
                $("#main").css("display", "block");
                if (!navigator.cookieEnabled) {
                    var invite =
                        "<h1 style=\"text-align:center;margin-top:50px\">You don't have cookies enabled.</h1>" +
                        "<p style=\"text-align:center\">Please, enable cookies to enjoy the website experience</p>"
                    document.getElementById("main").innerHTML = invite;
                }
            })

            $(window).resize(function() {
                if ($(window).width() > 768) {
                    document.getElementById("sidenav").style.width = "15%";
                    document.getElementById("navOpener").style.visibility = "hidden";
                    document.getElementById("navOpener").style.marginLeft = "-2000px";
                    document.getElementById("main").style.marginLeft = "17%";
                } else {
                    document.getElementById("sidenav").style.width = "0%";
                    document.getElementById("navOpener").style.visibility = "visible";
                    document.getElementById("navOpener").style.marginLeft = "15px";
                    document.getElementById("main").style.marginLeft = "0px";

                }
            });

            /* Set the width of the side navigation to 250px and the left margin 
            of the page content to 250px and add a black background color to body */
            function openNav() {
                document.getElementById("sidenav").style.width = "100%";
                // used if we want to move the content of the main
                //document.getElementById("main").style.marginLeft = "80%";
                document.getElementById("navOpener").style.marginLeft = "-2000px";
            }

            /* Set the width of the side navigation to 0 and the left margin 
            of the page content to 0, and the background color of body to white */
            function closeNav() {
                document.getElementById("sidenav").style.width = "0px";
                document.getElementById("main").style.marginLeft = "0px";
                document.getElementById("navOpener").style.marginLeft = "15px";
            }
        </script>
        <noscript>
            <div class="noscriptmsg">
                <h1 style="text-align:center;margin-top:50px">
                    You don't have Javascript enabled.</h1>
                <p style="text-align:center">
                    Please, enable Javascript to enjoy the website experience</p>
            </div>
        </noscript>
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