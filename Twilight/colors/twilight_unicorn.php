#!/usr/bin/php
<?php
$dir = dirname(__FILE__);
$dir_files = scandir($dir);
$files = array();
$maxw = 0;
$maxh = 0;
foreach($dir_files as $file)
{
    if ( strpos($file,";") !== false )
    {
        $curr_file = file("$dir/$file",FILE_IGNORE_NEW_LINES);
        $files[$file] = $curr_file;
        foreach($curr_file as $line)
        {
            $w = strlen($line);
            if ( $w> $maxw )
                $maxw = $w;
        }
        $h = count($curr_file);
        if ( $h > $maxh )
            $maxh = $h;
    }
}

$chars=array_fill(0,$maxh,array_fill(0,$maxw,null));

foreach ( $files as $color => $lines )
    for ( $i = 0; $i < $maxh; $i++ )
    {
        for ( $j = 0, $l = strlen($lines[$i]); $j < $l; $j++ )
        {
            if ( $lines[$i][$j] != ' ' )
                $chars[$i][$j] = array("color"=>$color,"char"=>$lines[$i][$j]);
        }
    }
    
foreach($chars as $line)
{
    foreach($line as $char)
    {
        if ( is_null($char) )
            echo ' ';
        else
            echo "\x1b[$char[color]m$char[char]";
    }
    echo "\n";
}
echo "\x1b[0m\n";
