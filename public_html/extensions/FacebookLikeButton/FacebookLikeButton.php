<?php
/* Wiki FacebookLikeButton MediaWiki extension
 * Installation Instructions: http://www.mediawiki.org/wiki/Extension:FacebookLikeButton
 * 2012-08-16 Article URL support. The tag changed. HTML5 code.
 * For another language support, "en_US" can be replaced by "de_DE", "ja_JP" or "ko_KR".
 */
$wgExtensionFunctions[] = "facebooklikebuttonExtension";
function FacebookLikeButtonUrl() {
	$protocol = 'http';
	$port = '80';
	if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ) { $protocol =  'https'; $port = '443'; }
	$port = $_SERVER['SERVER_PORT'] == $port ? '' : ':' . $_SERVER['SERVER_PORT'];
	return $protocol . '://' . $_SERVER['HTTP_HOST'] . $port . $_SERVER['SCRIPT_NAME'];
}
function facebooklikebuttonExtension() {
	global $wgParser;
	global $FacebookLikeButtonOnce;
	$wgParser->setHook( "fblike", "renderFacebookLikeButton" ); 
	$FacebookLikeButtonOnce='<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>';
} 
function renderFacebookLikeButton( $input, $argv ) { 
	global $wgRequest;
	global $FacebookLikeButtonOnce;
	$layout = @$argv['layout'];
	$send = @$argv['send'];
	if( $layout != 'standard' && $layout != 'box_count' ) $layout = 'button_count';
	if( $send != 'true' ) $send = 'false';
	$once = $FacebookLikeButtonOnce;
	$FacebookLikeButtonOnce = '';
	$full_url = FacebookLikeButtonUrl().'/'.$wgRequest->getText('title');
	return $once.'<div>'.$wgRequest->getText('lang').'</div><div class="fb-like" data-href="'.$full_url.'" data-send="'.$send.'" data-layout="'.$layout.'" data-width="400"></div>';
}
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Wiki FacebookLikeButton',
	'version' => '1.1.0',
	'author' => 'Piotr Zuk, Jmkim dot com',
	'url' => 'http://www.mediawiki.org/wiki/Extension:FacebookLikeButton',
	'description' => 'Mediawiki FacebookLikeButton Extension'
);
?>