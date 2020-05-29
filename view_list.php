<?php
require_once './include/conf/const.php';
require_once './include/conf/cteam_const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

session_start();
$link = connect_db();
$spot_id = $_SESSION['selected_spot'];
if ($spot_id === NULL) {
    $_SESSION['errors'][] = '表示されたことのあるスポットがありません。';
    redirect(C_TEAM_TOP_PAGE);
}
// var_dump($spot_id);
// var_dump(count($spot_id));


for ($i = 0; $i < count($spot_id); $i++) {
    $spots_data = get_station_tag_genre_name($link, $spot_id[$i]);
    $spot_data[] = $spots_data[0];
}
close_db($link);


include_once 'include/view/view_list.php';
