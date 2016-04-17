<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Single signon for LimeSurvey
 */

/* Need to have cookie visible from parent directory */
session_set_cookie_params(0, '/', '', false);
/* Create signon session */
$session_name = 'SignonSession';
session_name($session_name);
// Uncomment and change the following line to match your $cfg['SessionSavePath']
//session_save_path('/foobar');
session_start();

/* Was data posted? */
if (isset($_POST['user'])) {
    /* Store there credentials */

    //$_SESSION['LS_single_signon_user'] = $_POST['user'];
    //$_SESSION['LS_single_signon_password'] = $_POST['password'];

    setcookie('LS_single_signon_user', $_POST['user'], time() + 60, '/');
    setcookie('LS_single_signon_password', $_POST['password'], time() + 60, '/');

    $id = session_id();
    /* Close that session */
    session_write_close();
    /* Redirect to phpMyAdmin (should use absolute URL here!) */
    header('Location: ./index.php/admin/');
} else {
    /* Show simple form */
    header('Content-Type: text/html; charset=utf-8');
    echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
    ?>
    <!DOCTYPE HTML>
    <html lang="en" dir="ltr">
    <head>
    <link rel="icon" href="../favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <meta charset="utf-8" />
    <title>LimeSurvey single signon</title>
    </head>
    <body>
    <?php
    if (isset($_SESSION['LS_single_signon_error_message'])) {
        echo '<p class="error">';
        echo $_SESSION['LS_single_signon_error_message'];
        echo '</p>';
    }
    ?>
    <form action="signon.php" method="post">
    Username: <input type="text" name="user" /><br />
    Password: <input type="password" name="password" /><br />
    <input type="submit" />
    </form>
    </body>
    </html>
    <?php
}
?>
