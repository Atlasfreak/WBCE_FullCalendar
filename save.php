<?php
require('../../config.php');

// suppress to print the header, so no new FTAN will be set
$admin_header = false;
// Tells script to update when this page was last updated
$update_when_modified = true;
// include the admin wrapper script (includes framework/class.admin.php)
require(WB_PATH.'/modules/admin.php');

require("database.php");

if (!$admin->checkFTAN())
{
    $admin->print_header();
    $admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
    $admin->print_footer();
    exit();
} else {
    $admin->print_header();
}

$cal_urls = $admin->get_post('cal_urls');
$cal_urls = strip_tags($cal_urls);
$cal_urls = $admin->add_slashes($cal_urls);

$cache_time = intval($admin->get_post('cache_time'));
$week_numbers = intval(boolval($admin->get_post('week_numbers')));

$data = array(
    "section_id"        => $section_id,
    "cal_urls"          => $cal_urls,
    "cache_time"        => $cache_time,
    "week_numbers"      => $week_numbers,
    "recently_modified" => 1,
);

$result = $fc_db->db_add_row("section_id", $data);

if($result !== true) {
    $admin->print_error($database->get_error(), $js_back);
} else {
    $admin->print_success($MESSAGE['PAGES']['SAVED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

// print admin footer
$admin->print_footer();