<?php
if (! defined ( 'MEDIAWIKI' ))
  die ();
/**
 * Extension to moderate entries with basic functionality.
 *
 * @file
 * @ingroup Extensions
 * 
 * @author Fernando Gabrieli <fgabrieli@gmail.com>
 * @copyright Copyright 2017, Fernando Gabrieli
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['basicmoderation'][] = array (
    'path' => __FILE__,
    'name' => 'BasicModeration',
    'author' => array (
        'Fernando Gabrieli' 
    ),
    'url' => 'https://www.mediawiki.org/wiki/Extension:BasicModeration',
    'descriptionmsg' => 'basicmoderation-desc' 
);

// Configuration

// These groups will be notified when a new entry is created or an existing one is modified
$wgNotifyGroups = array (
    'editor' 
);

// Schema updates for update.php
$wgHooks['LoadExtensionSchemaUpdates'][] = 'addModerationTable';

function addModerationTable(DatabaseUpdater $updater) {

  $updater->addExtensionTable ( 'basic_rev_moderation', __DIR__ . '/sql/basic_rev_moderation.sql' );
  return true;

}

// XXX: remove before release
// Enable PHP console debugging
require_once (__DIR__ . '/../php-console/src/PhpConsole/__autoload.php');

// Call debug from PhpConsole\Handler
$handler = PhpConsole\Handler::getInstance ();
$handler->start ();
// $handler->debug('called from handler debug', 'some.three.tags');

// Call debug from PhpConsole\Connector (if you don't use PhpConsole\Handler in your project)
// PhpConsole\Connector::getInstance()->getDebugDispatcher()->dispatchDebug('called from debug dispatcher without
// tags');

// Call debug from global PC class-helper (most short & easy way)
PhpConsole\Helper::register (); // required to register PC class in global namespace, must be called only once

// Classes
require_once 'class/BRMHooks.php';

BRMHooks::setHooks ();


// # Internationalisation files
// // $wgMessagesDirs['Renameuser'] = __DIR__ . '/i18n';
// // $wgExtensionMessagesFiles['Renameuser'] = __DIR__ . '/Renameuser.i18n.php';
// // $wgExtensionMessagesFiles['RenameuserAliases'] = __DIR__ . '/Renameuser.alias.php';

// // /**
// //  * Users with more than this number of edits will have their rename operation
// //  * deferred via the job queue.
// //  */
// // define( 'RENAMEUSER_CONTRIBJOB', 5000 );

// // # Add a new log type
// // $wgLogTypes[] = 'renameuser';
// // $wgLogActionsHandlers['renameuser/renameuser'] = 'RenameuserLogFormatter';

// // $wgAutoloadClasses['RenameuserHooks'] = __DIR__ . '/Renameuser.hooks.php';
// // $wgAutoloadClasses['RenameUserJob'] = __DIR__ . '/RenameUserJob.php';
// // $wgAutoloadClasses['RenameuserLogFormatter'] = __DIR__ . '/RenameuserLogFormatter.php';
// // $wgAutoloadClasses['RenameuserSQL'] = __DIR__ . '/RenameuserSQL.php';
// // $wgAutoloadClasses['SpecialRenameuser'] = __DIR__ . '/specials/SpecialRenameuser.php';

// // $wgSpecialPages['Renameuser'] = 'SpecialRenameuser';
// // $wgSpecialPageGroups['Renameuser'] = 'users';
// // $wgJobClasses['renameUser'] = 'RenameUserJob';

// // $wgHooks['ShowMissingArticle'][] = 'RenameuserHooks::onShowMissingArticle';
// // $wgHooks['ContributionsToolLinks'][] = 'RenameuserHooks::onContributionsToolLinks';
// // $wgHooks['GetLogTypesOnUser'][] = 'RenameuserHooks::onGetLogTypesOnUser';

// require_once(__DIR__ . '/../php-console/src/PhpConsole/__autoload.php');

// // Call debug from PhpConsole\Handler
// $handler = PhpConsole\Handler::getInstance();
// $handler->start();
// //$handler->debug('called from handler debug', 'some.three.tags');

// // Call debug from PhpConsole\Connector (if you don't use PhpConsole\Handler in your project)
// //PhpConsole\Connector::getInstance()->getDebugDispatcher()->dispatchDebug('called from debug dispatcher without tags');

// // Call debug from global PC class-helper (most short & easy way)
// PhpConsole\Helper::register(); // required to register PC class in global namespace, must be called only once
// //PC::debug('called from PC::debug()', 'db');
// //PC::db('called from PC::__callStatic()'); // means "db" will be handled as debug tag

// // // Debug some mixed variable

// // class DebugExample {

// //   private $privateProperty = 1;
// //   protected $protectedProperty = 2;
// //   public $publicProperty = 3;
// //   public $selfProperty;

// //   public function __construct() {
// //     $this->selfProperty = $this;
// //   }

// //   public function someMethod() {
// //   }
// // }

// // PhpConsole\Connector::getInstance()->getDebugDispatcher()->setDumper(
// //     new PhpConsole\Dumper(2, 10, 40) // set new dumper with levelLimit=2, itemsCountLimit=10, itemSizeLimit=10
// // );

// // $s = new stdClass();
// // $s->asd = array(array(123));

// // PC::debug(array(
// //     'null' => null,
// //     'boolean' => true,
// //     'longString' => '11111111112222222222333333333344444444445',
// //     'someObject' => new DebugExample(),
// //     'someCallback' => array(new DebugExample(), 'someMethod'),
// //     'someClosure' => function () {
// //     },
// //     'someResource' => fopen(__FILE__, 'r'),
// //     'manyItemsArray' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11),
// //     'deepLevelArray' => array(1 => array(2 => array(3))),
// // ));

// // // Trace debug call

// // PC::getConnector()->getDebugDispatcher()->detectTraceAndSource = true;

// // function a() {
// //   b();
// // }

// // function b() {
// //   PC::debug('Message with source & trace detection');
// // }

// // a();

// // echo 'See debug messages in JavaScript Console(Ctrl+Shift+J) and in Notification popups. Click on PHP Console icon in address bar to see configuration options.';
