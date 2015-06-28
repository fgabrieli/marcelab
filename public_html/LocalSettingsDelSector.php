<?php 

/**
 * Configuration for delsectorsocial.org.
 *
 * This file is included by LocalSettings.php
 */

// require_once __DIR__ . "/extensions/Example/Example.php";

require_once "$IP/extensions/Loops/Loops.php";

require_once "$IP/extensions/Variables/Variables.php";

require_once "$IP/extensions/LoopFunctions/LoopFunctions.php";

$wgGoogleSiteSearchCSEID = '013941413581070605862:p8_nsbtq5no';
require_once "$IP/extensions/google-cse.php";

require_once "$IP/extensions/WikiEditor/WikiEditor.php";

require_once "$IP/extensions/RecentPages/RecentPages.php";

require_once "$IP/extensions/CategoryTree/CategoryTree.php";

require_once "$IP/extensions/Renameuser/Renameuser.php";

require_once "$IP/extensions/MaintenanceShell/MaintenanceShell.php";

require_once "$IP/extensions/Nuke/Nuke.php";

require_once "$IP/extensions/FacebookLikeButton/FacebookLikeButton.php";


// Del sector social extensions

require_once "$IP/extensions/DelSector/RedirectDeletedPages.php";

require_once "$IP/extensions/DelSector/CategoryManipulator.php";

require_once "$IP/extensions/DelSector/RestrictActionByGroup.php";


// enable user js and css

$wgAllowUserJs  = true;
$wgAllowUserCss  = true;

// logo
$wgLogo = '/resources/assets/delsector/logo.png';

// User groups and permissions

// Remove unused user groups

function removeGroups($groups) {
  foreach ($groups as $groupName) {
    unset( $GLOBALS['wgGroupPermissions'][$groupName] );
    unset( $GLOBALS['wgRevokePermissions'][$groupName] );
    unset( $GLOBALS['wgAddGroups'][$groupName] );
    unset( $GLOBALS['wgRemoveGroups'][$groupName] );
    unset( $GLOBALS['wgGroupsAddToSelf'][$groupName] );
    unset( $GLOBALS['wgGroupsRemoveFromSelf'][$groupName] );
  }
}
// XXX: delete 'user' group and migrate all of them to the 'editor' group
removeGroups(array('user', 'bot', 'bureaucrat', 'developer', 'autoconfirmed'));


// User Groups and Permissions

// Default perms (for all users)
$defaultPerms = array(
  'read' => true,
  'createtalk' => true,
  'viewmywatchlist' => true,
  'editmywatchlist' => true,
  'viewmyprivateinfo' => true,
  'editmyprivateinfo' => true,
  'editmyoptions' => true,
  'createaccount' => false
);

$wgGroupPermissions['*'] = $defaultPerms;


// Registered Users
$userPerms = array(
    'createpage' => true,
    'edit' => true
);

$wgGroupPermissions['user'] = array_merge($defaultPerms, $userPerms);


// Editors
$editorPerms = array (
  'move' => true,
  'move-subpages' => true,
  'move-rootuserpages' => true,
  'move-categorypages' => true,
  'movefile' => true,
  'read' => true,
  'edit' => true,
  'createpage' => true,
  'delete' => true,
  'undelete' => true,
  'createtalk' => true,
  'writeapi' => true,
  'upload' => true,
  'reupload' => true,
  'reupload-shared' => true,
  'minoredit' => true,
  'purge' => true,
  'sendemail' => true,
  'upload' => true
);

$wgGroupPermissions['editor'] = array_merge($userPerms, $editorPerms);

// Sysop
$sysopPerms = array (
    'createpage' => true,
    'edit' => true,
    'userrights' => true,
    'userrights-interwiki' => true,
    'editinterface' => true,
    'block' => true,
    'delete' => true,
    'undelete' => true,
    'renameuser' => true,
    'maintenanceshell' => true,
    'nuke' => true,
    'deletedhistory' => true
);
$wgGroupPermissions['sysop'] = array_merge($editorPerms, $sysopPerms);


$wgFooterIcons = array();

// Open external links in a new tab
$wgExternalLinkTarget = '_blank';

$wgNamespacesToBeSearchedDefault = array();

// Exclude the following pages from the Recent pages list (extension for showing recent changes on pages)
$GLOBALS['wgExcludeFromRecentPages'] = array('Cambios', 'Prueba');


// Set the place where all pages will point to and remove "index.php" from the url
$wgScriptPath = "";
$wgArticlePath = "/frase/$1";
$wgUsePathInfo = true;

// Image uploads
$wgUploadPath = "$wgScriptPath/images";
$wgEnableUploads = true;
?>