<?php

// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: index.php'));

require("database.php");

// delete the module database table
$fc_db->db_drop_table();