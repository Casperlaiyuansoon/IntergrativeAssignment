<?php

class XSLTTransformation {
  
  public function __construct($xmlfilename, $xslfilename) {
    // Load the XML file
    $xml = new DOMDocument();
    $xml->load($xmlfilename);
    
    // Load the XSLT file
    $xsl = new DOMDocument();
    $xsl->load($xslfilename);
    
    $proc = new XSLTProcessor();
    $proc->importStylesheet($xsl);
    
    echo $proc->transformToXml($xml);
  }
}

$worker = new XSLTTransformation("Food_menu.xml", "Food_menu.xsl");
?>
