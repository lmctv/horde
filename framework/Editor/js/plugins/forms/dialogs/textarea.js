CKEDITOR.dialog.add("textarea",function(b){return{title:b.lang.textarea.title,minWidth:350,minHeight:150,onShow:function(){var d=this;delete d.textarea;var a=d.getParentEditor().getSelection().getSelectedElement();if(a&&a.getName()=="textarea"){d.textarea=a;d.setupContent(a)}},onOk:function(){var a,f=this.textarea,e=!f;if(e){a=this.getParentEditor();f=a.document.createElement("textarea")}this.commitContent(f);if(e){a.insertElement(f)}},contents:[{id:"info",label:b.lang.textarea.title,title:b.lang.textarea.title,elements:[{id:"_cke_saved_name",type:"text",label:b.lang.common.name,"default":"",accessKey:"N",setup:function(a){this.setValue(a.getAttribute("_cke_saved_name")||a.getAttribute("name")||"")},commit:function(a){if(this.getValue()){a.setAttribute("_cke_saved_name",this.getValue())}else{a.removeAttribute("_cke_saved_name");a.removeAttribute("name")}}},{id:"cols",type:"text",label:b.lang.textarea.cols,"default":"",accessKey:"C",style:"width:50px",validate:CKEDITOR.dialog.validate.integer(b.lang.common.validateNumberFailed),setup:function(a){var d=a.hasAttribute("cols")&&a.getAttribute("cols");this.setValue(d||"")},commit:function(a){if(this.getValue()){a.setAttribute("cols",this.getValue())}else{a.removeAttribute("cols")}}},{id:"rows",type:"text",label:b.lang.textarea.rows,"default":"",accessKey:"R",style:"width:50px",validate:CKEDITOR.dialog.validate.integer(b.lang.common.validateNumberFailed),setup:function(a){var d=a.hasAttribute("rows")&&a.getAttribute("rows");this.setValue(d||"")},commit:function(a){if(this.getValue()){a.setAttribute("rows",this.getValue())}else{a.removeAttribute("rows")}}}]}]}});