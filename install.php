<?php
// Prevent file from being executed
if(!defined('WB_PATH')) die(header('Location: index.php'));

require("database.php");

if (defined('WB_URL')) {
    // Drop preexisting table
    $fc_db->db_drop_table();

    // Create table
    $mod_create_table = "CREATE TABLE IF NOT EXISTS `".$fc_db::DB_TABLE_NAME."` ("
        . "`section_id` INT NOT NULL DEFAULT '0',"
        . "`page_id` INT NOT NULL DEFAULT '0',"
        . "PRIMARY KEY (section_id)"
        . ")";
    $database->query($mod_create_table);

    $fc_db->db_add_fields();

    $data = array(
        "section_id"        => 0,
        "cal_urls"          => " ",
        "cach_time"         => " ",
        "week_numbers"      => 1,
        "recently_modified" => 0,
    );

    $result = $fc_db->db_add_row("section_id", $data);

    if(!file_exists(dirname(__FILE__)."/cache")) mkdir(dirname(__FILE__)."/cache");
}