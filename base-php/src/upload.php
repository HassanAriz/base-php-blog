<?php
/**
 * Created by PhpStorm.
 * User: likwi
 * Date: 08/11/2018
 * Time: 14:01
 */



$repertory = 'upload/';
$file = basename($_FILES['file']['name']);
$max_size = 10;
$size = filesize($_FILES['file']['tmp_name']);
$extensions = array('.jpeg', '.jpg');
$extension = strrchr($_FILES['file']['name'], '.');
//security verification...
if(!in_array($extension, $extensions)) //If the extention isn't in the table
{
    $error = 'Vous ne pouvez uploader qu\'un fichier de type  jpeg ou jpg';
}
if($size>$max_size)
{
    $error = 'Le fichier est trop lourd.';
}
if(!isset($erreur)) // No error -> reupload
{
    //format the file name
    $file = strtr($file,
        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    $file = preg_replace('/([^.a-z0-9]+)/i', '-', $file);
    if(move_uploaded_file($_FILES['file']['tmp_name'], $repertory . $file)) //if TRUE -> IT WORKS
    {
        echo 'IT WORKS';
    }
    else //else -> FALSE
    {
        echo 'IT WORKS pas';
    }
}
else
{
    echo $error;
}
?>