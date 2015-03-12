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

require_once "$IP/extensions/google-cse.php";

require_once "$IP/extensions/WikiEditor/WikiEditor.php";

// enable user js and css

$wgAllowUserJs  = true;
$wgAllowUserCss  = true;

// logo
$wgLogo = '/resources/assets/delsector/logo.png';

?>