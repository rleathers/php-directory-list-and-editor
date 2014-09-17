<?php
function m($string)
{
    $realpath = realpath($string);
    $dirarries = scandir($realpath);
    ?>
    <form method="post" class="dirmdr" id="dirformmdr"></form>
    <form method="post" class="dirmdr" id="fileformmdr" action="mrfiles/editor.php5"></form>
    <ul class="dirmdrul">
    <?php
    foreach ($dirarries as $mdir)
    {

        if(strlen($realpath) <= 4 )
        {
            $m = $realpath.$mdir;
        }
        else
        {
            $m = $realpath.'\\'.$mdir;
        }
        if(is_file($m) == true)
        {
        ?>
            <li class="dirmdrli">
                <div class="dirmdrdiv">
                    <label>
                        <input type="submit" name="mdir" form="fileformmdr" class="dirmdrinput" value="<?php echo ($m)?>">
                    </label>
                </div>
            </li>
        <?php
        }
        else
        {
        ?>
            <li class="dirmdrli">
                <div class="dirmdrdiv">
                    <label>
                        <input type="submit" name="mdir" form="dirformmdr" class="dirmdrinput" value="<?php echo ($m)?>">
                    </label>
                </div>
            </li>
        <?php
        }
    }

    ?>
    </ul>
    <?php
}