! function(t) {
    formintorjs.define(["admin/addons/view"], function(i) {
        var e = Backbone.View.extend({
            el: ".sui-wrap.psource-powerform-powerform-integrations",
            currentTab: "powerform-integrations",
            events: { "change .powerform-addon-toggle-enabled": "toggle_state", "click .connect-integration": "connect_integration", "click .powerform-integrations-wrapper .sui-vertical-tab a": "go_to_tab", "change .powerform-integrations-wrapper .sui-sidenav-hide-lg select": "go_to_tab", "keyup input.sui-form-control": "required_settings" },
            initialize: function(i) { if (t(this.el).length > 0) return this.listenTo(Powerform.Events, "powerform:addons:reload", this.render_addons_page), this.render() },
            render: function() { this.render_addons_page(), this.update_tab() },
            render_addons_page: function() {
                var i = this,
                    e = {};
                this.$el.find("#powerform-integrations-display").html('<div class="sui-notice sui-notice-loading"><p>Fetching integration list…</p></div>'), e.action = "powerform_addon_get_addons", e._ajax_nonce = Powerform.Data.addonNonce, e.data = {}, t.post({ url: Powerform.Data.ajaxUrl, type: "post", data: e }).done(function(t) { t && t.success && i.$el.find("#powerform-integrations-page").html(t.data.data) }).always(function() { i.$el.find(".sui-notice sui-notice-loading").remove() })
            },
            connect_integration: function(e) {
                e.preventDefault();
                var a = t(e.target);
                a.hasClass("connect-integration") || (a = a.closest(".connect-integration"));
                var n = a.data("nonce"),
                    r = a.data("slug"),
                    o = a.data("title"),
                    s = a.data("image"),
                    d = a.data("imagex2"),
                    l = a.data("action"),
                    u = a.data("form-id"),
                    f = a.data("multi-id");
                Powerform.Integrations_Popup.open(function() { new i({ slug: r, nonce: n, action: l, form_id: u, multi_id: f, el: t(this) }) }, { title: o, image: s, image_x2: d })
            },
            go_to_tab: function(i) {
                i.preventDefault();
                var e = t(i.target),
                    a = e.attr("href"),
                    n = "";
                if (_.isUndefined(a)) { n = e.val() } else n = a.replace("#", "", a);
                _.isEmpty(n) || (this.currentTab = n), this.update_tab(), i.stopPropagation()
            },
            update_tab_select: function() { this.$el.hasClass("psource-powerform-powerform-integrations") && (this.$el.find(".sui-sidenav-hide-lg select").val(this.currentTab), this.$el.find(".sui-sidenav-hide-lg select").trigger("sui:change")) },
            update_tab: function() { this.$el.hasClass("psource-powerform-powerform-integrations") && (this.clear_tabs(), this.$el.find("[data-tab-id=" + this.currentTab + "]").addClass("current"), this.$el.find(".psource-settings--box#" + this.currentTab).show()) },
            clear_tabs: function() { this.$el.hasClass("psource-powerform-powerform-integrations") && (this.$el.find(".sui-vertical-tab ").removeClass("current"), this.$el.find(".psource-settings--box").hide()) },
            required_settings: function(i) {
                var e = t(i.target),
                    a = e.parent(),
                    n = a.find(".sui-error-message"),
                    r = e.closest("div[data-nav]"),
                    o = r.find(".sui-box-footer"),
                    s = o.find(".psource-action-done");
                this.$el.hasClass("psource-powerform-powerform-settings") && (e.hasClass("powerform-required") && !e.val() && a.hasClass("sui-form-field") && (a.addClass("sui-form-field-error"), n.show()), e.hasClass("powerform-required") && e.val() && a.hasClass("sui-form-field") && (a.removeClass("sui-form-field-error"), n.hide()), r.find("input.sui-form-control").hasClass("powerform-required") && (0 === r.find("div.sui-form-field-error").length ? s.prop("disabled", !1) : s.prop("disabled", !0))), i.stopPropagation()
            }
        });
        jQuery(document).ready(function() { new e })
    })
}(jQuery);