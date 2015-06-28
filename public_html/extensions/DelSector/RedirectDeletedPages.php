<?php
/**
 * If a user tries to enter a page that was deleted we will redirect him to the home page.
 * 
 * It is not possible to permanently delete pages in MediaWiki so what i do is to redirect the user to the configured page if he tries to enter a deleted one.
 * 
 * XXX: every page access will trigger a db query to the archive table to know if the current page is deleted. This will impact on performance and we should move to MediaWiki 
 * API instead ASAP.
 */

// Redirect to this page if the user reaches a deleted one.
define('RDP_REDIRECT_TO_PAGE', 'Home');


$wgExtensionCredits ['RedirectDeletedPages'][] = array (
    'path' => __FILE__,
    'name' => 'RedirectDeletedPages',
    'author' => array (
        'Fernando Gabrieli' 
    ),
    'url' => '',
    'descriptionmsg' => 'redirect deleted pages to a specific page so the user can\'t see them' 
);


$wgHooks ['ArticlePageDataBefore'] [] = 'RedirectDeletedPagesHooks::onArticlePageDataBefore';


class RedirectDeletedPagesHooks {
  
  public static function onArticlePageDataBefore($article, $fields) {
    $title = $article->mTitle->mTextform;
    $dbr = wfGetDB ( DB_SLAVE );
    
    /// XXX: would be nice if we could use the API instead of querying the db here
    $res = $dbr->select ( 'archive', 
                          array ('ar_title'), 
                          'ar_title="' . $title . '"', // condition
                          __METHOD__, 
                          array ('')); 
    
    $isDeleted = ($res->result->num_rows > 0);
    if ($isDeleted) {
      $redirectTo = Title::newFromText ( RDP_REDIRECT_TO_PAGE );
      
      global $wgOut;
      $wgOut->redirect ( $redirectTo->getFullURL () );
    }
  }

}