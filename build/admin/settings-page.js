! function(t) {
    formintorjs.define([], function() {
        var a = Backbone.View.extend({
                el: ".psource-powerform-powerform-settings",
                events: { "click .sui-side-tabs label.sui-tab-item input": "sidetabs", "click .sui-sidenav .sui-vertical-tab a": "sidenav", "change .sui-sidenav select.sui-mobile-nav": "sidenav_select", "click .stripe-connect-modal": "open_stripe_connect_modal", "click .paypal-connect-modal": "open_paypal_connect_modal", "click .powerform-stripe-connect": "connect_stripe", "click .disconnect_stripe": "disconnect_stripe", "click .powerform-paypal-connect": "connect_paypal", "click .disconnect_paypal": "disconnect_paypal", "click button.sui-tab-item": "buttonTabs", "click .powerform-toggle-unsupported-settings": "show_unsupported_settings", "click .powerform-dismiss-unsupported": "hide_unsupported_settings" },
                initialize: function() {
                    var a = this;
                    if (t(".psource-powerform-powerform-settings").length) {
                        this.$el.find(".powerform-settings-save").submit(function(n) {
                            n.preventDefault();
                            var i = t(this),
                                e = i.find(".psource-action-done").data("nonce"),
                                o = i.find(".psource-action-done").data("action"),
                                s = i.find(".psource-action-done").data("title"),
                                r = i.find(".psource-action-done").data("isReload");
                            a.submitForm(t(this), o, e, s, r)
                        });
                        var n = window.location.hash;
                        _.isUndefined(n) || _.isEmpty(n) || this.sidenav_go_to(n.substring(1), !0), this.render("v2"), this.render("v2-invisible"), this.render("v3")
                    }
                },
                render: function(a) {
                    var n = this.$el.find("#" + a + "-recaptcha-preview");
                    n.html('<p class="fui-loading-dialog"><i class="sui-icon-loader sui-loading" aria-hidden="true"></i></p>'), t.ajax({ url: Powerform.Data.ajaxUrl, type: "POST", data: { action: "powerform_load_recaptcha_preview", captcha: a } }).done(function(t) { t.success && n.html(t.data) })
                },
                submitForm: function(a, n, i, e, o) {
                    var s = {},
                        r = this;
                    s.action = "powerform_save_" + n + "_popup", s._ajax_nonce = i;
                    var d = a.serialize() + "&" + t.param(s);
                    t.ajax({
                        url: Powerform.Data.ajaxUrl,
                        type: "POST",
                        data: d,
                        beforeSend: function() { a.find(".sui-button").addClass("sui-button-onload") },
                        success: function(t) {
                            var a = _.template("<strong>{{ tab }}</strong> {{ Powerform.l10n.commons.update_successfully }}");
                            Powerform.Notification.open("success", a({ tab: e }), 4e3), "captcha" === n && (r.render("v2"), r.render("v2-invisible"), r.render("v3")), o && window.location.reload()
                        },
                        error: function(t) { Powerform.Notification.open("error", Powerform.l10n.commons.update_unsuccessfull, 4e3) }
                    }).always(function() { a.find(".sui-button").removeClass("sui-button-onload") })
                },
                sidetabs: function(t) {
                    var a = this.$(t.target),
                        n = a.parent("label"),
                        i = a.data("tab-menu"),
                        e = a.closest(".sui-side-tabs"),
                        o = e.find(".sui-tabs-menu .sui-tab-item"),
                        s = o.find("input");
                    a.is("input") && (o.removeClass("active"), s.removeAttr("checked"), e.find(".sui-tabs-content > div").removeClass("active"), n.addClass("active"), a.prop("checked", "checked"), e.find('.sui-tabs-content div[data-tab-content="' + i + '"]').length && e.find('.sui-tabs-content div[data-tab-content="' + i + '"]').addClass("active"))
                },
                sidenav: function(a) {
                    var n = t(a.target).data("nav");
                    n && this.sidenav_go_to(n, !0), a.preventDefault()
                },
                sidenav_select: function(a) {
                    var n = t(a.target).val();
                    n && this.sidenav_go_to(n, !0), a.preventDefault()
                },
                sidenav_go_to: function(t, a) {
                    var n = this.$el.find('a[data-nav="' + t + '"]'),
                        i = n.closest(".sui-vertical-tabs"),
                        e = i.find(".sui-vertical-tab"),
                        o = this.$el.find(".sui-box[data-nav]"),
                        s = this.$el.find('.sui-box[data-nav="' + t + '"]');
                    a && history.pushState({ selected_tab: t }, "Global Settings", "admin.php?page=powerform-settings&section=" + t), e.removeClass("current"), o.hide(), n.parent().addClass("current"), s.show()
                },
                open_stripe_connect_modal: function(a) {
                    a.preventDefault();
                    var n = this,
                        i = t(a.target),
                        e = i.data("modalImage"),
                        o = i.data("modalImageX2"),
                        s = i.data("modalTitle"),
                        r = i.data("modalNonce");
                    return Powerform.Stripe_Popup.open(function() {
                        var a = t(this);
                        n.render_stripe_connect_modal_content(a, "small", r, {})
                    }, { title: s, image: e, image_x2: o }), !1
                },
                render_stripe_connect_modal_content: function(a, n, i, e) {
                    var o = this;
                    e.action = "powerform_stripe_settings_modal", e._ajax_nonce = i, t.post({ url: Powerform.Data.ajaxUrl, type: "post", data: e }).done(function(e) {
                        if (e && e.success) {
                            a.find(".sui-box-header h3.sui-box-title").show(), a.find(".sui-box-body").html(e.data.html);
                            var s = e.data.buttons;
                            if (a.find(".sui-box-footer").html(""), _.each(s, function(t) { a.find(".sui-box-footer").append(t.markup) }), a.find(".sui-button").removeClass("sui-button-onload"), !_.isUndefined(n)) { var r = t("#powerform-stripe-popup"); "normal" === n && r.removeClass("sui-dialog-sm sui-dialog-lg"), "small" === n && (r.addClass("sui-dialog-sm"), r.removeClass("sui-dialog-lg")), "large" === n && (r.addClass("sui-dialog-lg"), r.removeClass("sui-dialog-sm")) }
                            _.isUndefined(e.data.notification) || _.isUndefined(e.data.notification.type) || _.isUndefined(e.data.notification.text) || _.isUndefined(e.data.notification.duration) || (Powerform.Notification.open(e.data.notification.type, e.data.notification.text, e.data.notification.duration).done(function() {}), o.update_stripe_page(i))
                        }
                    })
                },
                update_stripe_page: function(a) {
                    var n = { action: "powerform_stripe_update_page", _ajax_nonce: a };
                    t.post({ url: Powerform.Data.ajaxUrl, type: "get", data: n }).done(function(t) { jQuery("#sui-box-stripe").html(t.data), Powerform.Utils.sui_delegate_events(), Powerform.Stripe_Popup.close() })
                },
                show_unsupported_settings: function(a) { a.preventDefault(), t(".powerform-unsupported-settings").show() },
                hide_unsupported_settings: function(a) { a.preventDefault(), t(".powerform-unsupported-settings").hide() },
                connect_stripe: function(a) {
                    a.preventDefault();
                    var n = t(a.target);
                    n.addClass("sui-button-onload");
                    var i = n.data("nonce"),
                        e = this.$el.find("#powerform-stripe-popup"),
                        o = e.find("form"),
                        s = o.serializeArray(),
                        r = {};
                    return t.map(s, function(t, a) { r[t.name] = t.value }), r.connect = !0, this.render_stripe_connect_modal_content(e, "small", i, r), !1
                },
                buttonTabs: function(t) {
                    var a = this.$(t.target),
                        n = a.closest(".sui-tabs"),
                        i = n.find(".sui-tabs-menu .sui-tab-item"),
                        e = n.find(".sui-tabs-content .sui-tab-content");
                    a.is("button") && (i.removeClass("active"), i.attr("tabindex", "-1"), e.attr("hidden", !0), e.removeClass("active"), a.removeAttr("tabindex"), a.addClass("active"), n.find("#" + a.attr("aria-controls")).addClass("active"), n.find("#" + a.attr("aria-controls")).attr("hidden", !1), n.find("#" + a.attr("aria-controls")).removeAttr("hidden")), t.preventDefault()
                },
                open_paypal_connect_modal: function(a) {
                    a.preventDefault();
                    var n = this,
                        i = t(a.target),
                        e = i.data("modalImage"),
                        o = i.data("modalImageX2"),
                        s = i.data("modalTitle"),
                        r = i.data("modalNonce");
                    return Powerform.Stripe_Popup.open(function() {
                        var a = t(this);
                        n.render_paypal_connect_modal_content(a, "small", r, {})
                    }, { title: s, image: e, image_x2: o }), !1
                },
                render_paypal_connect_modal_content: function(a, n, i, e) {
                    var o = this;
                    e.action = "powerform_paypal_settings_modal", e._ajax_nonce = i, t.post({ url: Powerform.Data.ajaxUrl, type: "post", data: e }).done(function(e) {
                        if (e && e.success) {
                            a.find(".sui-box-header h3.sui-box-title").show(), a.find(".sui-box-body").html(e.data.html);
                            var s = e.data.buttons;
                            if (a.find(".sui-box-footer").html(""), _.each(s, function(t) { a.find(".sui-box-footer").append(t.markup) }), a.find(".sui-button").removeClass("sui-button-onload"), !_.isUndefined(n)) { var r = t("#powerform-paypal-popup"); "normal" === n && r.removeClass("sui-dialog-sm sui-dialog-lg"), "small" === n && (r.addClass("sui-dialog-sm"), r.removeClass("sui-dialog-lg")), "large" === n && (r.addClass("sui-dialog-lg"), r.removeClass("sui-dialog-sm")) }
                            _.isUndefined(e.data.notification) || _.isUndefined(e.data.notification.type) || _.isUndefined(e.data.notification.text) || _.isUndefined(e.data.notification.duration) || (Powerform.Notification.open(e.data.notification.type, e.data.notification.text, e.data.notification.duration).done(function() {}), o.update_paypal_page(i))
                        }
                    })
                },
                update_paypal_page: function(a) {
                    var n = { action: "powerform_paypal_update_page", _ajax_nonce: a };
                    t.post({ url: Powerform.Data.ajaxUrl, type: "get", data: n }).done(function(t) { jQuery("#sui-box-paypal").html(t.data), Powerform.Utils.sui_delegate_events(), Powerform.Stripe_Popup.close() })
                },
                connect_paypal: function(a) {
                    a.preventDefault();
                    var n = t(a.target);
                    n.addClass("sui-button-onload");
                    var i = n.data("nonce"),
                        e = this.$el.find("#powerform-stripe-popup"),
                        o = e.find("form"),
                        s = o.serializeArray(),
                        r = {};
                    return t.map(s, function(t, a) { r[t.name] = t.value }), r.connect = !0, this.render_paypal_connect_modal_content(e, "small", i, r), !1
                },
                disconnect_stripe: function(a) {
                    var n = t(a.target),
                        i = { action: "powerform_disconnect_stripe", _ajax_nonce: n.data("nonce") };
                    n.addClass("sui-button-onload"), t.post({ url: Powerform.Data.ajaxUrl, type: "get", data: i }).done(function(t) { jQuery("#sui-box-stripe").html(t.data.html), Powerform.Utils.sui_delegate_events(), Powerform.Popup.close(), _.isUndefined(t.data.notification) || _.isUndefined(t.data.notification.type) || _.isUndefined(t.data.notification.text) || _.isUndefined(t.data.notification.duration) || Powerform.Notification.open(t.data.notification.type, t.data.notification.text, t.data.notification.duration).done(function() {}) })
                },
                disconnect_paypal: function(a) {
                    var n = t(a.target),
                        i = { action: "powerform_disconnect_paypal", _ajax_nonce: n.data("nonce") };
                    n.addClass("sui-button-onload"), t.post({ url: Powerform.Data.ajaxUrl, type: "get", data: i }).done(function(t) { jQuery("#sui-box-paypal").html(t.data.html), Powerform.Utils.sui_delegate_events(), Powerform.Popup.close(), _.isUndefined(t.data.notification) || _.isUndefined(t.data.notification.type) || _.isUndefined(t.data.notification.text) || _.isUndefined(t.data.notification.duration) || Powerform.Notification.open(t.data.notification.type, t.data.notification.text, t.data.notification.duration).done(function() {}) })
                }
            }),
            a = new a;
        return a
    })
}(jQuery);
var powerform_render_admin_captcha = function() {
        setTimeout(function() {
            var t = jQuery(".powerform-g-recaptcha"),
                a = t.data("sitekey"),
                n = t.data("theme"),
                i = t.data("size");
            window.grecaptcha.render(t[0], { sitekey: a, theme: n, size: i })
        }, 100)
    },
    powerform_render_admin_captcha_v2 = function() {
        setTimeout(function() {
            var t = jQuery(".powerform-g-recaptcha-v2"),
                a = t.data("sitekey"),
                n = t.data("theme"),
                i = t.data("size");
            window.grecaptcha.render(t[0], { sitekey: a, theme: n, size: i })
        }, 100)
    },
    powerform_render_admin_captcha_v2_invisible = function() {
        setTimeout(function() {
            var t = jQuery(".powerform-g-recaptcha-v2-invisible"),
                a = t.data("sitekey"),
                n = t.data("theme"),
                i = t.data("size");
            window.grecaptcha.render(t[0], { sitekey: a, theme: n, size: i, badge: "inline" })
        }, 100)
    },
    powerform_render_admin_captcha_v3 = function() {
        setTimeout(function() {
            var t = jQuery(".powerform-g-recaptcha-v3"),
                a = t.data("sitekey"),
                n = t.data("theme"),
                i = t.data("size");
            window.grecaptcha.render(t[0], { sitekey: a, theme: n, size: i, badge: "inline" })
        }, 100)
    };