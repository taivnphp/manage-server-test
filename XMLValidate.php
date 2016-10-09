<?php

//use DOMDocument;
//use DOMImplementation;
class XMLValidate extends PHPUnit_Framework_TestCase
{
    public function setUp(){ }
    public function tearDown(){ }
    const PPML_NODE_NAME = 'ppml';

    public function validatePPMLStrWithProvidedDTD($rawXmlStr, $dtdPath)
    {
        if (!is_string($dtdPath) || empty($rawXmlStr)) {
            return false;
        }
        $xmlStr = trim($rawXmlStr);


        $realPathDTD = realpath($dtdPath);
        $dtd = file_get_contents($realPathDTD);

        $systemId = 'data://text/plain;base64,'.base64_encode($dtd);              

        $provided = new DOMDocument();
        $provided->loadXML($xmlStr, LIBXML_NOERROR);


        $creator              = new DOMImplementation;
        $doctype              = $creator->createDocumentType(self::PPML_NODE_NAME, null, $systemId);
        $appliedDTD           = $creator->createDocument(null, null, $doctype);
        
     
        $appliedDTD->encoding = "utf-8";

        $ppmlList = $provided->getElementsByTagName(self::PPML_NODE_NAME);
        if (count($ppmlList) === 0) {
            return true;
        }

        $ppmlNode = $ppmlList->item(0);
        if (is_null($ppmlNode)) {
            return false;
        }
        $newNode  = $appliedDTD->importNode($ppmlNode, true);
        
        $appliedDTD->appendChild($newNode);
        

        if (@$appliedDTD->validate()) {
			echo "Valid";
			} else {
			echo "Not valid";
			}
        die;
        //return @$appliedDTD->validate();
    }

    public function testXMLIsValid()
    {
    	
        $xmlStr = file_get_contents(__DIR__.'/xml/ppmlDataSample.xml');              
        $dtdPath = __DIR__.'/xml/ppml_test.dtd';
        
        $validate = $this->validatePPMLStrWithProvidedDTD($xmlStr, $dtdPath);

        
        //$this->assertTrue($this->validatePPMLStrWithProvidedDTD($xmlStr, $dtdPath));
        
        /*
        

        $xml = '<note>
			        <to>Tove</to>
			        <from>Jani</from>
			        <heading>Reminder</heading>
			        <body>Don\'t forget me this weekend!</body>
			    </note>';

			$dtd = '<?xml version="1.0" encoding="UTF-8"?>
				<!ELEMENT note (to,from,heading,body)>
			    <!ELEMENT to (#PCDATA)>
			    <!ELEMENT from (#PCDATA)>
			    <!ELEMENT heading (#PCDATA)>
			    <!ELEMENT body (#PCDATA)>';


			$root = 'note';

			$systemId = 'data://text/plain;base64,'.base64_encode($dtd);

			$old = new DOMDocument;
			$old->loadXML($xml);

			$creator = new DOMImplementation;
			$doctype = $creator->createDocumentType($root, null, $systemId);
			$new = $creator->createDocument(null, null, $doctype);
			$new->encoding = "utf-8";

			$oldNode = $old->getElementsByTagName($root)->item(0);
			$newNode = $new->importNode($oldNode, true);
			$new->appendChild($newNode);

			if (@$new->validate()) {
			echo "Valid";
			} else {
			echo "Not valid";
			}
			*/
    }
}
?>
