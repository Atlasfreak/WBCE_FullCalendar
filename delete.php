<?php
// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: index.php'));

//	delete the row of the module table which contains the actual page
$database->query("DELETE FROM `" .TABLE_PREFIX ."mod_fullcalendar` WHERE `section_id` = '$section_id'");