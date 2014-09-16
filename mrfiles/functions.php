
<?php
    function dirlist( $getpatharray )
    {
        $hardpath = realpath('.');
        $hardpath .= '\\';
        $webpath = $_SESSION['url'];

        foreach( $getpatharray as $key => $value)
        {
            $webpath .= $key;
            $webpath .= '/';
            $hardpath .= $key;
            $hardpath .= '\\';
        }
        $dirarray = scandir($hardpath);
        unset( $dirarray[1] );
        unset( $dirarray[0] );
        foreach ( $dirarray as $adir )
        {
            $ffpath = $hardpath . $adir;
            $webpathtemp = $webpath . $adir;
            if ( is_file( $ffpath ) === true)// is a file
            {
                $pathedit = $ffpath;
                $ffpath = substr_replace($ffpath, 'file:\\\\\\', 0, 0);
                echo <<<HTML
                <a href="mrfiles/editor.php5?path=$pathedit&bpen=true&weburl=$webpathtemp" target="_blank">$adir &nbsp&nbsp&nbsp&nbsp&nbsp - edit file</a>|
                <a href="$webpathtemp">web url </a>|
                <a href="$ffpath">hard file path.</a>
HTML;
            }
            else// is a folder
            {
                $createurlParameter = "";
                foreach ( $_GET as $key => $dir )
                {
                    $createurlParameter .= $key;
                    $createurlParameter .= '=';
                    $createurlParameter .= $dir;
                    $createurlParameter .= "&";
                }
                $createurlParameter .= $adir;
                $createurlParameter .= "=forward";
                echo <<<HTML
                <a href="mdr.php5?$createurlParameter">$adir</a>
HTML;
            }
            echo '<br>';
        }
    }
?>

<?php
function m($string = '.')
{
    $realpath = realpath($string);
    $dirarries = scandir($realpath);

    ?>
    <form method="post">
    <?php

    foreach ($dirarries as $mdir)
    {
        ?>
        <label><input type="submit" value="<?php echo $mdir?>"></label>
        <?php
    }

    ?>
    </form>
    <?php


}