<?php 
/*------------------------------------------------------------------------
# smartslider - Smart Slider
# ------------------------------------------------------------------------
# author    Roland Soos 
# copyright Copyright (C) 2011 Offlajn.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.offlajn.com
-------------------------------------------------------------------------*/
?>
<?php
jimport( 'joomla.plugin.plugin' );
defined('_JEXEC') or die('Restricted access');

class JElementImage extends JElement
{
	var	$_name = 'Image';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="text_area"' );

    $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);
    
    $document =& JFactory::getDocument();
    $document->addScript(JURI::base().'components/com_smartslider/oldparams/upload.js');
    $document->addScriptDeclaration('document.joomlabase = "'.JURI::root().'"; ');
    
    if($value == '') $value = 'http://';
    

    
    $isLoaded = JPluginHelper::importPlugin('editors-xtd', 'image', false);
		$className = 'plgButtonImage';
		if(class_exists($className)) {
			$plugin = new $className($this, array());
			$plugin->loadLanguage('plg_editors-xtd_image');
			
			if(version_compare(JVERSION,'1.6.0','ge')){
		    //JHtml::_('behavior.modal', 'a.modal-button');
			  $user = JFactory::getUser();
  		  $resultTest = $plugin->onDisplay($control_name.'['.$name.']', 90, $user->id);
  		  if ($resultTest) $button =  $resultTest;
  		  $return = "\n<div id=\"editor-xtd-buttons\">\n";
        if ($button && $button->get('name')) {
					$modal		= ($button->get('modal')) ? 'class="modal-button"' : null;
					$href		= ($button->get('link')) ? 'href="'.JURI::base().$button->get('link').'"' : null;
					$onclick	= ($button->get('onclick')) ? 'onclick="'.$button->get('onclick').'"' : null;
					$title      = ($button->get('title')) ? $button->get('title') : $button->get('text');
					$return .= "<div class=\"button2-left\"><div class=\"".$button->get('name')."\"><a onClick='SqueezeBox.fromElement(this, {parse: \"rel\"});return false;' ".$modal." title=\"".$title."\" ".$href." ".$onclick." rel=\"".$button->get('options')."\">".$button->get('text')."</a></div></div>\n";
			   $return .= "</div>\n";
          $GLOBALS['scripts'][] = 'new ImgUpload({html: '.json_encode($return).',node: dojo.byId("'.$control_name.$name.'"), v16: "'.(version_compare(JVERSION,'1.6.0','ge') ? 1 : 0).'" })';
				}
      }else{
  		  $resultTest = $plugin->onDisplay($control_name.'['.$name.']');
  		  if ($resultTest) $button =  $resultTest;
		  	$return = "\n<div id=\"editor-xtd-buttons\">\n";
				/*
				 * Results should be an object
				 */
				if ( $button->get('name') ){
					$modal		= ($button->get('modal')) ? 'class="modal-button"' : null;
					$href		= ($button->get('link')) ? 'href="'.$button->get('link').'"' : null;
					$onclick	= ($button->get('onclick')) ? 'onclick="'.$button->get('onclick').'"' : null;
					$return .= "<div class=\"button2-left\"><div class=\"".$button->get('name')."\"><a onclick='SqueezeBox.fromElement(this);return false;' ".$modal." title=\"".$button->get('text')."\" ".$href." ".$onclick." rel=\"".$button->get('options')."\">".$button->get('text')."</a></div></div>\n";
				}
			  $return .= "</div>\n";
        $GLOBALS['scripts'][] = 'new ImgUpload({html: '.json_encode($return).',node: dojo.byId("'.$control_name.$name.'"), v16: "'.(version_compare(JVERSION,'1.6.0','ge') ? 1 : 0).'" })';
    	}
    }	
		return '<input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' />';
	}
	
	function attach(){
  
  }
}
