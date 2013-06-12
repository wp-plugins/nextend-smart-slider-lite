dojo.declare("NextendWPImagemanager", null, {
	constructor: function(args) {
    dojo.mixin(this,args);
    this.init();
  },
  
  init: function() {
    this.hidden = dojo.byId(this.id);
    this.btn = dojo.byId(this.id+'_wp');
    dojo.connect(this.btn, 'click', this, 'new_im_MediaPopupHandler');
  },
  
  new_im_MediaPopupHandler: function (){
  
  	window.send_to_editor = dojo.hitch(this,'loadImage');
  
  	tb_show('', this.admin_url+'media-upload.php?type=image&TB_iframe=true&width=640&height=500');
  	return false;
  },
  
  loadImage: function(html){
    if( Object.prototype.toString.call( html) === '[object Array]' ) {
        this.setValue(html[0]);
    }else{
        var html = jQuery(html);
        var img = html;
        if(html[0].tagName != 'IMG'){
      		img = jQuery('img',html);
    		}
    		this.setValue(img.attr('src'));
    }
    
		tb_remove();
  },
  
  setValue: function(image){
    this.hidden.value = image;
    this.fireEvent(this.hidden, 'change');
  },
  
  fireEvent: function(element,event){
    if ((document.createEventObject && !dojo.isIE) || (document.createEventObject && dojo.isIE && dojo.isIE < 9)){
      var evt = document.createEventObject();
      return element.fireEvent('on'+event,evt);
    }else{
      var evt = document.createEvent("HTMLEvents");
      evt.initEvent(event, true, true );
      return !element.dispatchEvent(evt);
    }
  },
  
});