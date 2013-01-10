<?php
/*-------------------------------------------------------------------------
# com_smartslider - Smart Slider
# -------------------------------------------------------------------------
# @ author    Roland Soós
# @ copyright Copyright (C) 2013 Offlajn.com  All Rights Reserved.
# @ license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# @ website   http://www.offlajn.com
-------------------------------------------------------------------------*/
?><?php

if( !function_exists('json_encode') ) {
    include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."JSON.php");
    function json_encode($data) {
        $json = new Services_JSON();
        return( $json->encode($data) );
    }
}
 
// Future-friendly json_decode
if( !function_exists('json_decode') ) {
    include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."JSON.php");
    function json_decode($data, $assoc = false) {
      $use = 0;
      if($assoc) $use = SERVICES_JSON_LOOSE_TYPE; 
      $json = new Services_JSON($use);
      return( $json->decode($data) );
    }
}

if(!function_exists('mb_convert_encoding')){
  function mb_convert_encoding($c, $a, $b){
    return $c;
  }
}