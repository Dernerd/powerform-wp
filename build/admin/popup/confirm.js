! function(o) {
    formintorjs.define(["text!tpl/dashboard.html"], function(n) {
        return Backbone.View.extend({
            className: "psource-section--popup",
            popupTpl: Powerform.Utils.template(o(n).find("#powerform-confirmation-popup-tpl").html()),
            default_options: { confirmation_message: Powerform.l10n.popup.confirm_action, confirmation_title: Powerform.l10n.popup.confirm_title, confirm_callback: function() { this.close() }, cancel_callback: function() { this.close() } },
            confirm_options: {},
            events: { "click .popup-confirmation-confirm": "confirm_action", "click .popup-confirmation-cancel": "cancel_action" },
            initialize: function(o) { this.confirm_options = _.defaults(o, this.default_options), this.render(), this.open() },
            render: function() { return this.$el.html(this.popupTpl(this.confirm_options)), this },
            confirm_action: function() { this.confirm_options.confirm_callback.apply(this, []) },
            cancel_action: function() { this.confirm_options.cancel_callback.apply(this, []) },
            open: function() {
                var n = this;
                Powerform.Popup.open(function() { o(this).append(n.$el) }, { title: n.confirm_options.confirmation_title, has_custom_box: !0 })
            },
            close: function() { Powerform.Popup.close() }
        })
    })
}(jQuery);