<?php

/**
 * autounban.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */


// Mais qu'est ce qu'il voullait demontrer lui ????

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);
	/*
	if ($user['authlevel'] >= 3) {
		$lang['PHP_SELF'] = 'options.'.$phpEx;
		doquery("UPDATE {{table}} SET `banaday` =` banaday` - '1' WHERE `banaday` != '0';",'users');
		doquery("UPDATE {{table}} SET `bana` = '0' WHERE `banaday` < '1';",'users');
		$parse = $game_config;
		$parse['dpath'] = $dpath;
		$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';
	} else {
		message ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
	*/
	if ($user['authlevel'] >= 1) {
		$tounban = doquery("SELECT * FROM {{table}} WHERE `longer`<='".mktime()."'",'banned');
		$users = "";
		while($unban = mysql_fetch_assoc($tounban)) {
			doquery("UPDATE {{table}} SET `bana`='0' WHERE `username`='".$unban['who']."' LIMIT 1",'users');
			$users .= $unban['who']." - ".$unban['theme']."<br />\n";
		}
		if($users != "") $message = "The following users have been unbanned (Username - Reason for ban):<br />\n".$users;
		else $message = "There were no users that needed to be unbanned!";
		message($message, "Update Bans");
	} else {
		message ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>

