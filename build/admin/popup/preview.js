!function(i){formintorjs.define(["text!tpl/dashboard.html"],function(e){return Backbone.View.extend({className:"sui-box-body",initialize:function(e){var a=this,t={action:"",type:"",id:"",preview_data:{},enable_loader:!0};return"powerform_quizzes"===e.type&&(t.has_lead=e.has_lead,t.leads_id=e.leads_id),e=_.extend(t,e),this.action=e.action,this.type=e.type,this.nonce=e.nonce,this.id=e.id,this.render_id=0,this.preview_data=e.preview_data,this.enable_loader=e.enable_loader,"powerform_quizzes"===e.type&&(this.has_lead=e.has_lead,this.leads_id=e.leads_id),i(document).off("after.load.powerform"),i(document).on("after.load.powerform",function(i){a.after_load()}),this.render()},render:function(){var e=this,a={};if(a.action=this.action,a.type=this.type,a.id=this.id,a.render_id=this.render_id,a.nonce=this.nonce,a.is_preview=1,a.preview_data=this.preview_data,a.last_submit_data={},"powerform_quizzes"===this.type&&(a.has_lead=this.has_lead,a.leads_id=this.leads_id),this.enable_loader){var t="";"sui-box-body"!==this.className&&(t+='<div class="sui-box-body">'),t+='<p class="fui-loading-dialog" aria-label="Loading content"><i class="sui-icon-loader sui-loading" aria-hidden="true"></i></p>',"sui-box-body"!==this.className&&(t+="</div>"),e.$el.html(t)}var d=i('<form id="powerform-module-'+this.id+'" data-powerform-render="'+this.render_id+'" style="display:none"></form>');e.$el.append(d),i(e.$el.find("#powerform-module-"+this.id+'[data-powerform-render="'+this.render_id+'"]').get(0)).powerformLoader(a)},after_load:function(){var i=this;i.$el.find('div[data-form="powerform-module-'+this.id+'"]').remove(),i.$el.find(".fui-loading-dialog").remove()}})})}(jQuery);