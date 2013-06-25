<?php
defined('_JEXEC') or die('Restricted access');

include_once(dirname(__FILE__).DS.'..'.DS.'offlajndashboard'.DS.'offlajndashboard.php');

class JElementNextendMultiSql extends JOfflajnFakeElementBase
{
	var	$_name = 'nextendmultisql';
  
	function universalfetchElement($name, $value, &$node){

      // Construct the various argument calls that are supported.
      $attribs       = ' ';
      if ($v = $node->attributes( 'size' )) {
              $attribs       .= 'size="'.$v.'"';
      }
      if ($v = $node->attributes( 'class' )) {
              $attribs       .= 'class="'.$v.'"';
      } else {
              $attribs       .= 'class="inputbox"';
      }
      if ($m = $node->attributes( 'multiple' ))
      {
              $attribs       .= ' multiple="multiple"';
              $name          .= '[]';
      }
      
      $attribs.= ' id="'.$this->id.'"';

      // Query items for list.
                      $db                     = & JFactory::getDBO();
                      $db->setQuery($node->attributes('query'));
                      $key = ($node->attributes('key_field') ? $node->attributes('key_field') : 'value');
                      $val = ($node->attributes('value_field') ? $node->attributes('value_field') : 'name');

      $options = array ();
      foreach ($node->children() as $option)
      {
              $options[]= array($key=> $option->attributes('value'),$val => $option->data());
      }

      $rows = $db->loadAssocList();
      foreach ($rows as $row){
              $options[]=array($key=>$row[$key],$val=>$row[$val]);
      }
      if($options){
              return JHTML::_('select.genericlist',$options, $name, $attribs, $key, $val, $value);
      }
	} 
}

if(version_compare(JVERSION,'1.6.0','ge')) {
        class JFormFieldNextendMultiSql extends JElementNextendMultiSql {}
}