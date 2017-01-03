<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
global $_G;

$plugin_id = 'haoxinqing_me_cj';
//尊敬的 民审大哥 在此处 对get post变量 批量过滤
$_GET = daddslashes($_GET);
$_POST = daddslashes($_POST);
$caiji = $scriptlang['haoxinqing_me_cj']['caiji'];
$act = $_GET['act'];
if ($act == 'del') {
    if (submitcheck('submit')) {
        $ids = $_GET['delete'];
        $id_str = implode(',', $ids);
        $sql = "delete from  " . DB::table('haoxinqing_me_cj') . "   where id in ('" . $id_str . "')";
        $query = DB::query($sql);
        cpmsg('success', ADMINSCRIPT . "?frames=yes&action=plugins&operation=config&do=$plugin_id&identifier=$plugin_id&pmod=haoxinqing_me_cj_wx_list", 'succeed');
    }
}

showformheader('plugins&operation=config&identifier='.$plugin_id.'&pmod=haoxinqing_me_cj_wx_list&act=del');
showtableheader();
showsubtitle(array('', 'name', 'forum','url',$scriptlang['haoxinqing_me_cj']['htmlon']));
showtagheader('tbody', '', true);
$sql = "SELECT * FROM " . DB::table('haoxinqing_me_cj').' where  type = 1 ';
$query = DB::query($sql);

while ($row = DB::fetch($query)) {
    $sql = "SELECT name FROM ".DB::table('forum_forum')." where fid ='".$row['fid']."'" ;
    $forum_name = DB::query($sql);
    $forum_name = mysql_fetch_assoc($forum_name);
    $caiji_link = explode('?',$_SERVER["HTTP_REFERER"]);
    $caiji_link  = explode('/',$caiji_link[0]);
    showtablerow('', array('class="td35"', 'class="td35"'), array(
        "<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[id]\">",
        "<div style='width: 297px'>$row[name]</div>",

        "<div style='width: 97px;overflow:hidden;' title=".  $forum_name['name'].">".  $forum_name['name']."</div>",
        "<div style='width: 297px;overflow:hidden;' title=".  $row['url']."><nobr>". $row['url']."</nobr></div>",

        "<a href=\"javascript:void(0);\" link=\"http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF']."?action=plugins&operation=config&do=$plugin_id&identifier=$plugin_id&pmod=haoxinqing_me_cj_wx&hash=$_G[formhash]&act=caiji&id=$row[id]\" class=\"act haoxinqing_me_cj\">$caiji </a>" ,
        "<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&do=$plugin_id&identifier=$plugin_id&pmod=haoxinqing_me_cj_wx_list\" class=\"act\">".$scriptlang['haoxinqing_me_cj']['stop']." </a>"
		 ,
        "<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&do=$plugin_id&identifier=$plugin_id&pmod=haoxinqing_me_cj_wx&act=edit&id=$row[id]\" class=\"act\">".$lang['edit']." </a>"
    ));
}
echo '<tr><td colspan="1"></td><td colspan="5"><div><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$plugin_id.'&identifier='.$plugin_id.'&pmod=haoxinqing_me_cj_wx" class="addtr">' . $lang[add] . '</a></div></td></tr>';
showsubmit('submit', 'submit', 'del');
showtablefooter();
showformfooter();
include template('haoxinqing_me_cj:list_wx');

 ?>