<?php
// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: index.php'));

// include core functions of WB 2.7 to edit the optional module CSS files (frontend.css, backend.css)
@include_once(WB_PATH .'/framework/module.functions.php');

$lang = (dirname(__FILE__))."/languages/". LANGUAGE .".php";
require_once(!file_exists($lang) ? (dirname(__FILE__))."/languages/EN.php" : $lang);

// check if backend.css file needs to be included into the <body></body> of modify.php
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(WB_PATH .'/modules/fullcalendar/backend.css')) {
    echo '<style type="text/css">';
    include(WB_PATH .'/modules/fullcalendar/backend.css');
    echo "\n</style>\n";
}

$sql_result = $database->query("SELECT * FROM `" .TABLE_PREFIX ."mod_fullcalendar` WHERE `section_id` = '$section_id'");
$content = $sql_result->fetchRow();

$cal_urls = htmlspecialchars($content['cal_urls']);

$template = new Template(WB_PATH.'/modules/fullcalendar');
$template->set_file('page', 'templates/modify.htt');
$template->set_block('page', 'main_block', 'main');

$week_numbers = "";
if (boolval($content['week_numbers'])) {
    $week_numbers = "checked=''";
}

$template->set_var(
    array(
        'PAGE_ID'                       => $page_id,
        'SECTION_ID'                    => $section_id,
        'WB_URL'                        => WB_URL,
        'FTAN'                          => $admin->getFTAN(),
        'TITLE'                         => $LANG['backend']['TXT_SETTINGS_TITLE'],
        'TXT_CAL_URLS'                  => $LANG['backend']['TXT_URLS'],
        'CAL_URLS'                      => $cal_urls,
        'TEXT_SAVE'                     => $TEXT['SAVE'],
        'TEXT_CANCEL'                   => $TEXT['CANCEL'],
        'TXT_WEEK_NUMBERS'              => $LANG['backend']['TXT_WEEK_NUMBERS'],
        'WEEK_NUMBERS'                  => $week_numbers,
        'TXT_CACHE_TIME'                => $LANG['backend']['TXT_CACHE_TIME'],
        'CACHE_TIME'                    => $content['cache_time'],
    )
);

// Parse template object
$template->set_unknowns('keep');
$template->parse('main', 'main_block', false);
$template->pparse('output', 'page', false);
