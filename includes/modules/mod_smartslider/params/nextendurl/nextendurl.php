<?php
/*-------------------------------------------------------------------------
# com_smartslider - Smart Slider
# -------------------------------------------------------------------------
# @ author    Roland Soós
# @ copyright Copyright (C) 2013 Nextendweb.com  All Rights Reserved.
# @ license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# @ website   http://www.nextendweb.com
-------------------------------------------------------------------------*/
?><?php
defined('_JEXEC') or die('Restricted access');

require_once(dirname(__FILE__).'/../offlajntext/offlajntext.php');

class JElementNextendurl extends JElementOfflajnText{
  var	$_name = 'NextendUrl';
  
  function universalfetchElement($name, $value, &$node){
    $html = parent::universalfetchElement($name, $value, $node);
    if(!defined('WP_ADMIN') && version_compare(JVERSION,'1.6.0','ge')) {
        $lang =& JFactory::getLanguage();
        $lang->load('plg_editors-xtd_article', JPATH_ADMINISTRATOR);
  		  $button = $this->onDisplay($this->id);
  			if ($button &&  $button->get('name') ) {
  				$modal		= ($button->get('modal')) ? ' id="'.$this->id.'_modal" class="modal-button"' : null;
  				$href		= ($button->get('link')) ? ' href="'.JURI::base().$button->get('link').'"' : null;
  				$onclick	= ($button->get('onclick')) ? ' onclick="'.$button->get('onclick').'"' : 'onclick="return false;"';
  				$title      = ($button->get('title')) ? $button->get('title') : $button->get('text');
  				$html .= '<div class="button2-left"><div class="' . $button->get('name')
  					. '"><a' . $modal . ' title="' . $title . '"' . $href . $onclick . ' rel="' . $button->get('options')
  					. '">' . $button->get('text') . "</a></div></div>\n";
          DojoLoader::addScript('
            window.jInsertEditorText = function(text, editor){
              odojo.byId(editor+"input").value = odojo.attr(odojo._toDom(text), "href");
              odojo.byId(editor+"input").focus();
              odojo.byId(editor+"input").blur();
            };
            SqueezeBox.assign($$("#'.$this->id.'_modal"), {
              parse: "rel"
            }); 
          ');
  			}
    }
    
    return $html;
  }
  
  	function onDisplay($name)
  	{
  		/*
  		 * Javascript to insert the link
  		 * View element calls jSelectArticle when an article is clicked
  		 * jSelectArticle creates the link tag, sends it to the editor,
  		 * and closes the select frame.
  		 */
  		$js = "
  		function jSelectArticle(id, title, catid, object, link, lang) {
  			var hreflang = '';
  			if (lang !== '') {
  				var hreflang = ' hreflang = \"' + lang + '\"';
  			}
  			var tag = '<a' + hreflang + ' href=\"' + link + '\">' + title + '</a>';
  			jInsertEditorText(tag, window.ssfieldname);
  			SqueezeBox.close();
  		}";
  
  		$doc = JFactory::getDocument();
  		$doc->addScriptDeclaration($js);
  
  		JHtml::_('behavior.modal');
  
  		/*
  		 * Use the built-in element view to select the article.
  		 * Currently uses blank class.
  		 */
  		$link = 'index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component&amp;'.JSession::getFormToken().'=1';
  
  		$button = new JObject();
  		$button->set('modal', true);
  		$button->set('onclick', 'window.ssfieldname=\''.$name.'\';return true;');
  		$button->set('link', $link);
  		$button->set('text', JText::_('PLG_ARTICLE_BUTTON_ARTICLE'));
  		$button->set('name', 'article');
  		$button->set('options', "{handler: 'iframe', size: {x: 770, y: 400}}");
  
  		return $button;
  	}
}

if(version_compare(JVERSION,'1.6.0','ge')) {
  class JFormFieldNextendurl extends JElementNextendurl {}
}