CKEDITOR.skins.add("v2",(function(){var b=[];if(CKEDITOR.env.ie&&CKEDITOR.env.version<7){b.push("icons.png","images/sprites_ie6.png","images/dialog_sides.gif")}return{preload:b,editor:{css:["editor.css"]},dialog:{css:["dialog.css"]},templates:{css:["templates.css"]},margins:[0,14,18,14]}})());(function(){CKEDITOR.dialog?b():CKEDITOR.on("dialogPluginReady",b);function b(){CKEDITOR.dialog.on("resize",function(a){var l=a.data,k=l.width,j=l.height,i=l.dialog,h=i.parts.contents;if(l.skin!="v2"){return}h.setStyles({width:k+"px",height:j+"px"});if(!CKEDITOR.env.ie){return}setTimeout(function(){var e=i.parts.dialog.getChild([0,0,0]),d=e.getChild(0),c=e.getChild(2);c.setStyle("width",d.$.offsetWidth+"px");c=e.getChild(7);c.setStyle("width",d.$.offsetWidth-28+"px");c=e.getChild(4);c.setStyle("height",d.$.offsetHeight-31-14+"px");c=e.getChild(5);c.setStyle("height",d.$.offsetHeight-31-14+"px")},100)})}})();