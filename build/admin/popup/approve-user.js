! function(o) {
    formintorjs.define(["text!tpl/dashboard.html"], function(t) {
        return Backbone.View.extend({
            className: "psource-section--popup",
            popupTpl: Powerform.Utils.template(o(t).find("#powerform-approve-user-popup-tpl").html()),
            events: { "click .approve-user.popup-confirmation-confirm": "approveUser" },
            initialize: function(o) { this.nonce = o.nonce, this.referrer = o.referrer, this.content = o.content || Powerform.l10n.popup.cannot_be_reverted, this.activationKey = o.activationKey },
            render: function() { this.$el.html(this.popupTpl({ nonce: this.nonce, id: this.id, referrer: this.referrer, content: this.content, activationKey: this.activationKey })) },
            submitForm: function(t, n, e) {
                var r = {};
                r.action = "powerform_approve_user_popup", r._ajax_nonce = n, r.activation_key = e;
                var i = t.serialize() + "&" + o.param(r);
                o.ajax({ url: Powerform.Data.ajaxUrl, type: "POST", data: i, beforeSend: function() { t.find(".sui-button").addClass("sui-button-onload") }, success: function(o) { o && o.success ? (Powerform.Notification.open("success", Powerform.l10n.commons.approve_user_successfull, 4e3), window.location.reload()) : Powerform.Notification.open("error", o.data, 4e3) }, error: function(o) { Powerform.Notification.open("error", Powerform.l10n.commons.approve_user_unsuccessfull, 4e3) } }).always(function() { t.find(".sui-button").removeClass("sui-button-onload") })
            },
            approveUser: function(t) {
                t.preventDefault(), o(t.target).addClass("sui-button-onload");
                var n = this.$el.find(".form-approve-user"),
                    e = n.find("form");
                return this.submitForm(e, this.nonce, this.activationKey), !1
            }
        })
    })
}(jQuery);