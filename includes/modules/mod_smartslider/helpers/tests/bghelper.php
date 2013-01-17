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
require_once(dirname(__FILE__).'/../bg.php');

  $generator = new OfflajnBgHelper();
  
  //$result = $generator->generateBackground("FF00006b");
  $result = $generator->generateGradientBackground("1-ABCC3D-597305", 1, 300);
  
  echo $result;
?>
<html>
  <head>
    <title>background-color generator</title>
  </head>
  <body>
    <div style="<?php echo $result; ?> height: 300px; width: 300px;">
    
    </div>
  </body>
</html>