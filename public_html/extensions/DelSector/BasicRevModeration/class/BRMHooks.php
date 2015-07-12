<?php
require_once 'BRModerate.php';

class BRMHooks {

  const DEFAULT_PAGE = 83;

  private function __construct() {
    
    // can't be instantiated
  }

  public static function setHooks() {

    global $wgHooks;
    
    $wgHooks['ArticleInsertComplete'][] = 'BRMHooks::onArticleInsertComplete';
    
    $wgHooks['PageContentSaveComplete'][] = 'BRMHooks::onPageContentSaveComplete';
    
    $wgHooks['ArticlePageDataAfter'][] = 'BRMHooks::onArticlePageDataAfter';
  
  }
  
  // fired when a new page is created
  public static function onArticleInsertComplete(&$article, User &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, Revision $revision) {

    $brm = BRModerate::getInstance();
    
    $pageId = $article->getId();
    $brm->moderate( $pageId );
  
  }
  
  // fired when the user requests saving the current page
  public static function onPageContentSave(&$wikiPage, &$user, &$content, &$summary, $isMinor, $isWatch, $section, &$flags, &$status) {
    
    // PC::debug ( 'onPageContentSave' );
  }
  
  // fired when the page is saved
  public static function onPageContentSaveComplete($article, $user, $content, $summary, $isMinor, $isWatch, $section, $flags, $revision, $status, $baseRevId) {

    $brm = BRModerate::getInstance();
    
    $pageId = $article->getId();
    $revId = $revision->getId();
    
    $isModerated = $brm->isModerated( $pageId );
    if ($isModerated) {
      $brm->disapprove( $pageId );
    } else {
      $brm->moderate( $pageId );
    }
  
  }

  public static function onArticlePageDataAfter($article, $row) {

    $isPageValid = ($row != false);
    if ($isPageValid) {
      $brm = BRModerate::getInstance();
      
      $pageId = $row->page_id;
      
      if (! self::isOwner($pageId) && ! self::isModerator()) {
        
        if ($brm->isModerated( $pageId )) {
          $approvedRev = $brm->getApprovedRev( $pageId );
          $hasApprovedRev = ($approvedRev != false);
          if ($hasApprovedRev) {
            $row->page_latest = $approvedRev;
          } else {
            PC::db('replacing');
            self::replaceWithDefaultPage( $article, $row );
          }
        }
      }
    }
  
  }

  private static function isOwner($pageId) {

    global $wgUser;
    
    $page = WikiPage::newFromId( $pageId );
    $rev = $page->getRevision();
    $owner = $rev->getUser();
    
    return ($owner == $wgUser->getId());
  
  }

  private static function isModerator() {

    global $wgUser;
    $userGroups = $wgUser->getGroups();
    
    $brm = BRModerate::getInstance();
    return ($brm->isModerator( $userGroups ));
  
  }

  private static function replaceWithDefaultPage($article, $row) {

    $fields = WikiPage::selectFields();
    
    $dbr = wfGetDB( DB_SLAVE );
    $newRow = $dbr->selectRow( 'page', $fields, array (
        'page_id' => self::DEFAULT_PAGE 
    ), __METHOD__ );
    
    PC::db( $newRow );
    
    foreach ( $newRow as $key => $val ) {
      $row->{$key} = $val;
    }
    
    PC::db( $row );
    
    $newTitle = Title::newFromText( $newRow->page_title );
    PC::db( $newTitle );
    $article->mTitle = $newTitle;
    
    PC::db( 'newTitle=' . $newRow->page_title );
  
  }

}