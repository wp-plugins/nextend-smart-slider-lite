<?php
/*-------------------------------------------------------------------------
# mod_smartslider - Nextend Smart Slider
# -------------------------------------------------------------------------
# @ author    Roland Soos @ Nextendweb.com
# @ copyright Copyright (C) 2013 Nextendweb.com  All Rights Reserved.
# @ license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# @ website   http://www.nextendweb.com
-------------------------------------------------------------------------*/
?><?php
jimport('joomla.filesystem.folder');
$path = dirname(__FILE__);

foreach(JFolder::files($path, '.php', false, false) AS $f){
  require_once($path.DS.$f);
}

if(!function_exists('o_flat_array')){

  /* Multidimensional to flat array */
  function o_flat_array($array){
    if(!is_array($array)) return array();
   $out=array();
   foreach($array as $k=>$v){
    if(is_array($array[$k]) && o_isAssoc($array[$k])){
     $out+=o_flat_array($array[$k]);
    }else{
     $out[$k]=$v;
    }
   }
   return $out;
  }
}

if(!function_exists('o_isAssoc')){
  function o_isAssoc($arr){
    return array_keys($arr) !== range(0, count($arr) - 1);
  }
}


?>