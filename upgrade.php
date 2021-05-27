<?php
/**
 *
 * @category        page
 * @package         External Calendar
 * @version         0.1
 * @authors         Per Göttlicher
 * @copyright       2021-, Per Göttlicher (Atlasfreak)
 * @link
 * @license         https://www.gnu.org/licenses/gpl-3.0.html
 * @platform        WBCE 1.5.x
 *
 **/
if(!defined('WB_PATH')) die(header('Location: index.php'));

$CURRENT_DB_FIELDS = array(
    "cal_urls"          => "TEXT NOT NULL",
    "cache_time"        => "INT NOT NULL DEFAULT 120",
    "week_numbers"      => "TINYINT(1) NOT NULL DEFAULT 1",
    "recently_modified" => "TINYINT(1) NOT NULL DEFAULT 1",
);

$DEPRECATED_FIELDS = array(

);

$table_name = TABLE_PREFIX."mod_fullcalendar";

print "<div><h4>Deleting old fields</h4>\n";

foreach($DEPRECATED_FIELDS as $field_name => $type) {
    if ($database->field_exists($table_name,$field_name)){
        if(($database->field_remove($table_name,$field_name)) ){
            print "-";
        } else {
            $admin->print_error( $database->get_error() );
        }
    } else {
        print "-";
    }
}

print "\n<h4>Adding new fields</h4>\n";

$prev_field = "page_id";

foreach($CURRENT_DB_FIELDS as $field_name => $type) {
    if (!$database->field_exists($table_name,$field_name)){
        if(($database->field_add($table_name,$field_name,$type." AFTER `".$prev_field."`")) ){
            print "-";
        } else {
            $admin->print_error( $database->get_error() );
        }
    } else {
        print "-";
    }
    $prev_field = $field_name;
}
print "\n<h4>Finished</h4></div>\n";