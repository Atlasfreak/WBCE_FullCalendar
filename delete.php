<?php
// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: index.php'));

require("database.php");

//	delete the row of the module table which contains the actual page
$database->query("DELETE FROM `".$fc_db::DB_TABLE_NAME."` WHERE `section_id` = '$section_id'");