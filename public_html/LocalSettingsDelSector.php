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
removeGroups(array('bot', 'bureaucrat', 'developer', 'autoconfirmed'));


// User Groups and Permissions

// Default perms (for all users)
$defaultPerms = array(
    'read' => 1,
    'createtalk' => 1,
    'viewmywatchlist' => 1,
    'editmywatchlist' => 1,
    'viewmyprivateinfo' => 1,
    'editmyprivateinfo' => 1,
    'editmyoptions' => 1
);
$wgGroupPermissions['*'] = $defaultPerms;

// Editors
$editorPerms = array (
    'read' => 1
);
$wgGroupPermissions['editor'] = array_merge($defaultPerms, $editorPerms);

// Sysop
$sysopPerms = array (
    'createpage' => 1,
    'edit' => 1,
    'userrights' => 1,
    'userrights-interwiki' => 1,
    'editinterface' => 1,
    'block' => 1,
    'createaccount' => 1,
    'delete' => 1,
    'undelete' => 1
);
$wgGroupPermissions['sysop'] = array_merge($defaultPerms, $editorPerms, $sysopPerms);

?>