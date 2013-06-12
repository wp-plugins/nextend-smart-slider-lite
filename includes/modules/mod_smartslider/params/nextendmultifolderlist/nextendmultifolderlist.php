<?php
defined('_JEXEC') or die('Restricted access');

include_once(dirname(__FILE__).DS.'..'.DS.'offlajndashboard'.DS.'offlajndashboard.php');

class JElementNextendMultifolderlist extends JOfflajnFakeElementBase
{
	var	$_name = 'nextendconfigurator';
  
	function universalfetchElement($name, $value, &$node){
  
  		jimport('joomla.filesystem.folder');
      $sdir = $node->attributes('directory');
  		// Initialise variables.
  		$path = JPATH_ROOT . '/' . $sdir;
  		$filter = $node->attributes('filter');
  		$exclude = $node->attributes('exclude');
  		$folders = JFolder::listFolderTree($path, $filter, 3, 0);
  		$options = array();
  		foreach ($folders as $folder)
  		{
  			if ($exclude)
  			{
  				if (preg_match(chr(1) . $exclude . chr(1), $folder['relname']))
  				{
  					continue;
  				}
  			}
  			$options[] = JHtml::_('select.option', preg_replace('/\/'.preg_quote($sdir,'/').'\//','',$folder['relname'], 1).'/', $folder['relname']);
  		}
  
  		if (!$node->attributes('hide_none'))
  		{
  			array_unshift($options, JHtml::_('select.option', '-1', JText::_('JOPTION_DO_NOT_USE')));
  		}
  
  		if (!$node->attributes('hide_default'))
  		{
  			array_unshift($options, JHtml::_('select.option', '', JText::_('JOPTION_USE_DEFAULT')));
  		}
  
  		return JHtml::_(
  			'select.genericlist',
  			$options,
  			$name,
  			array('id' => $this->id, 'list.attr' => 'class="inputbox"', 'list.select' => $value)
  		);
	} 
}

if(version_compare(JVERSION,'1.6.0','ge')) {
        class JFormFieldNextendMultifolderlist extends JElementNextendMultifolderlist {}
}