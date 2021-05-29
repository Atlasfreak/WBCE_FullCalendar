<?php
// Prevent file from being executed
if(!defined('WB_PATH')) die(header('Location: index.php'));

if (defined('WB_URL')) {
    // Drop preexisting table
    $mod_drop_table = "DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_fullcalendar`";
    $database->query($mod_drop_table);

    // Create table
    $mod_create_table = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."mod_fullcalendar` ("
        . "`section_id` INT NOT NULL DEFAULT '0',"
        . "`page_id` INT NOT NULL DEFAULT '0',"
        . "`cal_urls` TEXT NOT NULL DEFAULT '".WB_URL."/modules/fullcalendar/calendars/exapmle.ics',"
        . "`cache_time` INT NOT NULL DEFAULT 120,"
        . "`week_numbers` TINYINT(1) NOT NULL DEFAULT 1,"
        . "`recently_modified` TINYINT(1) NOT NULL DEFAULT 1,"
        . "PRIMARY KEY (section_id)"
        . ")";
    $database->query($mod_create_table);
    if(!file_exists(dirname(__FILE__)."/cache")) mkdir(dirname(__FILE__)."/cache");
}

?>