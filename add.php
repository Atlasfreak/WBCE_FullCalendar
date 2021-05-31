<?php
// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: index.php'));

require("database.php");

//	add a new row to the module table which contains the actual page_id and section_id
$data = array(
    "page_id"       => $page_id,
    "section_id"    => $section_id,
);
$fc_db->db_add_row("section_id", $data);
