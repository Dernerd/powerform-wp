function copyToClipboard(e) {
    var t = jQuery("<input />");
    jQuery("body").append(t), t.val(e).select(), document.execCommand("copy"), t.remove()
}! function(e, t) {
    "use strict";
    ! function() {
        e(document).ready(function() {
            if ("object" == typeof window.Powerform && "object" == typeof window.Powerform.Utils && Powerform.Utils.sui_delegate_events(), e(".powerform-toggle-entries-filter").click(function(t) { return e(this).toggleClass("sui-active"), e(this).closest(".sui-box-body").find(".sui-pagination-filter").toggleClass("sui-open"), !1 }), void 0 !== e.fn.daterangepicker) {
                var t = {};
                void 0 !== window.powerform_entries_datepicker_ranges && (t = window.powerform_entries_datepicker_ranges), e("input.powerform-entries-filter-date").daterangepicker({ autoUpdateInput: !1, autoApply: !0, alwaysShowCalendars: !0, ranges: t, locale: powerforml10n.daterangepicker }), e("input.powerform-entries-filter-date").on("apply.daterangepicker", function(t, i) { e(this).val(i.startDate.format("MM/DD/YYYY") + " - " + i.endDate.format("MM/DD/YYYY")) })
            }
            e("form.powerform-entries-actions").on("submit", function() { return "" === e(this).find("select[name=entries-action]").val() && "" === e(this).find("select[name=entries-action-bottom]").val() ? e(this).find("fieldset.powerform-entries-nonce").attr("disabled", "disabled") : e(this).find("fieldset.powerform-entries-nonce").removeAttr("disabled"), !0 }), e(".powerform-entries-clear-filter").click(function() { return e(this).closest(".sui-pagination-filter").find("input[name=date_range]").val("").trigger("change"), e(this).closest(".sui-pagination-filter").find("input[name=search]").val("").trigger("change"), e(this).closest(".sui-pagination-filter").find("input[name=min_id]").val("").trigger("change"), e(this).closest(".sui-pagination-filter").find("input[name=max_id]").val("").trigger("change"), e(this).closest(".sui-pagination-filter").find("select[name=order_by] option").removeAttr("selected"), e(this).closest(".sui-pagination-filter").find("select[name=order_by]").val("").trigger("change"), e(this).closest(".sui-pagination-filter").find("select[name=order_by] option").removeAttr("selected"), e(this).closest(".sui-pagination-filter").find("select[name=order_by]").val("").trigger("change"), e(this).closest(".sui-pagination-filter").find("select[name=order] option").removeAttr("selected"), e(this).closest(".sui-pagination-filter").find("select[name=order]").val("").trigger("change"), e(this).closest(".sui-pagination-filter").find(".powerform-field-select-tab .sui-tabs-menu label[data-tab-index=1]").trigger("click"), e(this).closest(".sui-pagination-filter").find("fieldset.powerform-entries-fields-filter").attr("disabled", "disabled"), !1 }), e(".powerform-field-select-tab .sui-tabs-menu label").click(function() {
                var t = e(this).data("tab-index");
                t = +t, e(this).closest(".sui-side-tabs").find(".sui-tabs-menu label").removeClass("active"), e(this).addClass("active"), e(this).closest(".sui-side-tabs").find(".sui-tabs-content .sui-tab-content").removeClass("active"), e(this).closest(".sui-side-tabs").find(".sui-tabs-content .sui-tab-content[data-tab-index=" + t + "]").addClass("active"), 1 === t ? e(this).closest(".sui-side-tabs").find("fieldset.powerform-entries-fields-filter").attr("disabled", "disabled") : e(this).closest(".sui-side-tabs").find("fieldset.powerform-entries-fields-filter").removeAttr("disabled")
            }), e("#wpf-cform-check_all").on("click", function(t) {
                var i = this.checked,
                    n = e(this).closest("table");
                e(n).find(".sui-checkbox input").each(function() { this.checked = i })
            }), e("#powerform-check-all-modules").on("click", function() {
                var t = this.checked;
                if (e("#powerform-modules-list").length && (e("#powerform-modules-list").find('.sui-checkbox input[id|="wpf-module"]').each(function() { this.checked = t }), e('form[name="bulk-action-form"] input[name="ids"]').length)) {
                    var i = e("#powerform-modules-list").find('.sui-checkbox input[id|="wpf-module"]:checked').map(function() { if (parseFloat(this.value)) return this.value }).get().join(",");
                    e('form[name="bulk-action-form"] input[name="ids"]').val(i)
                }
            }), e(".sui-checkbox input").on("click", function() {
                if (e('form[name="bulk-action-form"] input[name="ids"]').length) {
                    var t = e(".sui-checkbox input:checked").map(function() { if (parseFloat(this.value)) return this.value }).get().join(",");
                    e('form[name="bulk-action-form"] input[name="ids"]').val(t)
                }
                "powerform-check-all-modules" !== e(this).attr("id") && e("#powerform-check-all-modules").prop("checked", !1)
            }), e(".psource-can--hide").ready(function() { e(this).find(".psource-box-header").on("click", function() { e(this).closest(".psource-can--hide").toggleClass("psource-is--hidden") }) }), e(document).on("click", ".psource-open-entry", function(t) {
                if ("checkbox" !== e(t.target).attr("type") && !e(t.target).hasClass("wpdui-icon-check")) {
                    t.preventDefault(), t.stopPropagation();
                    var i = e(this),
                        n = i.data("entry"),
                        a = e("#powerform-" + n),
                        o = !0;
                    a.hasClass("psource-is_open") && (o = !1), e(".psource-entries--result").removeClass("psource-is_open"), o && a.toggleClass("psource-is_open")
                }
            }), e(".psource-result--menu").ready(function() {
                e(this).find(".psource-button-action").on("click", function() {
                    var t = e(this).next(".psource-menu");
                    e(".psource-result--menu.psource-active").removeClass("psource-active"), e(".psource-button-action.psource-active").not(e(this)).removeClass("psource-active"), e(".psource-menu").not(t).addClass("psource-hidden"), e(this).toggleClass("psource-active"), t.toggleClass("psource-hidden")
                })
            }), e(document).ready(function() {
                var t = e(".psource-list"),
                    i = t.find(".psource-list-table"),
                    n = i.find(".psource-table-body tr"),
                    a = n.length,
                    o = a;
                n.each(function() { e(this).find(".psource-body-menu").css("z-index", o), o-- })
            }), e(document).ready(function() {
                e("body").on("change", ".sui-insert-variables select", function(t) {
                    var i = e(t.target),
                        n = i.data("textarea-id");
                    if (n) {
                        if (t.preventDefault(), e("#" + n).length > 0) {
                            var a = e("input#" + n + ",textarea#" + n),
                                o = a.val();
                            a.val(o + " " + i.val()), a.trigger("change", a.val())
                        }
                        return !1
                    }
                }), e(".copy-clipboard").on("click", function(t) { t.preventDefault(), copyToClipboard(e(this).data("shortcode")), Powerform.Notification.open("success", Powerform.l10n.options.shortcode_copied, 4e3) }), e("body").on("click", ".delete-poll-submission", function(t) {
                    var i = e(t.target),
                        n = { action: "powerform_delete_poll_submissions", id: i.data("id"), _ajax_nonce: i.data("nonce") };
                    i.addClass("sui-button-onload"), e.post({ url: Powerform.Data.ajaxUrl, type: "post", data: n }).done(function(e) { e.success && jQuery(".sui-poll-submission").addClass("sui-message").html("").html(e.data.html), Powerform.Popup.close(), _.isUndefined(e.data.notification) || _.isUndefined(e.data.notification.type) || _.isUndefined(e.data.notification.text) || _.isUndefined(e.data.notification.duration) || Powerform.Notification.open(e.data.notification.type, e.data.notification.text, e.data.notification.duration).done(function() {}) })
                })
            })
        }), e(window).on("load", function() { "undefined" == typeof Powerform || "powerform-entries" !== Powerform.Utils.get_url_param("page") || Powerform.Utils.get_url_param("form_type") || Powerform.Utils.get_url_param("form_id") || e(".show-submissions").trigger("click") }), e(window).on("pageshow", function(e) {
            (e.persisted || void 0 !== window.performance && "back_forward" === window.performance.getEntriesByType("navigation")[0].type) && window.location.reload()
        })
    }()
}(jQuery, document);
var powerform_render_captcha = function() {
    jQuery(".powerform-g-recaptcha").each(function() {
        var e = jQuery(this).data("size"),
            t = { sitekey: jQuery(this).data("sitekey"), theme: jQuery(this).data("theme"), size: e };
        if ("" !== t.sitekey) { window.grecaptcha.render(jQuery(this)[0], t) }
    })
};