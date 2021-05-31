<?php
/**
 *
 * @category        page
 * @package         External Calendar
 * @authors         Per Göttlicher
 * @copyright       2021-, Per Göttlicher (Atlasfreak)
 * @link
 * @license         https://www.gnu.org/licenses/gpl-3.0.html
 * @platform        WBCE 1.5.x
 *
 **/
if(!defined('WB_PATH')) die(header('Location: index.php'));

class FCDatabase {
    const DB_TABLE_NAME = TABLE_PREFIX."mod_fullcalendar";

    const CURRENT_DB_FIELDS = array(
        "cal_urls"          => "TEXT NOT NULL DEFAULT '".WB_URL."/modules/fullcalendar/calendars/example.ics'",
        "cache_time"        => "INT NOT NULL DEFAULT 120",
        "week_numbers"      => "TINYINT(1) NOT NULL DEFAULT 1",
        "recently_modified" => "TINYINT(1) NOT NULL DEFAULT 1",
    );
    const DEPRECATED_FIELDS = array(

    );

    public function db_drop_table() {
        global $database;
        $database->query("DROP TABLE IF EXISTS `".$this::DB_TABLE_NAME."`");
    }

    public function db_add_fields() {
        global $database, $admin;
        $prev_field = "page_id";

        foreach($this::CURRENT_DB_FIELDS as $field_name => $type) {
            if (!$database->field_exists($this::DB_TABLE_NAME,$field_name)){
                if(!($database->field_add($this::DB_TABLE_NAME,$field_name,$type." AFTER `".$prev_field."`")) ){
                    $admin->print_error( $database->get_error() );
                }
            } else {
                if(!($database->field_modify($this::DB_TABLE_NAME,$field_name,$type)) ){
                    $admin->print_error( $database->get_error() );
                }
            }
            print ".";
            $prev_field = $field_name;
        }
    }

    public function db_get_data($section_id) {
        global $database;
        $statement = "SELECT * FROM `".$this::DB_TABLE_NAME."` WHERE `section_id` = '$section_id'";
        $query = $database->query($statement);
        return $query->fetchRow();
    }

    public function db_add_row($column = "", $data = array()) {
        global $database;
        $result = $database->updateRow($this::DB_TABLE_NAME, $column, $data);
        return $result;
    }
}
$fc_db = new FCDatabase();