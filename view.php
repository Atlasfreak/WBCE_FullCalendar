<?php

// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: index.php'));

$lang = (dirname(__FILE__))."/languages/". LANGUAGE .".php";
require_once(!file_exists($lang) ? (dirname(__FILE__))."/languages/EN.php" : $lang);

// obtain data from module DB-table of the current displayed page (unique page defined via section_id)
$sql_result = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_fullcalendar` WHERE `section_id` = '$section_id'");
$content = $sql_result->fetchRow();

$cal_urls = $content['cal_urls'];
$cal_urls = preg_split("/[\s]+/", $cal_urls);

$cal_fpath = dirname(__FILE__)."/cache/calendars".$section_id.".ics";
$cal_local_url = WB_URL."/modules/fullcalendar/cache/calendars".$section_id.".ics";
$cal_file = false;
if (time() - filemtime($cal_fpath) > $content['cache_time'] || boolval($content['recently_modified']) || !file_exists($cal_fpath)) {
    $cal_file = fopen($cal_fpath, "w");
    $database->query("UPDATE `".TABLE_PREFIX."mod_fullcalendar` SET `recently_modified` = 0 WHERE `section_id` = '$section_id'");
}

if ($cal_file !== false) {
    fwrite($cal_file, "BEGIN:VCALENDAR \n");
    foreach ($cal_urls as $calendar) {
        if ($calendar != '') {
            if (!preg_match('/^http/',$calendar)) {
                break;
            } else {
                $debug = gethostbyname($calendar);
                $cal_from_url = file_get_contents($calendar);
                if ($cal_from_url !== false) {
                    $cal_from_url = preg_replace("/END:VCALENDAR|BEGIN:VCALENDAR/","",$cal_from_url);
                    fwrite($cal_file, $cal_from_url);
                }
                $cal_from_url = null;
            }
        }
    };
    fwrite($cal_file, "END:VCALENDAR");
    fclose($cal_file);
}
$template = new Template(WB_PATH.'/modules/fullcalendar');
$template->set_file('page', 'templates/view.htt');
$template->set_block('page', 'main_block', 'main');

$week_numbers = boolval($content['week_numbers']);

$template->set_var(
    array(
        'PAGE_ID'                       => $page_id,
        'SECTION_ID'                    => $section_id,
        'CAL_LOAD_ERROR'                => $LANG['frontend']['TXT_CAL_LOAD_ERROR'],
        'CAL_LOAD_MSG'                  => $LANG['frontend']['TXT_CAL_LOAD_MSG'],
        'CAL_FILE_URL'                  => strip_tags($cal_local_url),
        'WB_URL'                        => WB_URL,
        'CAL_LANG'                      => LANGUAGE,
        'WEEK_NUMBERS'                  => $week_numbers,
    )
);

// Parse template object
$template->set_unknowns('keep');
$template->parse('main', 'main_block', false);
$template->pparse('output', 'page', false);
