<?php
defined('_JEXEC') or die('Restricted access');

Nextendjimport( 'joomla.utilities.simplexml' );
Nextendjimport( 'joomla.html.parameter' );

class JElementOfflajnTab extends JOfflajnFakeElementBase{

  var $_name = 'offlajntab';
 
  function universalFetchElement($name, $value, &$node){
    $n = new JSimpleXML();
    if(method_exists($node, 'toString')){
        $n->loadString($node->toString());
    }else{
        $node->asXML(JFactory::getApplication()->getCfg('tmp_path').'/test.xml');
        $n->loadString(file_get_contents(JFactory::getApplication()->getCfg('tmp_path').'/test.xml'));
    }
    $params = new OfflajnJParameter('');
    $params->setXML($n->document);
    $attr = $node->attributes();
    if(!isset($attr['position']) || $attr['position'] != 'first') $attr['position'] = 'last';
    
    if(!version_compare(JVERSION,'1.6.0','ge')){ // Joomla 1.5 < 
      preg_match('/(.*)\[([a-zA-Z0-9]*)\]$/', $name, $out);
      $control = $out[1];
      $name = $out[2];
      $params->bind($this->_parent->_raw);
      $params->_raw = & $this->_parent->_raw;
    }else{ // Joomla 1.7 > 
      $this->element = $node->attributes();
      $control = $name;
      if($value != '')
        $params->bind($value);
    }
    plgSystemNextendParams::addNewTab($this->generateId($name), parent::getLabel(), $params->render($control), (string)$attr['position']);
    return '';
  }
  
}

function sprint_r($var) {
    ob_start();
    print_r($var);
    $output=ob_get_contents();
    ob_end_clean();
    return $output;
 }

if(version_compare(JVERSION,'1.6.0','ge')) {
  class JFormFieldOfflajnTab extends JElementOfflajnTab {}
}
?>