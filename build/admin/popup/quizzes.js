! function(e) {
    formintorjs.define(["text!tpl/dashboard.html"], function(t) {
        return Backbone.View.extend({
            className: "psource-popup--quiz",
            step: "1",
            type: "knowledge",
            events: { "click .select-quiz-template": "selectTemplate", "click .sui-dialog-close": "close", "change .powerform-new-quiz-type": "clickTemplate", "click #powerform-build-your-form": "handleMouseClick", "click #powerform-new-quiz-leads": "handleToggle", keyup: "handleKeyClick" },
            popupTpl: Powerform.Utils.template(e(t).find("#powerform-quizzes-popup-tpl").html()),
            newFormTpl: Powerform.Utils.template(e(t).find("#powerform-new-quiz-tpl").html()),
            newFormContent: Powerform.Utils.template(e(t).find("#powerform-new-quiz-content-tpl").html()),
            render: function() { var e = jQuery("#powerform-popup"); "1" === this.step && (this.$el.html(this.popupTpl()), this.$el.find(".select-quiz-template").prop("disabled", !1), e.removeClass("sui-dialog-sm")), "2" === this.step && (this.$el.html(this.newFormTpl()), this.$el.find(".sui-box-body").html(this.newFormContent()), e.addClass("sui-dialog-sm powerform-create-quiz-second-step")) },
            close: function(e) { e.preventDefault(), Powerform.New_Popup.close() },
            clickTemplate: function(e) { this.$el.find(".select-quiz-template").prop("disabled", !1) },
            selectTemplate: function(t) {
                t.preventDefault();
                var i = this.$el.find("input[name=powerform-new-quiz]:checked").val(),
                    o = this.$el.find("#powerform-form-name").val();
                "" === o ? e(t.target).closest(".sui-box").find("#sui-quiz-name-error").show() : (this.type = i, this.name = o, this.step = "2", this.render())
            },
            handleMouseClick: function(e) { this.createQuiz(e) },
            handleKeyClick: function(e) { e.preventDefault(), 13 === e.which && ("1" === this.step ? this.selectTemplate(e) : this.createQuiz(e)) },
            handleToggle: function(t) {
                var i = e(t.target).is(":checked"),
                    o = e(t.target).closest(".sui-box").find("#sui-quiz-leads-description");
                i ? o.show() : o.hide()
            },
            createQuiz: function(t) {
                var i = e(t.target).closest(".sui-box").find("#powerform-new-quiz-leads").is(":checked"),
                    o = Powerform.Data.modules.quizzes.knowledge_url;
                "nowrong" === this.type && (o = Powerform.Data.modules.quizzes.nowrong_url), form_url = o + "&name=" + this.name, i && (form_url += "&leads=true"), window.location.href = form_url
            }
        })
    })
}(jQuery);