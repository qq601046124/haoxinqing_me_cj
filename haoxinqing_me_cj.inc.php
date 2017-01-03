<?php
/**
 *	[?????(haoxinqing_wsq_dh.{modulename})] (C)2015-2099 Powered by .
 *	Version: 1.0
 *	Date: 2015-6-16 14:45
 * 
*/


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
global $_G;


$pluginid = 'haoxinqing_me_cj';
//尊敬的 民审大哥 在此处 对get post变量 批量过滤
$_GET = daddslashes($_GET);
$_POST = daddslashes($_POST);
$act = $_GET['act'];

 
if($act == 'add'){
    if(submitcheck('submit')) {
        $data['url'] = trim($_POST['url']);
        $data['fid'] = trim($_POST['fid']);
        $data['name'] = trim($_POST['name']);
        $data['user_name'] = trim($_POST['user_name']);
        $data['title_regex'] = trim($_POST['title_regex']);
        $data['content_regex'] = trim($_POST['content_regex']);
        $data['page_regex'] = trim($_POST['page_regex']);
        $data['list_regex'] = trim($_POST['list_regex']);
        $data['num'] = trim($_POST['num']);
        $data['path'] = trim($_POST['path']);
		$data['download']= trim($_POST['download']);
        $data['src_pre'] = trim($_POST['src_pre']);
        $data = daddslashes($data);
        $ret = C::t('#haoxinqing_me_cj#haoxinqing_me_cj')->insert($data);
        if ($ret) {
            cpmsg('success', ADMINSCRIPT . "?frames=yes&action=plugins&operation=config&do=$pluginid&identifier=$pluginid&pmod=$pluginid_list", 'succeed');
        } else {
            cpmsg('error', ADMINSCRIPT . "?frames=yes&action=plugins&operation=config&do=$pluginid&identifier=$pluginid&pmod=$pluginid&act=edit&id=" . $id, 'error');
        }
    }
}
if($act == 'edit'){
	$id = daddslashes($_GET['id']);
	$data = C::t('#haoxinqing_me_cj#haoxinqing_me_cj')->fetch($id);
	require_once libfile('function/forumlist');
	showformheader('plugins&operation=config&do='.$pluginid.'&identifier='.$pluginid.'&pmod='.$pluginid.'&act=do_edit');
	echo '&nbsp;&nbsp;<font style="font-weight:700">'.$scriptlang['haoxinqing_me_cj']['fabudao'].':</font><br><br>';
	showsetting($_lang['import_program_fid'],'conf[name]','','<select name="fid" >'.forumselect(FALSE, 0, $data['fid'], TRUE).'</select>');
	echo '
	  <table class="tb tb2 ">
		<tbody>
		 ';
	 
	include template('haoxinqing_me_cj:dantie');
	showformfooter();
}
if($act == 'do_edit'){
    if(submitcheck('submit')) {
        $id = trim($_POST['id']);
        $data['url'] = trim($_POST['url']);
        $data['fid'] = trim($_POST['fid']);
        $data['name'] = trim($_POST['name']);
        $data['user_name'] = trim($_POST['user_name']);
        $data['title_regex'] = trim($_POST['title_regex']);
        $data['content_regex'] = trim($_POST['content_regex']);
        $data['page_regex'] = trim($_POST['page_regex']);
        $data['list_regex'] = trim($_POST['list_regex']);
        $data['num'] = trim($_POST['num']);
        $data['path'] = trim($_POST['path']);
        $data['src_pre'] = trim($_POST['src_pre']);
		$data['download']= trim($_POST['download']);
        $data = daddslashes($data);
        $ret = C::t('#haoxinqing_me_cj#haoxinqing_me_cj')->update($id, $data);
        if ($ret) {
            cpmsg('success', ADMINSCRIPT . "?frames=yes&action=plugins&operation=config&do=$pluginid&identifier=$pluginid&pmod=$pluginid_list", 'succeed');
        }
    }
}
if($act == 'caiji' & $_G['formhash'] == trim($_GET['hash'])){
	include 'haoxinqing_me_cj/haoxinqing_me_cj.php';
	//尊敬的 民审大哥 已经在头部 对get post变量 批量过滤
    $id = trim($_GET['id']);
    $sql = "SELECT * FROM ".DB::table('haoxinqing_me_cj')." where id ='".$id."'";
    $ret = DB::query($sql);
    $data = mysql_fetch_assoc($ret);

	$url = trim($data['url']);
	$fid = trim($data['fid']);
	$usernames = trim($data['user_name']);
	$title_regex = trim($data['title_regex']);
	$content_regex = trim($data['content_regex']);
	$page_regex = trim($data['page_regex']);
	$list_regex = trim($data['list_regex']);
	$num = trim($data['num']);
	$download = trim($data['download']);
	$path = trim($data['path']);
    /*
	$usernames = 'admin|admin';
	$url = 'http://haoxinqing.me/kaixin/forum.php?mod=forumdisplay&fid=2';
	$title_regex = '#thread_subject';
	$content_regex = '#thread_subject';
	$page_regex = '#fd_page_bottom a';
	$list_regex = '#threadlisttableid .xst';
	$num = 1;*/
	$urls = parse_url($url);
    if($path){
        $domain = 'http://'.$urls['host'].'/'.$path.'/';
    }else{
        $domain = 'http://'.$urls['host'];
    }
	
	
	$i = 0;
	$j = 0;
	if($page_regex){
		haoxinqing_me_cj::newDocumentFile($url);

		$pages  = pq($page_regex);
		if(!sizeof($pages)){
			$pages = array(0=>'<a href='.$url.'></a>');
		}
		 
		foreach($pages as $page){

			$href = pq($page)->attr('href');
			
			$hrefs = parse_url($href);
			
			if(!$hrefs['host']){
				$href = $domain.$href;
			}
		
			haoxinqing_me_cj::newDocumentFile($href);
			
			$lists  = pq($list_regex);
		
			foreach($lists as $list){
				$href =  pq($list)->attr('href');
				
				$hrefs = parse_url($href);
				 
				if(!$hrefs['host']){
					$href = $domain.$href;
				}
				
				$data['url'] = $href;
				$data['title_regex'] = $title_regex;
				$data['content_regex'] = $content_regex;
				$data['usernames'] = $usernames;
				$data['fid'] = $fid;
				$data['download'] = $download;
				caiji_dantie($data);
				
			}
			$i++;
			if($i>=$num){
				echo 1;
				exit();
			}
		}
	}
    
}
function download_remote_file($file_url, $save_to)
{
	$content = file_get_contents($file_url);
	file_put_contents($save_to, $content);
}
function caiji_dantie($data){
	
        global $_G;
        haoxinqing_me_cj::newDocumentFile($data['url']);

        $title = pq($data['title_regex'])->html();
        $e = mb_detect_encoding($title, array('UTF-8', 'GBK'));
 
        $title = iconv($e, $_G['charset'] . "//IGNORE", $title);
        $content = pq($data['content_regex'])->html();
		if($data['src_pre']){
			$src_pre = 	$data['src_pre'];
		}else{
			$src_pre = 'src';
		}
		$pre = "/<\s*img\s+[^>]*?".$src_pre."\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i";
		preg_match_all($pre,$content,$imgs);
		
		
		if(!empty($imgs)){
			foreach($imgs[0] as $k=>$img){
				$urls = parse_url($data['url']);
				$src = $imgs[2][$k];
				$path = $data['path'];
				if($path){
					$domain = 'http://'.$urls['host'].'/'.$path.'/';
				}else{
					$domain = 'http://'.$urls['host'];
				}
				$hrefs = parse_url($src);
			 
				if(!$hrefs['host']){
					$href = $domain.$src;
				}else{
					$href = $src;
				}
				if($data['download']){
					
					$date = date("Y-m-d");
						 
					$file_name='.jpg';
					 
					$img_path = 'source/plugin/haoxinqing_me_cj/images/'.$date.'/'.uniqid().$file_name;
				 
					$img_dir = 'source/plugin/haoxinqing_me_cj/images/'.$date;
					if (!file_exists($img_dir )){ mkdir ($img_dir );}
					download_remote_file($href,$img_path);
					$img_rep = '[img]'.$_G['siteurl'].$img_path .'[/img]';
				}else{
					$img_rep = '[img]'.$href.'[/img]';
				}
				$content = str_replace($img,$img_rep,$content);
				
			}
			
		}
        
		$content = iconv($e, $_G['charset'] . "//IGNORE", $content);
		
        set_time_limit(0);
        $usernames = array_filter(explode('|', $data['usernames'] . '|'));

        $username_k = array_rand($usernames, 1);
        $username = $usernames[$username_k];
        $uid = C::t('common_member')->fetch_uid_by_username($username);

        $ft_data = array(
            'fid' => $data['fid'],
            'authorid' => $uid,
            'author' => $username,
            'subject' => $title,
            'typeid' => 0,
            'dateline' => TIMESTAMP,
        );
        $ft_data = daddslashes($ft_data);
        $tid = C::t('forum_thread')->insert($ft_data, true);

        $pid = C::t('forum_post_tableid')->insert(array('pid' => null), true);
        $fp_data = array(
            'pid' => $pid,
            'fid' => $data['fid'],
            'tid' => $tid,
            'first' => 1,
            'author' => $username,
            'authorid' => $uid,
            'subject' => $title,
            'dateline' => TIMESTAMP,
            'message' => $content,
            'useip' => $_G['clientip'],
            'invisible' => 0,
            'anonymous' => 0,
            'usesig' => 1,
            'htmlon' => 0,
            'bbcodeoff' => 0,
            'smileyoff' => 0,
            'parseurloff' => 0,
            'attachment' => 0,
            'tags' => '',
            'replycredit' => 0,
            'status' => 0,
            'position' => 1,
            'htmlon'=>1
        );

        $fp_data = daddslashes($fp_data);
        $ret = C::t('forum_post')->insert(0, $fp_data);

        $ft_data = array(
            'maxposition' => 1,
            'lastpost' => TIMESTAMP,
            'lastposter' => $username,
            'replies' => 0,
            'attachment' => 0
        );
        $ft_data = daddslashes($ft_data);
        C::t('forum_thread')->update($tid, $ft_data);
		$lastpost = "$tid\t$title\t".TIMESTAMP."\t".daddslashes($username);
		$ff_data = array(
			'lastpost'=>$lastpost,
			'allowhtml'=>1
        );
		C::t('forum_forum')->update($data['fid'], $ff_data);

}
if($act != 'edit'){
	require_once libfile('function/forumlist');
	showformheader('plugins&operation=config&do='.$pluginid.'&identifier='.$pluginid.'&pmod='.$pluginid.'&act=add');
	echo '&nbsp;&nbsp;<font style="font-weight:700">'.$scriptlang['haoxinqing_me_cj']['fabudao'].':</font><br><br>';
	showsetting($_lang['import_program_fid'],'conf[name]','','<select name="fid" >'.forumselect(FALSE, 0, 0, TRUE).'</select>');
	echo '
	  <table class="tb tb2 ">
		<tbody>
		 ';
	 
	include template('haoxinqing_me_cj:dantie');
	showformfooter();
}

 ?>