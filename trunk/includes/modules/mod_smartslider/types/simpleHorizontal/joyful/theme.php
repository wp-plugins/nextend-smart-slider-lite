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
?>
<script type="text/javascript">
var captions = new Array;
</script>
<div id="<?php echo $id; ?>">
  <div class="outer">
    <div class="slinner">
      <ul class="slides">
      <?php 
      $x=0;
      foreach($tthis->slides as $slide): 
        $classes = array();
        if($x == 0)
          $classes[] = 'selected';
          
        $class = implode(' ', $classes);
        ?>
        <li class="<?php echo $class; ?> sslide">
          <script type="text/javascript">
            captions[<?php echo $x; ?>] = new Array;
          </script>
            <?php $child = $slide->childs[0] ?>
              <div class="canvas">
                <?php echo $context['helper']->modulePositionReplacer($child->content); ?>
              </div>
              <script type="text/javascript">
                var caption = null;
              </script>
              <div class="caption">
                <?php echo $child->caption; ?>
              </div>
              <script type="text/javascript">
                captions[<?php echo $x; ?>] = caption;
              </script>
        </li>
      <?php ++$x; endforeach; ?>
      </ul>
      <div class="controll">
        <?php if($tthis->slider->params->get('ctrlbtn', 1)): ?>
        <div class="left controllbtn"><div><?php echo JText::_('SS-Previous'); ?></div></div>
        <?php endif; ?>
        <div class="dots" style="width: <?php echo count($tthis->slides)*19; ?>px;">
          <?php foreach($tthis->slides as $slide): ?>
            <div class="dot"></div>
          <?php ++$x; endforeach; ?>
        </div>
        <?php if($tthis->slider->params->get('ctrlbtn', 1)): ?>
        <div class="right controllbtn"><div><?php echo JText::_('SS-Next'); ?></div></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="shadow"></div>
</div>
<?php
  $autoplay = OfflajnValueParser::parse($tthis->slider->params->get('autoplay'));
  $mainanim = OfflajnValueParser::parse($tthis->slider->params->get('mainanimation'));
?>
<script type="text/javascript">
var <?php echo $id?>captions = odojo.clone(captions);
odojo.addOnLoad(odojo, function(){
  var dojo = this;
  new OfflajnSliderSimpleHorizontal({
    node: dojo.byId('<?php echo $id; ?>'),
    rawcaptions: <?php echo $id?>captions,
    autoplay: <?php echo $autoplay[2][0]; ?>,
    autoplayinterval: <?php echo $autoplay[0][0]; ?>,
    restartautoplay: <?php echo $autoplay[1]; ?>,
    maineasing: <?php echo $mainanim[1]; ?>,
    maininterval: <?php echo $mainanim[0][0]; ?>,
    mousescroll: <?php echo $tthis->slider->params->get('mousescroll', 1); ?>,
    transition: <?php echo $tthis->slider->params->get('transition', 1); ?>
  });
});
</script>