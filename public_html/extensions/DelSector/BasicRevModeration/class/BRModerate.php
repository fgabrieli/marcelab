<?php

class BRModerate {

  const STATUS_NOT_APPROVED = 0;

  const STATUS_APPROVED = 1;

  const MODERATORS = array (
      'sysop',
      'editor' 
  );

  private static $instance;

  private function construct() {
    
    // singleton pattern
  }

  public static function getInstance() {

    $hasInstance = (self::$instance instanceof self);
    
    if (! $hasInstance) {
      self::$instance = new self();
    }
    
    return self::$instance;
  
  }

  public function moderate($pageId) {

    $dbr = wfGetDB( DB_SLAVE );
    $dbr->insert( 'basic_rev_moderation', array (
        'page_id' => $pageId,
        'status' => 0 
    ) );
  
  }

  public function isModerated($pageId) {

    $dbr = wfGetDB( DB_SLAVE );
    $res = $dbr->select( 'basic_rev_moderation', array (
        'status' 
    ), 'page_id = ' . $pageId, __METHOD__ );
    
    return ($dbr->numRows( $res ) > 0);
  
  }

  public function approve($pageId) {

    $dbr = wfGetDB( DB_SLAVE );
    $dbr->update( 'basic_rev_moderation', array (
        'status' => self::STATUS_APPROVED 
    ), array (
        'page_id' => $pageId 
    ), __METHOD__ );
  
  }

  public function disapprove($pageId) {

    $dbr = wfGetDB( DB_SLAVE );
    $dbr->update( 'basic_rev_moderation', array (
        'status' => self::STATUS_NOT_APPROVED 
    ), array (
        'page_id' => $pageId 
    ), __METHOD__ );
  
  }

  public function isApproved($pageId) {

    $dbr = wfGetDB( DB_SLAVE );
    $res = $dbr->select( 'basic_rev_moderation', array (
        'status' 
    ), 'page_id = ' . $pageId, __METHOD__ );
    
    $isModerated = ($dbr->numRows( $res ) > 0);
    if ($isModerated) {
      $row = $dbr->fetchRow( $res );
      $isApproved = ($row['status'] == self::STATUS_APPROVED);
    } else {
      // pages are approved by default if they are not being moderated
      $isApproved = true;
    }
    
    return $isApproved;
  
  }

  public function getApprovedRev($pageId) {

    PC::db( 'getApprovedRev for ' . $pageId );
    
    $dbr = wfGetDB( DB_SLAVE );
    $res = $dbr->select( 'basic_rev_moderation', array (
        'status, last_approved_rev_id' 
    ), 'page_id = ' . $pageId, __METHOD__ );
    
    $isModerated = ($dbr->numRows( $res ) > 0);
    if ($isModerated) {
      $row = $dbr->fetchRow( $res );
      PC::db( $row );
      $lastApprovedRev = $row['last_approved_rev_id'];
      $revId = (! is_null( $lastApprovedRev ) ? $lastApprovedRev : false);
    } else {
      $revId = false;
    }
    
    return $revId;
  
  }

  /**
   *
   * @param
   *          mixed string or array with user group names
   */
  public function isModerator($userGroup) {

    $isMod = false;
    
    if (is_array( $userGroup )) {
      $groups = $userGroup;
      foreach ( $groups as $grp ) {
        $isMod = (in_array( $grp, self::MODERATORS ));
        if ($isMod) {
          break;
        }
      }
    } else {
      $isMod = (in_array( $grp, self::MODERATORS ));
    }
    
    return $isMod;
  
  }

}