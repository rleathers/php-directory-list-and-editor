<?php
function m($string)
{
    $realpath = realpath($string);
    $dirarries = scandir($realpath);

    ?>
    <form method="post">
    <?php

    foreach ($dirarries as $mdir)
    {
        ?>
        <label><input type="submit" name="mdir" value="<?php echo $mdir?>"></label>
        <?php
    }

    ?>
    </form>
    <?php
}