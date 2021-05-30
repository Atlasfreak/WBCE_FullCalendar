<?php

// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: index.php'));

// delete the module database table
$database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_fullcalendar`");