<?php

$wgExtensionCredits['other'][] = array(
    'path' => __FILE__,

    'name' => 'Frases Alternativas',

    'author' => array(
        'Fernando Gabrieli'
    ),

    'version'  => '0.1.0',

    // The extension homepage. www.mediawiki.org will be happy to host your extension homepage.
    'url' => 'no-url',

    // Key name of the message containing the description.
    'descriptionmsg' => 'frases-alternativas',
);

// on parser init

$wgHooks['ParserFirstCallInit'][] = 'mbFirstCall';

function mbFirstCall( Parser $parser ) {
  $parser->setHook( 'fral', 'mbFraseAlternativa' );
  return true;
}

function mbFraseAlternativa( $input, array $args, Parser $parser, PPFrame $frame ) {
  return "negrita mia de mi curacao";
}

// on parser output

// $wgHooks['ContentGetParserOutput'][] = 'mbParserOutput';

// function mbParserOutput( $content, $title, $revId, $options, $generateHtml, &$output ) {
//   print_r($content);
// }