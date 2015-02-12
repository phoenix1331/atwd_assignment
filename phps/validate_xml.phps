<?php

/*
 * Advanced Topics in Web Development
 * Darren Williams - 12039763
 *
 * Validate_xml.php
 * Used to validate XML from XSD schema
 *
 * http://php.net/manual/en/domdocument.schemavalidate.php
 */

//Get config
require_once("includes/config.php"); 

$doc = new DOMDocument();
$doc->load(HOME.'output.php?data=xml');

$is_valid_xml = $doc->schemaValidate(HOME.'players.xsd');

//Output message if document is valid or not
if($is_valid_xml == TRUE){
	echo 'Document valid!';
}else{
	echo 'Document not valid';
}

?>