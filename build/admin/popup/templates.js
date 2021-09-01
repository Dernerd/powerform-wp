! function(e) {
    formintorjs.define(["text!tpl/dashboard.html"], function(t) {
        return Backbone.View.extend({
            className: "psource-popup--quiz",
            step: "1",
            template: "blank",
            events: { "click .select-quiz-template": "selectTemplate", "click .sui-dialog-close": "close", "change .powerform-new-form-type": "clickTemplate", "click #powerform-build-your-form": "handleMouseClick", keyup: "handleKeyClick" },
            popupTpl: Powerform.Utils.template(e(t).find("#powerform-form-popup-tpl").html()),
            newFormTpl: Powerform.Utils.template(e(t).find("#powerform-new-form-tpl").html()),
            newFormContent: Powerform.Utils.template(e(t).find("#powerform-new-form-content-tpl").html()),
            render: function() { var e = jQuery("#powerform-popup"); "1" === this.step && (this.$el.html(this.popupTpl({ templates: Powerform.Data.modules.custom_form.templates })), this.$el.find(".select-quiz-template").prop("disabled", !1), e.removeClass("sui-dialog-sm")), "2" === this.step && (this.$el.html(this.newFormTpl()), this.$el.find(".sui-box-body").html(this.newFormContent()), "registration" === this.template && (this.$el.find("#powerform-template-register-notice").show(), this.$el.find("#powerform-form-name").val(Powerform.l10n.popup.registration_name)), "login" === this.template && (this.$el.find("#powerform-template-login-notice").show(), this.$el.find("#powerform-form-name").val(Powerform.l10n.popup.login_name)), e.addClass("sui-dialog-sm")) },
            close: function(e) { e.preventDefault(), Powerform.New_Popup.close() },
            clickTemplate: function(e) { this.$el.find(".select-quiz-template").prop("disabled", !1) },
            selectTemplate: function(e) {
                e.preventDefault();
                var t = this.$el.find("input[name=powerform-form-template]:checked").val();
                this.template = t, this.step = "2", this.render()
            },
            handleMouseClick: function(e) { this.createQuiz(e) },
            handleKeyClick: function(e) { e.preventDefault(), 13 === e.which && this.createQuiz(e) },
            createQuiz: function(t) {
                var o = e(t.target).closest(".sui-box").find("#powerform-form-name");
                if ("" === o.val()) e(t.target).closest(".sui-box").find(".sui-error-message").show();
                else {
                    var i = Powerform.Data.modules.custom_form.new_form_url;
                    e(t.target).closest(".sui-box").find(".sui-error-message").hide(), form_url = i + "&name=" + o.val(), form_url = form_url + "&template=" + this.template, window.location.href = form_url
                }
            }
        })
    })
}(jQuery);