<!DOCTYPE html>
<html class="htmlid">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mdr.css">
    <title>mdr</title>
</head>
</html>

<?php
session_start();
if ( isset ( $_SESSION['login'] ) === false )
{
    $ur = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $ur = str_replace('mrfiles/editor.php5','mdr.php5',$ur);
    session_destroy();
    header("Location: $ur");
    die();
}
if ( $_SESSION['login'] === -1 )
{
    $ur = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $ur = str_replace('mrfiles/editor.php5','mdr.php5',$ur);
    session_destroy();
    header("Location: $ur");
    die();
}
if (isset ( $_POST['logout'] ) === true)
{
    session_destroy();
    header("Location: $ur");
}
?>

<?php
if(isset( $_POST['mdir'] ) === true)
{
    $textp = file_get_contents( $_POST['mdir'] );
    file_put_contents("out.php5" , $textp);
    $_SESSION['mdir'] = $_POST['mdir'];
}
if(isset($_SESSION['mdir']) === false)
{
    $_POST['mdir'] = realpath('.');
    $_POST['mdir'] .= '\\out.php5';
    $textp = file_get_contents( $_POST['mdir'] );
    file_put_contents("out.php5" , $textp);
    $_SESSION['mdir'] = $_POST['mdir'];
}
if(isset( $_POST['save'] ) === true)
{
    file_put_contents( $_SESSION['mdir'] , $_POST['textarea'] );
}

if(isset( $_POST['apply'] ) === true)
{
    file_put_contents("out.php5" , $_POST['textarea']);
}

$text = file_get_contents("out.php5");
?>
<div class="dirmdrdiv">
    <form id="mdrformid" method="post">
        <input class="inputws" type="submit" name="apply" value="Apply">
        <input class="inputws" type="submit" name="save" value="save">
        <input class="inputws" type="submit" name="logout" value="logout">
    </form>
</div>

<div style="padding: 5px; padding-top: 15px">
<?php echo $_SESSION['mdir']?>
</div>

<label>
    <textarea name="textarea" form="mdrformid" class="editor" rows="20"><?php echo $text?></textarea>
</label>
<iframe src="out.php5" class="miframe"></iframe>
