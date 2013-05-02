<?php

if (!is_writable($tempdir))
{
    echo  "<li class='errortitle'>".sprintf(gT("Tempdir %s is not writable"),$tempdir)."<li>";
}
if (!is_writable(Yii::app()->basePath.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'update.php'))
{
    echo  "<li class='errortitle'>".sprintf(gT("Updater file is not writable (%s). Please set according file permissions."),DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'update.php')."</li>";
}

if ($httperror != '')
{
    print( $httperror );
}

if (!$updater_exists)
{
    eT('There was a problem downloading the updater file. Please try to restart the update process.').'<br />';
}

?>
