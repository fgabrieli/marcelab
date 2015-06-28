<?php
/**
 * Restrict access to certain pages.
 */
$wgExtensionCredits ['RestrictActionByGroup'] [] = array (
    'path' => __FILE__,
    'name' => 'RestrictActionByGroup',
    'author' => array (
        'Fernando Gabrieli' 
    ),
    'url' => '',
    'descriptionmsg' => 'restrict the user groups that can perform certain actions, say view page history' 
);

if (!isset($wgRestrictedPageActions)) {
  $wgRestrictedPageActions['history'] = array (
      'allowedGroups' => array (
          'editor',
          'sysop'
      ),
      'domEl' => '#ca-history'
  );
}

// Add allowed groups to perform certain actions
define ( 'RPA_RESTRICT', serialize ( $wgRestrictedPageActions ) );

// When the user is not allowed to execute an action, redirect him to a page telling him about this
define ( 'RPA_REDIRECT_TO', 'Home' );

$wgHooks ['OutputPageParserOutput'] [] = 'RestrictActionByGroup::onOutputPageParserOutput';

class RestrictActionByGroup {

  const RPA_RESTRICT = RPA_RESTRICT;

  const RPA_REDIRECT_TO = RPA_REDIRECT_TO;

  public static function onOutputPageParserOutput(OutputPage &$out, ParserOutput $parseroutput) {

    $action = (Action::getActionName ( $out->getContext () ));
    
    // If the user is trying to perform an action for which he is not allowed, redirect him to the home page
    $hasAction = (! empty ( $action ));
    if ($hasAction) {
      if (! self::isAllowed ( $action )) {
        $redirectTo = Title::newFromText ( self::RPA_REDIRECT_TO );
        $out->redirect ( $redirectTo->getFullURL () );
      }
    }
    
    // Hide dom elements related to restricted actions for this user
    $restricted = unserialize ( self::RPA_RESTRICT );
    foreach ( $restricted as $actName => $actData ) {
      if (! self::isAllowed ( $actName )) {
        $domEl = $actData ['domEl'];
        $out->addInlineStyle ( $domEl . '{ display: none};' );
      }
    }
  
  }

  private static function isAllowed($action) {

    $restricted = unserialize ( self::RPA_RESTRICT );
    $isRestricted = (array_key_exists ( $action, $restricted ));
    if (! $isRestricted) {
      $isAllowed = true;
    } else {
      $isAllowed = false;
      
      $actData = $restricted [$action];
      $allowedUsr = $actData ['allowedGroups'];
      global $wgUser;
      $userGroups = $wgUser->getGroups ();
      foreach ( $userGroups as $userGroup ) {
        $isAllowed = (in_array ( $userGroup, $allowedUsr ));
        if ($isAllowed) {
          break;
        }
      }
    }
    
    return $isAllowed;
  
  }

}