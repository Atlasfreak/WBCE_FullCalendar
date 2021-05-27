<?php
// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: index.php'));

//	add a new row to the module table which contains the actual page_id and section_id
$database->query("INSERT INTO `" .TABLE_PREFIX ."mod_fullcalendar` (`page_id`, `section_id`) VALUES ('$page_id', '$section_id')");

?>