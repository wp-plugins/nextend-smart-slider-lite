dojo.require("dojo.window");

dojo.declare("NextendConfigurator", null, {
	constructor: function(args) {
    dojo.mixin(this,args);
    this.container = dojo.query('.nextend-configurator-container', this.node)[0];
    this.containerinner = dojo.query('.nextend-configurator-container-inner', this.node)[0];
    this.onResize();
    dojo.connect(window, 'resize', this, 'onResize');
    
    
    dojo.connect(this.containerinner, 'click', dojo.stopEvent);
    dojo.connect(this.node, 'click', this, 'hideOverlay');
    dojo.connect(this.save, 'click', this, 'hideOverlay');
    dojo.connect(this.button, 'click', this, 'showOverlay');
  },
  
  onResize: function(){
    var vs = dojo.window.getBox();
    dojo.contentBox(this.node,{
      w: vs.w,
      h: vs.h
    });
    dojo.marginBox(this.container,{
      w: vs.w,
      h: vs.h
    });
  },
  
  showOverlay: function(){
    dojo.style(this.node, 'display', 'block');
    this.onResize();
    if(window.OfflajnParams)
      window.OfflajnParams.resizeBoxes();
  },
  
  hideOverlay: function(){
    dojo.style(this.node, 'display', 'none');
    this.message.innerHTML = 'Now you should save the module settings to apply changes!';
  }
});