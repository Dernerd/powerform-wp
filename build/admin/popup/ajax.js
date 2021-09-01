! function(a) {
    formintorjs.define(["text!tpl/dashboard.html"], function(i) {
        return Backbone.View.extend({
            className: "sui-box-body",
            events: { "click .psource-action-done": "save", "click .psource-action-ajax-done": "ajax_save", "click .psource-action-ajax-cf7-import": "ajax_cf7_import", "click .psource-button-clear-exports": "clear_exports", "click .powerform-radio--field": "show_poll_custom_input", "click .powerform-popup-close": "close_popup", "click .powerform-retry-import": "ajax_cf7_import", "change #powerform-choose-import-form": "import_form_action", "change .powerform-import-forms": "import_form_action" },
            initialize: function(a) { return a = _.extend({ action: "", nonce: "", data: "", id: "", enable_loader: !0 }, a), this.action = a.action, this.nonce = a.nonce, this.data = a.data, this.id = a.id, this.enable_loader = a.enable_loader, this.render() },
            render: function() {
                var i = this,
                    t = {};
                if (t.action = "powerform_load_" + this.action + "_popup", t._ajax_nonce = this.nonce, t.data = this.data, this.id && (t.id = this.id), this.enable_loader) { var o = ""; "sui-box-body" !== this.className && (o += '<div class="sui-box-body">'), o += '<p class="fui-loading-dialog" aria-label="Loading content"><i class="sui-icon-loader sui-loading" aria-hidden="true"></i></p>', "sui-box-body" !== this.className && (o += "</div>"), i.$el.html(o) }
                a.post({ url: Powerform.Data.ajaxUrl, type: "post", data: t }).done(function(a) {
                    if (a && a.success) {
                        i.$el.html(a.data), i.$el.find(".psource-hidden-popup").show(400), Powerform.Utils.sui_delegate_events();
                        i.$el.find(".powerform-custom-form");
                        i.delegateEvents()
                    }
                }).always(function() { i.$el.find(".fui-loading-dialog").remove() })
            },
            save: function(i) {
                i.preventDefault();
                var t = {},
                    o = a(i.target).data("nonce");
                t.action = "powerform_save_" + this.action + "_popup", t._ajax_nonce = o, a(".psource-popup-form input, .psource-popup-form select").each(function() {
                    var i = a(this);
                    t[i.attr("name")] = i.val()
                }), a.ajax({ url: Powerform.Data.ajaxUrl, type: "POST", data: t, success: function(a) { Powerform.Popup.close(!1, function() { window.location.reload() }) } })
            },
            ajax_save: function(i) {
                var t = this;
                i.preventDefault();
                var o = {},
                    e = a(i.target).data("nonce");
                o.action = "powerform_save_" + this.action + "_popup", o._ajax_nonce = e, a(".psource-popup-form input, .psource-popup-form select, .psource-popup-form textarea").each(function() {
                    var i = a(this);
                    o[i.attr("name")] = i.val()
                }), this.$el.find(".sui-button:not(.disable-loader)").addClass("sui-button-onload"), this.$el.find(".psource-ajax-error-placeholder").addClass("sui-hidden"), a.ajax({
                    url: Powerform.Data.ajaxUrl,
                    type: "POST",
                    data: o,
                    success: function(a) {
                        if (!0 === a.success) {
                            var i = !1;
                            _.isUndefined(a.data.url) || (i = a.data.url), Powerform.Popup.close(!1, function() { i && (location.href = i) })
                        } else _.isUndefined(a.data) || t.$el.find(".psource-ajax-error-placeholder").removeClass("sui-hidden").find("p").text(a.data)
                    }
                }).always(function() { t.$el.find(".sui-button:not(.disable-loader)").removeClass("sui-button-onload") })
            },
            clear_exports: function(i) {
                i.preventDefault();
                var t = {},
                    o = this,
                    e = a(i.target).data("nonce"),
                    n = a(i.target).data("form-id");
                t.action = "powerform_clear_" + this.action + "_popup", t._ajax_nonce = e, t.id = n, a.ajax({ url: Powerform.Data.ajaxUrl, type: "POST", data: t, success: function() { o.render() } })
            },
            show_poll_custom_input: function(i) {
                var t = this,
                    o = this.$el.find(".powerform-input"),
                    e = i.target.checked,
                    n = a(i.target).attr("id");
                if (o.hide(), t.$el.find(".powerform-input#" + n + "-extra").length) {
                    var r = t.$el.find(".powerform-input#" + n + "-extra");
                    e ? r.show() : r.hide()
                }
            },
            ajax_cf7_import: function(i) {
                var t = this,
                    o = t.$el.find("form").serializeArray();
                i.preventDefault(), this.$el.find(".sui-button:not(.disable-loader)").addClass("sui-button-onload"), this.$el.find(".psource-ajax-error-placeholder").addClass("sui-hidden"), this.$el.find(".powerform-cf7-imported-fail").addClass("sui-hidden"), a.ajax({
                    url: Powerform.Data.ajaxUrl,
                    type: "POST",
                    data: o,
                    xhr: function() {
                        var a = new window.XMLHttpRequest;
                        return a.upload.addEventListener("progress", function(a) {
                            if (a.lengthComputable) {
                                var i = a.loaded / a.total;
                                i = parseInt(100 * i), t.$el.find(".powerform-cf7-importing .sui-progress-text").html(i + "%"), t.$el.find(".powerform-cf7-importing .sui-progress-bar span").css("width", i + "%")
                            }
                        }, !1), a
                    },
                    success: function(a) {!0 === a.success ? setTimeout(function() { t.$el.find(".powerform-cf7-importing").addClass("sui-hidden"), t.$el.find(".powerform-cf7-imported").removeClass("sui-hidden") }, 1e3) : _.isUndefined(a.data) || (setTimeout(function() { t.$el.find(".powerform-cf7-importing").addClass("sui-hidden"), t.$el.find(".powerform-cf7-imported-fail").removeClass("sui-hidden") }, 1e3), t.$el.find(".psource-ajax-error-placeholder").removeClass("sui-hidden").find("p").text(a.data)) }
                }).always(function(a) { t.$el.find(".sui-button:not(.disable-loader)").removeClass("sui-button-onload"), t.$el.find(".powerform-cf7-import").addClass("sui-hidden"), t.$el.find(".powerform-cf7-importing").removeClass("sui-hidden") })
            },
            close_popup: function() { Powerform.Popup.close() },
            import_form_action: function(i) {
                i.preventDefault();
                var t = a(i.target),
                    o = t.val(),
                    e = !1;
                "specific" === o && (e = !0), (null == o || Array.isArray(o) && o.length < 1) && (e = !0), this.$el.find(".psource-action-ajax-cf7-import").prop("disabled", e)
            }
        })
    })
}(jQuery);