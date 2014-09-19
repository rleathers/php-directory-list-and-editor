<?php
function mdrmdrives()
{
    $fso = new COM('Scripting.FileSystemObject');
    $D = $fso->Drives;
    $type = array("Unknown","Removable","Fixed","Network","CD-ROM","RAM Disk");
    $mar = array();
    foreach($D as $d )
    {
        $dO = $fso->GetDrive($d);
        $mar[] .= "Drive " . $dO->DriveLetter . " | " . $type[$dO->DriveType];
    }
    return $mar;
}

function mdrfile_size($size)
{
    $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    return round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i];
}
function mdrdriveinformation()
{
    $fso = new COM('Scripting.FileSystemObject');
    $D = $fso->Drives;
    $type = array("Unknown","Removable","Fixed","Network","CD-ROM","RAM Disk");
    $mar = array();
    foreach($D as $d )
    {
        $dO = $fso->GetDrive($d);
        $s = "";
        $serial = "";
        $filesystem = "";
        if($dO->DriveType == 3)
        {
            $n = $dO->Sharename;
        }
        else if($dO->IsReady)
        {
            $n = $dO->VolumeName;
            if($n === "")
            {
                $n = "No label";
            }
            $s = mdrfile_size($dO->FreeSpace) . " free of " . mdrfile_size($dO->TotalSize);
        }
        else
        {
            $n = "[Drive not ready]";
        }
        if($s === "")
        {
            $s = "No size";
        }
        if($dO->DriveType === 2)
        {
            $serial =  " | serial number " .$dO->SerialNumber;
            $filesystem = " | " .$dO->FileSystem;
        }
        $mar[] .= "Drive " . $dO->DriveLetter . " | " . $type[$dO->DriveType] . " | " . $n . " | " . $s . $serial . $filesystem;

    }
    return $mar;
}
?>