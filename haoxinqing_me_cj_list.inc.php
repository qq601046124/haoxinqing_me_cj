<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
global $_G;
//尊敬的 民审大哥 在此处 对get post变量 批量过滤
$_GET = daddslashes($_GET);
$_POST = daddslashes($_POST);
$plugin_id = 'haoxinqing_me_cj';
$caiji = $scriptlang['haoxinqing_me_cj']['caiji'];
$act = $_GET['act'];
if ($act == 'del') {
    if (submitcheck('submit')) {
        $ids = $_GET['delete'];
        $id_str = implode(',', $ids);
        $sql = "delete from  " . DB::table('haoxinqing_me_cj') . "   where id in ('" . $id_str . "')";
        $query = DB::query($sql);
        cpmsg('success', ADMINSCRIPT . "?frames=yes&action=plugins&operation=config&do=$plugin_id&identifier=$plugin_id&pmod=haoxinqing_me_cj_list", 'succeed');
    }
}

showformheader('plugins&operation=config&identifier='.$plugin_id.'&pmod=haoxinqing_me_cj_list&act=del');
showtableheader();
showsubtitle(array('', 'name', 'forum','url',$scriptlang['haoxinqing_me_cj']['erjimulu'],$scriptlang['haoxinqing_me_cj']['caijiyonghu'],$scriptlang['haoxinqing_me_cj']['fenyeguize'],$scriptlang['haoxinqing_me_cj']['liebiaoguize'],$scriptlang['haoxinqing_me_cj']['biaotiguize'],$scriptlang['haoxinqing_me_cj']['neirongguize'],$scriptlang['haoxinqing_me_cj']['caijiyeshu']));
showtagheader('tbody', '', true);
$sql = "SELECT * FROM " . DB::table('haoxinqing_me_cj').' where type<1';
$query = DB::query($sql);

while ($row = DB::fetch($query)) {
    $sql = "SELECT name FROM ".DB::table('forum_forum')." where fid ='".$row['fid']."'" ;
    $forum_name = DB::query($sql);
    $forum_name = mysql_fetch_assoc($forum_name);
    $caiji_link = explode('?',$_SERVER["HTTP_REFERER"]);
    $caiji_link  = explode('/',$caiji_link[0]);
    showtablerow('', array('class="td35"', 'class="td35"'), array(
        "<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[id]\">",
        "<div style='width: 97px'>$row[name]</div>",

        "<div style='width: 97px;overflow:hidden;' title=".  $forum_name['name'].">".  $forum_name['name']."</div>",
        "<div style='width: 97px;overflow:hidden;' title=".  $row['url']."><nobr>". $row['url']."</nobr></div>",
		
        "<div style='width: 97px;overflow:hidden;' title=".  $row['path']."><nobr>". $row['path']."</nobr></div>",
    
        "<div style='width: 97px' title='".  $row['user_name']."'>". $row['user_name']."</div>",
        "<div style='width: 97px' title='".  $row['page_regex']."'>". $row['page_regex']."</div>",
        "<div style='width: 97px' title='".  $row['list_regex']."'>". $row['list_regex']."</div>",
        "<div style='width: 50px' title='".  $row['title_regex']."'>". $row['title_regex']."</div>",
        "<div style='width: 50px' title='".  $row['content_regex']."'>". $row['content_regex']."</div>",
        "<div style='width: 50px' title='".  $row['num']."'>". $row['num']."</div>",

        "<a href=\"javascript:void(0);\" link=\"http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF']."?action=plugins&operation=config&do=$plugin_id&identifier=$plugin_id&pmod=haoxinqing_me_cj&hash=$_G[formhash]&act=caiji&id=$row[id]\" class=\"act haoxinqing_me_cj\">$caiji </a>" ,
        "<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&do=$plugin_id&identifier=$plugin_id&pmod=haoxinqing_me_cj_list\" class=\"act\">".$scriptlang['haoxinqing_me_cj']['stop']." </a>"
		 ,
        "<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&do=$plugin_id&identifier=$plugin_id&pmod=haoxinqing_me_cj&act=edit&id=$row[id]\" class=\"act\">".$lang['edit']." </a>"
    ));
}
echo '<tr><td colspan="1"></td><td colspan="5"><div><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$plugin_id.'&identifier='.$plugin_id.'&pmod=haoxinqing_me_cj" class="addtr">' . $lang[add] . '</a></div></td></tr>';
showsubmit('submit', 'submit', 'del');
showtablefooter();
showformfooter();
include template('haoxinqing_me_cj:list');

 ?>