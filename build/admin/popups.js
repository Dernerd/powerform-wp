! function(o) {
    formintorjs.define(["admin/popup/templates", "admin/popup/login", "admin/popup/quizzes", "admin/popup/schedule", "admin/popup/new-form", "admin/popup/polls", "admin/popup/ajax", "admin/popup/delete", "admin/popup/preview", "admin/popup/reset-plugin-settings", "admin/popup/disconnect-stripe", "admin/popup/disconnect-paypal", "admin/popup/approve-user", "admin/popup/delete-unconfirmed-user"], function(e, p, i, n, t, a, s, r, u, d, l, m, c, f) {
        var h = Backbone.View.extend({
            el: "main.sui-wrap",
            events: { "click .psource-open-modal": "open_modal", "click .psource-button-open-modal": "open_modal" },
            initialize: function() {
                var o = Powerform.Utils.get_url_param("new"),
                    e = Powerform.Utils.get_url_param("title");
                if (o) {
                    var p = new t({ title: e });
                    p.render(), this.open_popup(p, Powerform.l10n.popup.congratulations)
                }
                return this.open_export(), this.open_delete(), this.render()
            },
            render: function() { return this },
            open_delete: function() {
                var o = Powerform.Utils.get_url_param("delete"),
                    e = Powerform.Utils.get_url_param("module_id"),
                    p = Powerform.Utils.get_url_param("nonce"),
                    i = Powerform.Utils.get_url_param("module_type"),
                    n = Powerform.l10n.popup.delete_form,
                    t = Powerform.l10n.popup.are_you_sure_form,
                    a = this;
                "poll" === i && (n = Powerform.l10n.popup.delete_poll, t = Powerform.l10n.popup.are_you_sure_poll), "quiz" === i && (n = Powerform.l10n.popup.delete_quiz, t = Powerform.l10n.popup.are_you_sure_quiz), o && setTimeout(function() { a.open_delete_popup("", e, p, n, t) }, 100)
            },
            open_export: function() {
                var o = Powerform.Utils.get_url_param("export"),
                    e = Powerform.Utils.get_url_param("module_id"),
                    p = Powerform.Utils.get_url_param("exportnonce"),
                    i = Powerform.Utils.get_url_param("module_type"),
                    n = this;
                o && setTimeout(function() { n.open_export_module_modal(i, p, e, Powerform.l10n.popup.export_cform, !1, !0, "psource-ajax-popup") }, 100)
            },
            open_modal: function(e) {
                e.preventDefault();
                var p = o(e.target);
                o(e.target).closest(".psource-split--item");
                p.hasClass("psource-open-modal") || p.hasClass("psource-button-open-modal") || (p = p.closest(".psource-open-modal"));
                var i = p.data("modal"),
                    n = p.data("nonce"),
                    t = p.data("form-id"),
                    a = p.data("has-leads"),
                    s = p.data("leads-id"),
                    r = p.data("modal-title"),
                    u = p.data("modal-content"),
                    d = p.data("nonce-preview");
                switch (i) {
                    case "custom_forms":
                        this.open_cform_popup();
                        break;
                    case "login_registration_forms":
                        this.open_login_popup();
                        break;
                    case "polls":
                        this.open_polls_popup();
                        break;
                    case "quizzes":
                        this.open_quizzes_popup();
                        break;
                    case "exports":
                        this.open_settings_modal(i, n, t, Powerform.l10n.popup.your_exports);
                        break;
                    case "exports-schedule":
                        this.open_exports_schedule_popup();
                        break;
                    case "delete-module":
                        this.open_delete_popup("", t, n, r, u);
                        break;
                    case "delete-poll-submission":
                        this.open_delete_popup("poll", t, n, r, u);
                        break;
                    case "paypal":
                        this.open_settings_modal(i, n, t, Powerform.l10n.popup.paypal_settings);
                        break;
                    case "preview_cforms":
                        _.isUndefined(r) && (r = Powerform.l10n.popup.preview_cforms), this.open_preview_popup(t, r, "powerform_load_cform", "powerform_forms", d);
                        break;
                    case "preview_polls":
                        _.isUndefined(r) && (r = Powerform.l10n.popup.preview_polls), this.open_preview_popup(t, r, "powerform_load_poll", "powerform_polls", d);
                        break;
                    case "preview_quizzes":
                        _.isUndefined(r) && (r = Powerform.l10n.popup.preview_quizzes), this.open_quiz_preview_popup(t, r, "powerform_load_quiz", "powerform_quizzes", a, s, d);
                        break;
                    case "captcha":
                        this.open_settings_modal(i, n, t, Powerform.l10n.popup.captcha_settings, !1, !0, "psource-ajax-popup");
                        break;
                    case "currency":
                        this.open_settings_modal(i, n, t, Powerform.l10n.popup.currency_settings, !1, !0, "psource-ajax-popup");
                        break;
                    case "pagination_entries":
                        this.open_settings_modal(i, n, t, Powerform.l10n.popup.pagination_entries, !1, !0, "psource-ajax-popup");
                        break;
                    case "pagination_listings":
                        this.open_settings_modal(i, n, t, Powerform.l10n.popup.pagination_listings, !1, !0, "psource-ajax-popup");
                        break;
                    case "email_settings":
                        this.open_settings_modal(i, n, t, Powerform.l10n.popup.email_settings, !1, !0, "psource-ajax-popup");
                        break;
                    case "uninstall_settings":
                        this.open_settings_modal(i, n, t, Powerform.l10n.popup.uninstall_settings, !1, !0, "psource-ajax-popup");
                        break;
                    case "privacy_settings":
                        this.open_settings_modal(i, n, t, Powerform.l10n.popup.privacy_settings, !1, !0, "psource-ajax-popup");
                        break;
                    case "export_cform":
                        this.open_export_module_modal("custom_form", n, t, Powerform.l10n.popup.export_cform, !1, !0, "psource-ajax-popup");
                        break;
                    case "export_poll":
                        this.open_export_module_modal("poll", n, t, Powerform.l10n.popup.export_poll, !1, !0, "psource-ajax-popup");
                        break;
                    case "export_quiz":
                        this.open_export_module_modal("quiz", n, t, Powerform.l10n.popup.export_quiz, !1, !0, "psource-ajax-popup");
                        break;
                    case "import_cform":
                        this.open_import_module_modal("custom_form", n, t, Powerform.l10n.popup.import_cform, !1, !0, "psource-ajax-popup");
                        break;
                    case "import_cform_cf7":
                        this.open_import_module_modal("custom_form_cf7", n, t, Powerform.l10n.popup.import_cform_cf7, !1, !0, "psource-ajax-popup");
                        break;
                    case "import_cform_ninja":
                        this.open_import_module_modal("custom_form_ninja", n, t, Powerform.l10n.popup.import_cform_ninja, !1, !0, "psource-ajax-popup");
                        break;
                    case "import_cform_gravity":
                        this.open_import_module_modal("custom_form_gravity", n, t, Powerform.l10n.popup.import_cform_gravity, !1, !0, "psource-ajax-popup");
                        break;
                    case "import_poll":
                        this.open_import_module_modal("poll", n, t, Powerform.l10n.popup.import_poll, !1, !0, "psource-ajax-popup");
                        break;
                    case "import_quiz":
                        this.open_import_module_modal("quiz", n, t, Powerform.l10n.popup.import_quiz, !1, !0, "psource-ajax-popup");
                        break;
                    case "reset-plugin-settings":
                        this.open_reset_plugin_settings_popup(n, r, u);
                        break;
                    case "disconnect-stripe":
                        this.open_disconnect_stripe_popup(n, r, u);
                        break;
                    case "disconnect-paypal":
                        this.open_disconnect_paypal_popup(n, r, u);
                        break;
                    case "approve-user-module":
                        var l = p.data("activation-key");
                        this.open_approve_user_popup(n, r, u, l);
                        break;
                    case "delete-unconfirmed-user-module":
                        this.open_unconfirmed_user_popup(p.data("form-id"), n, r, u, p.data("activation-key"), p.data("entry-id"))
                }
            },
            open_popup: function(e, p, i, n, t, a, s) {
                _.isUndefined(p) && (p = Powerform.l10n.custom_form.popup_label);
                var r = { title: p };
                _.isUndefined(i) || (r.has_custom_box = i), _.isUndefined(n) || (r.action_text = n), _.isUndefined(t) || (r.action_css_class = t), _.isUndefined(a) || (r.action_callback = a), Powerform.Popup.open(function() { _.isUndefined(e.el) ? o(this).append(e) : o(this).append(e.el), "function" == typeof s && s.apply(this) }, r)
            },
            open_ajax_popup: function(e, p, i, n, t, a, r) {
                _.isUndefined(n) && (n = Powerform.l10n.custom_form.popup_label), _.isUndefined(t) && (t = !0), _.isUndefined(a) && (a = !1), _.isUndefined(r) && (r = "sui-box-body");
                var u = new s({ action: e, nonce: p, id: i, enable_loader: !0, className: r }),
                    d = { title: n, has_custom_box: a };
                Powerform.Popup.open(function() { o(this).append(u.el) }, d)
            },
            open_cform_popup: function() {
                var p = new e({ type: "form" });
                p.render();
                var i = p;
                Powerform.New_Popup.open(function() { _.isUndefined(i.el) ? o(this).append(i) : o(this).append(i.el), o(this).closest(".sui-dialog").removeClass("sui-dialog-sm"), o(this).closest(".sui-dialog").addClass("sui-dialog-alt"), o(this).closest(".sui-dialog").find(".sui-box-header").addClass("sui-block-content-center") }, { title: "", has_custom_box: !0 })
            },
            open_delete_popup: function(e, p, i, n, t) {
                var a = new r({ module: e, id: p, nonce: i, referrer: window.location.pathname + window.location.search, content: t });
                a.render();
                var s = a;
                Powerform.Popup.open(function() { _.isUndefined(s.el) ? o(this).append(s) : o(this).append(s.el) }, { title: n, has_custom_box: !0 })
            },
            open_login_popup: function() {
                var o = new p;
                o.render(), this.open_popup(o, Powerform.l10n.popup.edit_login_form)
            },
            open_polls_popup: function() {
                var e = new a({ type: "poll" });
                e.render();
                var p = e;
                Powerform.New_Popup.open(function() { _.isUndefined(p.el) ? o(this).append(p) : o(this).append(p.el) }, { title: "" })
            },
            open_quizzes_popup: function() {
                var e = new i;
                e.render();
                var p = e;
                Powerform.New_Popup.open(function() { _.isUndefined(p.el) ? o(this).append(p) : o(this).append(p.el), o(this).closest(".sui-dialog").removeClass("sui-dialog-sm"), o(this).closest(".sui-dialog").addClass("sui-dialog-alt"), o(this).closest(".sui-dialog").find(".sui-box-header").addClass("sui-block-content-center") }, { title: Powerform.l10n.quiz.choose_quiz_title, has_custom_box: !0 })
            },
            open_exports_schedule_popup: function() {
                var o = new n;
                o.render(), this.open_popup(o, Powerform.l10n.popup.edit_scheduled_export, !0)
            },
            open_settings_modal: function(o, e, p, i, n, t, a) { this.open_ajax_popup(o, e, p, i, n, t, a) },
            open_export_module_modal: function(o, e, p, i, n, t, a) {
                var s = "";
                switch (o) {
                    case "custom_form":
                        s = "export_custom_form";
                        break;
                    case "poll":
                        s = "export_poll";
                        break;
                    case "quiz":
                        s = "export_quiz"
                }
                this.open_ajax_popup(s, e, p, i, n, t, a)
            },
            open_import_module_modal: function(o, e, p, i, n, t, a) {
                var s = "";
                switch (o) {
                    case "custom_form":
                        s = "import_custom_form";
                        break;
                    case "custom_form_cf7":
                        s = "import_custom_form_cf7";
                        break;
                    case "custom_form_ninja":
                        s = "import_custom_form_ninja";
                        break;
                    case "custom_form_gravity":
                        s = "import_custom_form_gravity";
                        break;
                    case "poll":
                        s = "import_poll";
                        break;
                    case "quiz":
                        s = "import_quiz"
                }
                this.open_ajax_popup(s, e, p, i, n, t, a)
            },
            open_preview_popup: function(e, p, i, n, t) {
                _.isUndefined(p) && (p = Powerform.l10n.custom_form.popup_label);
                var a = new u({ action: i, type: n, nonce: t, id: e, enable_loader: !0, className: "sui-box-body" }),
                    s = { title: p, has_custom_box: !0 };
                Powerform.Popup.open(function() { o(this).append(a.el) }, s)
            },
            open_quiz_preview_popup: function(e, p, i, n, t, a, s) {
                _.isUndefined(p) && (p = Powerform.l10n.custom_form.popup_label);
                var r = new u({ action: i, type: n, id: e, enable_loader: !0, className: "sui-box-body", has_lead: t, leads_id: a, nonce: s }),
                    d = { title: p, has_custom_box: !0 };
                Powerform.Popup.open(function() { o(this).append(r.el) }, d)
            },
            open_reset_plugin_settings_popup: function(e, p, i) {
                var n = new d({ nonce: e, referrer: window.location.pathname + window.location.search, content: i });
                n.render();
                var t = n;
                Powerform.Popup.open(function() { _.isUndefined(t.el) ? o(this).append(t) : o(this).append(t.el), o(this).closest(".sui-dialog").addClass("sui-dialog-alt sui-dialog-sm"), o(this).closest(".sui-dialog").find(".sui-box-header, .sui-box-body").addClass("sui-block-content-center"), o(this).closest(".sui-dialog").find(".sui-box-body").css({ "padding-top": "10px" }), o(this).closest(".sui-dialog").find(".sui-box-footer").css({ "padding-top": "0", "padding-bottom": "40px", "justify-content": "center" }) }, { title: p, has_custom_box: !0 })
            },
            open_disconnect_stripe_popup: function(e, p, i) {
                var n = new l({ nonce: e, referrer: window.location.pathname + window.location.search, content: i });
                n.render();
                var t = n;
                Powerform.Popup.open(function() { _.isUndefined(t.el) ? o(this).append(t) : o(this).append(t.el), o(this).closest(".sui-dialog").addClass("sui-dialog-alt sui-dialog-sm"), o(this).closest(".sui-dialog").find(".sui-box-header, .sui-box-body").addClass("sui-block-content-center"), o(this).closest(".sui-dialog").find(".sui-box-body").css({ "padding-top": "10px" }), o(this).closest(".sui-dialog").find(".sui-box-footer").css({ "padding-top": "0", "padding-bottom": "40px", "justify-content": "center" }) }, { title: p, has_custom_box: !0 })
            },
            open_disconnect_paypal_popup: function(e, p, i) {
                var n = new m({ nonce: e, referrer: window.location.pathname + window.location.search, content: i });
                n.render();
                var t = n;
                Powerform.Popup.open(function() { _.isUndefined(t.el) ? o(this).append(t) : o(this).append(t.el), o(this).closest(".sui-dialog").addClass("sui-dialog-alt sui-dialog-sm"), o(this).closest(".sui-dialog").find(".sui-box-header, .sui-box-body").addClass("sui-block-content-center"), o(this).closest(".sui-dialog").find(".sui-box-body").css({ "padding-top": "10px" }), o(this).closest(".sui-dialog").find(".sui-box-footer").css({ "padding-top": "0", "padding-bottom": "40px", "justify-content": "center" }) }, { title: p, has_custom_box: !0 })
            },
            open_approve_user_popup: function(e, p, i, n) {
                var t = new c({ nonce: e, referrer: window.location.pathname + window.location.search, content: i, activationKey: n });
                t.render();
                var a = t;
                Powerform.Popup.open(function() { _.isUndefined(a.el) ? o(this).append(a) : o(this).append(a.el), o(this).closest(".sui-dialog").addClass("sui-dialog-alt sui-dialog-sm"), o(this).closest(".sui-dialog").find(".sui-box-header, .sui-box-body").addClass("sui-block-content-center"), o(this).closest(".sui-dialog").find(".sui-box-body").css({ "padding-top": "10px" }), o(this).closest(".sui-dialog").find(".sui-box-footer").css({ "padding-top": "0", "padding-bottom": "40px", "justify-content": "center" }) }, { title: p, has_custom_box: !0 })
            },
            open_unconfirmed_user_popup: function(e, p, i, n, t, a) {
                var s = new f({ formId: e, nonce: p, referrer: window.location.pathname + window.location.search, content: n, activationKey: t, entryId: a });
                s.render();
                var r = s;
                Powerform.Popup.open(function() { _.isUndefined(r.el) ? o(this).append(r) : o(this).append(r.el) }, { title: i, has_custom_box: !0 })
            }
        });
        jQuery(document).ready(function() { new h })
    })
}(jQuery);