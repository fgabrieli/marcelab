<?php
/**
 * Manipulate categories in the Wiki. Apply filters on the fly based on certain configurations.
 * 
 * Features
 * 
 * - Add title pais in CM_SWITCH_CAT_TITLE so a category name with a certain title will switch to a different one when it is rendering.
 * - Add a category to CM_BLOCKED to block a category and make it redirect to the home page.
 * 
 */
$wgExtensionCredits ['CategoryManipulator'] [] = array (
    'path' => __FILE__,
    'name' => 'CategoryManipulator',
    'author' => array (
        'Fernando Gabrieli' 
    ),
    'url' => '',
    'descriptionmsg' => 'manipulate categories in the wiki' 
);

// You can add new categories to switch their titles as <category name without the Category: prefix> => <New title>
// XXX: this won't work for categories with UTF8 chars, we need to find a solution for this or use another field like
// the category ID if it has one
define ( 'CM_SWITCH_TITLE', serialize ( array (
    'Argentina' => 'Del Sector Social' 
) ) );

$wgHooks ['OutputPageParserOutput'] [] = 'CategoryManipulator::onOutputPageParserOutput';

class CategoryManipulator {

  const CM_SWITCH_TITLE = CM_SWITCH_TITLE;

  private static function checkTitle($title) {

    $newTitle = $title;
    
    $categoryName = preg_match ( '/:(.*)/', $title, $match );
    if (! empty ( $match )) {
      $catName = $match [1];
      
      $switchTitles = unserialize ( self::CM_SWITCH_TITLE );
      $isInSwitch = (isset ( $switchTitles [$catName] ));
      if ($isInSwitch) {
        $newTitle = $switchTitles [$catName];
      }
    }
    
    return $newTitle;
  
  }

  public static function onOutputPageParserOutput(OutputPage &$out, ParserOutput $parseroutput) {
    
    // XXX: this won't work for categories with UTF8 chars
    $title = $parseroutput->getTitleText ();
    $finalTitle = self::checkTitle ( $title );
    
    $parseroutput->setTitleText ( $finalTitle );
  
  }

}