<?php
# Google Custom Search Engine Extension
#
# Tag :
#   <GoogleCSE></GoogleCSE> or <GoogleCSE />
# Ex :
#   Add this tag to the wiki page you configed at your Google Custom Search control panel.
#
# Enjoy !

$wgExtensionFunctions[] = 'GoogleCSE';
$wgExtensionCredits['parserhook'][] = array(
    'name' => 'Google Custom Search Engine',
    'description' => 'Displays a Google Custom Search Engine input',
    'author' => 'Liang Chen The BiGreat',
    'url' => 'http://www.mediawiki.org/wiki/Extension:Google_Custom_Search_Engine'
);

function GoogleCSE() {
  global $wgParser;
  $wgParser->setHook('GoogleCSE', 'renderGoogleCSE');
}

# The callback function for converting the input text to HTML output
function renderGoogleCSE($input) {
  $output='<gcse:search></gcse:search>';//google code end here

  return $output;
}
?>