<?php
/**
 *
 * @package         FullCalendar
 * @authors         Per Göttlicher
 * @copyright       2021-, Per Göttlicher (Atlasfreak)
 * @link            https://github.com/Atlasfreak/WBCE_FullCalendar
 * @license         https://www.gnu.org/licenses/gpl-3.0.html
 * @platform        WBCE 1.5.x
 *
 **/
if(!defined('WB_PATH')) die(header('Location: index.php'));

require("database.php");

print "<div><h4>Deleting old fields</h4>\n";

foreach($fc_db::DEPRECATED_FIELDS as $field_name => $type) {
    if ($database->field_exists($fc_db::DB_TABLE_NAME,$field_name)){
        if(!($database->field_remove($fc_db::DB_TABLE_NAME,$field_name)) ){
            $admin->print_error( $database->get_error() );
        }
    }
    print ".";
}

print "\n<h4>Adding new fields</h4>\n";

$fc_db->db_add_fields();

print "\n<h4>Finished</h4></div>\n";