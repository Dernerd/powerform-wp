! function(t) {
    formintorjs.define(["text!tpl/dashboard.html"], function(e) {
        return Backbone.View.extend({
            className: "psource-section--popup",
            popupTpl: Powerform.Utils.template(t(e).find("#powerform-delete-unconfirmed-user-popup-tpl").html()),
            events: { "click .delete-unconfirmed-user.popup-confirmation-confirm": "deleteUnconfirmedUser" },
            initialize: function(t) { this.nonce = t.nonce, this.formId = t.formId, this.referrer = t.referrer, this.content = t.content || Powerform.l10n.popup.cannot_be_reverted, this.activationKey = t.activationKey, this.entryId = t.entryId },
            render: function() { this.$el.html(this.popupTpl({ nonce: this.nonce, formId: this.formId, referrer: this.referrer, content: this.content, activationKey: this.activationKey, entryId: this.entryId })) },
            submitForm: function(e, n, o, i, r) {
                var a = { action: "powerform_delete_unconfirmed_user_popup", _ajax_nonce: n, activation_key: o, form_id: i, entry_id: r },
                    s = e.serialize() + "&" + t.param(a);
                t.ajax({ url: Powerform.Data.ajaxUrl, type: "POST", data: s, beforeSend: function() { e.find(".sui-button").addClass("sui-button-onload") }, success: function(t) { t && t.success ? window.location.reload() : Powerform.Notification.open("error", t.data, 4e3) }, error: function(t) { Powerform.Notification.open("error", t.data, 4e3) } }).always(function() { e.find(".sui-button").removeClass("sui-button-onload") })
            },
            deleteUnconfirmedUser: function(e) {
                e.preventDefault(), t(e.target).addClass("sui-button-onload");
                var n = this.$el.find(".form-delete-unconfirmed-user"),
                    o = n.find("form");
                return this.submitForm(o, this.nonce, this.activationKey, this.formId, this.entryId), !1
            }
        })
    })
}(jQuery);