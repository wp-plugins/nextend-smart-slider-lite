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
defined('_JEXEC') or die('Restricted access');

if(!defined('OfflajnSliderThemeCache')) {
  define("OfflajnSliderThemeCache", null);

  if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
    require_once('cssmin5.php');
  }
  class OfflajnSliderThemeCache{
  
    var $env;
    
    var $module;
    
    var $params;
    
    var $css;
    
    var $themeCacheDir;
    
    var $themeCacheUrl;
    
    function OfflajnSliderThemeCache(&$_env, &$_module, &$_params, $_css){
      $this->env = &$_env;
      $this->module = &$_module;
      $this->params = &$_params;
      $this->css = $_css;
      
      $this->init();
    }
    
    function init(){
  

      $this->themeCacheDir = JPath::clean(JPATH_SITE.DS.'modules'.DS.$this->module->module.DS.'cache'.DS.$this->module->id.DS);
      if(!JFolder::exists($this->themeCacheDir)){
        if(!JFolder::create($this->themeCacheDir , 0777)){
          echo JPATH_CACHE." is unwriteable, so the Slider won't work correctly. Please set the folder to 777!";
        }
      }
      $this->themeCacheUrl = JURI::root(false).'/modules/'.$this->module->module.'/cache/'.$this->module->id.'/';
    }
    
    function generateCss($c){
      $icons="";
      foreach($this->env->slides as $s){
        @$icons.=$s->icon;
      }
      
      $hash=md5(
        $this->env->slider->params->toString().
        filemtime($c['clearcss']).
        filemtime($c['captioncss']).
        filemtime($c['contentcss']).
        filemtime($this->css).
        $icons.
        count($this->env->slides));
        $doc =& JFactory::getDocument();
        
      if(!is_file($this->themeCacheDir.DS.$hash.'.css')){
        $this->calc = false;
        ob_start();
        include($this->css);
        $css = ob_get_contents();
        ob_end_clean();
        
        if(class_exists('CssMin')){
          //$css = CssMin::minify($css);
        }
        file_put_contents($this->themeCacheDir.DS.$hash.'.css', $css);
        @chmod($this->themeCacheDir.DS.$hash.'.css',0777);
      }
      return $this->themeCacheUrl.$hash.'.css';
    }
    
  }
  
}
?>