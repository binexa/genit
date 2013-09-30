<?php
$pos = strrpos($file, '.php');
$file = substr($file, 0, $pos);
$pos = strrpos($file, '%');
$file = substr($file, $pos+1);
$this->assign('file_name', $file)
?>
