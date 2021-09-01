// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
; // noinspection JSUnusedLocalSymbols
(function($, window, document, undefined) {

    "use strict";

    // undefined is used here as the undefined global variable in ECMAScript 3 is
    // mutable (ie. it can be changed by someone else). undefined isn't really being
    // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
    // can no longer be modified.

    // window and document are passed through as local variables rather than global
    // as this (slightly) quickens the resolution process and can be more efficiently
    // minified (especially when both are regularly referenced in your plugin).

    // Create the defaults once
    var pluginName = "powerformFrontPagination",
        defaults = {
            totalSteps: 0,
            step: 0,
            hashStep: 0,
            inline_validation: false
        };

    // The actual plugin constructor
    function PowerformFrontPagination(element, options) {
        this.element = $(element);
        this.$el = this.element;
        this.totalSteps = 0;
        this.step = 0;
        this.hashStep = false;
        this.next_button = window.PowerformFront.cform.pagination_next;
        this.prev_button = window.PowerformFront.cform.pagination_prev;
        this.next_button_txt = '';
        this.prev_button_txt = '';
        this.custom_label = [];
        this.form_id = 0;
        this.element = '';

        // jQuery has an extend method which merges the contents of two or
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    // Avoid Plugin.prototype conflicts
    $.extend(PowerformFrontPagination.prototype, {
        init: function() {

            if (this.$el.find('input[name=form_id]').length > 0) {
                this.form_id = this.$el.find('input[name=form_id]').val();
            }

            this.totalSteps = this.settings.totalSteps;
            this.step = this.settings.step;
            this.element = this.$el.find('[data-step=' + this.step + ']').data('name');
            if (this.form_id && typeof window.Powerform_Cform_Paginations === 'object' && typeof window.Powerform_Cform_Paginations[this.form_id] === 'object') {
                this.custom_label = window.Powerform_Cform_Paginations[this.form_id];
            }
            if (this.settings.hashStep && this.step > 0) {
                this.go_to(this.step, true);
            } else {
                this.go_to(0, false);
            }

            this.render_navigation();
            this.render_bar_navigation();
            this.render_footer_navigation(this.form_id);
            this.init_events();
            this.update_buttons();
            this.update_navigation();

        },
        init_events: function() {
            var self = this;

            this.$el.find('.powerform-button-back').click(function(e) {
                e.preventDefault();
                self.handle_click('prev');
            });
            this.$el.find('.powerform-button-next').click(function(e) {
                e.preventDefault();
                self.handle_click('next');
            });

            this.$el.find('.powerform-step').click(function(e) {
                e.preventDefault();
                var step = $(this).data('nav');
                self.handle_step(step);
            });

            this.$el.on('reset', function(e) {
                self.on_form_reset(e);
            });

            this.$el.on('powerform.front.pagination.focus.input', function(e, input) {
                self.on_focus_input(e, input);
            });

        },

        /**
         * On reset event of Form
         *
         * @since 1.0.3
         *
         * @param e
         */
        on_form_reset: function(e) {
            // Trigger pagination to first page
            this.go_to(0, true);
            this.update_buttons();
        },

        /**
         * On Input focused
         *
         * @param e
         * @param input
         */
        on_focus_input: function(e, input) {
            //Go to page where element exist
            var step = this.get_page_of_input(input);
            this.go_to(step, true);
            this.update_buttons();
        },
        render_footer_navigation: function(form_id) {
            var footer_html = '',
                paypal_field = '';
            if (this.custom_label[this.element] && this.custom_label['pagination-labels'] === 'custom') {
                this.prev_button_txt = this.custom_label[this.element]['prev-text'] !== '' ? this.custom_label[this.element]['prev-text'] : this.prev_button;
                this.next_button_txt = this.custom_label[this.element]['next-text'] !== '' ? this.custom_label[this.element]['next-text'] : this.next_button;
            } else {
                this.prev_button_txt = this.prev_button;
                this.next_button_txt = this.next_button;
            }

            if (this.$el.hasClass('powerform-design--material')) {
                footer_html = '<div class="powerform-pagination-footer">' +
                    '<button class="powerform-button powerform-button-back"><span class="powerform-button--mask" aria-label="hidden"></span><span class="powerform-button--text">' + this.prev_button_txt + '</span></button>' +
                    '<button class="powerform-button powerform-button-next"><span class="powerform-button--mask" aria-label="hidden"></span><span class="powerform-button--text">' + this.next_button_txt + '</span></button>';
                if (this.custom_label['has-paypal'] === true) {
                    paypal_field = (this.custom_label['paypal-id']) ? this.custom_label['paypal-id'] : '';
                    footer_html += '<div class="powerform-payment powerform-button-paypal powerform-hidden ' + paypal_field + '-payment" id="paypal-button-container-' + form_id + '">';
                }
                footer_html += '</div>';
                this.$el.append(footer_html);

            } else {
                footer_html = '<div class="powerform-pagination-footer">' +
                    '<button class="powerform-button powerform-button-back">' + this.prev_button_txt + '</button>' +
                    '<button class="powerform-button powerform-button-next">' + this.next_button_txt + '</button>';
                if (this.custom_label['has-paypal'] === true) {
                    paypal_field = (this.custom_label['paypal-id']) ? this.custom_label['paypal-id'] : '';
                    footer_html += '<div class="powerform-payment powerform-button-paypal powerform-hidden ' + paypal_field + '-payment" id="paypal-button-container-' + form_id + '">';
                }
                footer_html += '</div>';
                this.$el.append(footer_html);

            }

        },

        render_bar_navigation: function() {

            var $navigation = this.$el.find('.powerform-pagination-progress');

            var $progressLabel = '<div class="powerform-progress-label">0%</div>',
                $progressBar = '<div class="powerform-progress-bar"><span style="width: 0%"></span></div>';

            if (!$navigation.length) return;

            $navigation.html($progressLabel + $progressBar);

            this.calculate_bar_percentage();

        },

        calculate_bar_percentage: function() {

            var total = this.totalSteps,
                current = this.step + 1,
                $progress = this.$el;

            if (!$progress.length) return;

            var percentage = Math.round((current / total) * 100);

            $progress.find('.powerform-progress-label').html(percentage + '%');
            $progress.find('.powerform-progress-bar span').css('width', percentage + '%');

        },

        render_navigation: function() {
            var $navigation = this.$el.find('.powerform-pagination-steps');

            var finalSteps = this.$el.find('.powerform-pagination-start');

            if (!$navigation.length) return;

            var steps = this.$el.find('.powerform-pagination').not('.powerform-pagination-start');

            $navigation.append('<div class="powerform-break"></div>');

            var self = this;

            steps.each(function() {

                var $step = $(this),
                    $stepLabel = $step.data('label'),
                    $stepNumb = $step.data('step') - 1,
                    $stepControl = 'powerform-custom-form-' + self.form_id + '--page-' + $stepNumb,
                    $stepId = $stepControl + '-label';

                var $stepMarkup = '<button role="tab" id="' + $stepId + '" class="powerform-step powerform-step-' + $stepNumb + '" aria-selected="false" aria-controls="' + $stepControl + '" data-nav="' + $stepNumb + '">' +
                    '<span class="powerform-step-label">' + $stepLabel + '</span>' +
                    '<span class="powerform-step-dot" aria-hidden="true"></span>' +
                    '</button>';

                var $stepBreak = '<div class="powerform-break" aria-hidden="true"></div>';

                $navigation.append($stepMarkup + $stepBreak);

            });

            finalSteps.each(function() {
                var $step = $(this),
                    label = $step.data('label'),
                    numb = steps.length,
                    control = 'powerform-custom-form-' + self.form_id + '--page-' + numb,
                    stepid = control + '-label';

                var $stepMarkup = '<button role="tab" id="' + stepid + '" class="powerform-step powerform-step-' + numb + '" data-nav="' + numb + '" aria-selected="false" aria-controls="' + control + '">' +
                    '<span class="powerform-step-label">' + label + '</span>' +
                    '<span class="powerform-step-dot" aria-hidden="true"></span>' +
                    '</button>';

                var $stepBreak = '<div class="powerform-break" aria-hidden="true"></div>';

                $navigation.append($stepMarkup + $stepBreak);
            });
        },

        /**
         * Handle step click
         *
         * @param step
         */
        handle_step: function(step) {
            if (this.settings.inline_validation) {
                for (var i = 0; i < step; i++) {
                    if (this.step <= i) {
                        if (!this.is_step_inputs_valid(i)) {
                            this.go_to(i, true);
                            return;
                        }
                    }
                }
            }
            this.go_to(step, true);
            this.update_buttons();
        },

        handle_click: function(type) {
            var self = this;
            if (type === "prev" && this.step !== 0) {
                this.go_to(this.step - 1, true);
                this.update_buttons();
            } else if (type === "next") {
                //do validation before next if inline validation enabled
                if (this.settings.inline_validation) {
                    if (!this.is_step_inputs_valid(this.step)) {
                        return;
                    }
                }

                if (typeof this.$el.data().powerformFrontPayment !== "undefined") {
                    var payment = this.$el.data().powerformFrontPayment,
                        page = this.$el.find('[data-step=' + this.step + ']'),
                        hasStripe = page.find(".powerform-stripe-element").not(".powerform-hidden .powerform-stripe-element");

                    // Check if Stripe exists on current step
                    if (hasStripe.length > 0) {
                        payment._stripe.createToken(payment._cardElement).then(function(result) {
                            if (result.error) {
                                payment.showCardError(result.error.message, true);
                            } else {
                                payment.hideCardError();
                                self.go_to(self.step + 1, true);
                                self.update_buttons();
                            }
                        });
                    } else {
                        this.go_to(this.step + 1, true);
                        this.update_buttons();
                    }
                } else {
                    this.go_to(this.step + 1, true);
                    this.update_buttons();
                }
            }
        },

        /**
         * Check current inputs on step is in valid state
         */
        is_step_inputs_valid: function(step) {
            var valid = true,
                errors = 0,
                validator = this.$el.data('validator'),
                page = this.$el.find('[data-step=' + step + ']');

            //inline validation disabled
            if (typeof validator === 'undefined') {
                return true;
            }

            //get fields on current page
            page.find("input, select, textarea")
                .not(":submit, :reset, :image, :disabled")
                .not(':hidden:not(.powerform-wp-editor-required, .powerform-input-file-required, input[name$="_data"])')
                .not('[gramm="true"]')
                .each(function(key, element) {
                    valid = validator.element(element);

                    if (!valid) {
                        if (errors === 0) {
                            // focus on first error
                            element.focus();
                        }
                        errors++;
                    }
                });

            return errors === 0;
        },

        /**
         * Get page on the input
         *
         * @since 1.0.3
         *
         * @param input
         * @returns {number|*}
         */
        get_page_of_input: function(input) {
            var step_page = this.step;
            var page = $(input).closest('.powerform-pagination');
            if (page.length > 0) {
                var step = $(page).data('step');
                if (typeof step !== 'undefined') {
                    step_page = +step;
                }
            }

            return step_page;
        },

        update_buttons: function() {
            if (this.step === 0) {
                this.$el.find('.powerform-button-back').closest('.powerform-pagination-footer').css({
                    'justify-content': 'flex-end'
                });
                this.$el.find('.powerform-button-back').addClass('powerform-hidden');
            } else {
                this.$el.find('.powerform-button-back').closest('.powerform-pagination-footer').css({
                    'justify-content': ''
                });
                this.$el.find('.powerform-button-back').removeClass('powerform-hidden');
            }

            if (this.step === this.totalSteps) {
                //keep pagination content on last step before submit
                this.step--;
                this.$el.submit();
            }

            if (this.step === (this.totalSteps - 1)) {

                var submit_button_text = this.$el.find('.powerform-pagination-submit').html(),
                    last_button_txt = (this.custom_label['pagination-labels'] === 'custom' &&
                        this.custom_label['last-previous'] !== '') ? this.custom_label['last-previous'] : this.prev_button;

                if (this.$el.hasClass('powerform-design--material')) {

                    this.$el.find('.powerform-button-back .powerform-button--text').html(last_button_txt);
                    this.$el.find('.powerform-button-next')
                        .removeClass('powerform-button-next')
                        .attr('id', 'powerform-submit')
                        .addClass('powerform-button-submit')
                        .find('.powerform-button--text')
                        .html('')
                        .html(submit_button_text);
                    if (this.custom_label['has-paypal'] === true) {
                        this.$el.find('.powerform-button-submit').addClass('powerform-hidden');
                        this.$el.find('.powerform-payment')
                            .attr('id', 'powerform-paypal-submit')
                            .removeClass('powerform-hidden');
                    }
                } else {
                    this.$el.find('.powerform-button-back').html(last_button_txt);
                    this.$el.find('.powerform-button-next')
                        .removeClass('powerform-button-next')
                        .attr('id', 'powerform-submit')
                        .addClass('powerform-button-submit')
                        .html(submit_button_text);
                    if (this.custom_label['has-paypal'] === true) {
                        this.$el.find('.powerform-button-submit').addClass('powerform-hidden');
                        this.$el.find('.powerform-payment')
                            .attr('id', 'powerform-paypal-submit')
                            .removeClass('powerform-hidden');
                    }
                }

                if (this.$el.find('.powerform-payment iframe').length > 0) {
                    this.$el.find('.powerform-payment iframe').width('100%');
                }

            } else {
                this.element = this.$el.find('[data-step=' + this.step + ']').data('name');
                if (this.custom_label[this.element] && this.custom_label['pagination-labels'] === 'custom') {
                    this.prev_button_txt = this.custom_label[this.element]['prev-text'] !== '' ? this.custom_label[this.element]['prev-text'] : this.prev_button;
                    this.next_button_txt = this.custom_label[this.element]['next-text'] !== '' ? this.custom_label[this.element]['next-text'] : this.next_button;
                } else {
                    this.prev_button_txt = this.prev_button;
                    this.next_button_txt = this.next_button;
                }
                if (this.$el.hasClass('powerform-design--material')) {
                    this.$el.find('#powerform-submit')
                        .removeAttr('id')
                        .removeClass('powerform-button-submit')
                        .addClass('powerform-button-next');
                    if (this.custom_label['has-paypal'] === true) {
                        this.$el.find('#powerform-paypal-submit').removeAttr('id').addClass('powerform-hidden');
                        this.$el.find('.powerform-button-next').removeClass('powerform-button-submit powerform-hidden');
                    }

                    this.$el.find('.powerform-button-back .powerform-button--text').html(this.prev_button_txt);
                    this.$el.find('.powerform-button-next .powerform-button--text').html(this.next_button_txt);

                } else {
                    this.$el.find('#powerform-submit')
                        .removeAttr('id')
                        .removeClass('powerform-button-submit')
                        .addClass('powerform-button-next');
                    if (this.custom_label['has-paypal'] === true) {
                        this.$el.find('#powerform-paypal-submit').removeAttr('id').addClass('powerform-hidden');
                        this.$el.find('.powerform-button-next').removeClass('powerform-button-submit powerform-hidden');
                    }
                    this.$el.find('.powerform-button-back').html(this.prev_button_txt);
                    this.$el.find('.powerform-button-next').html(this.next_button_txt);

                }
            }
        },

        go_to: function(step, scrollToTop) {
            this.step = step;

            if (step === this.totalSteps) return false;

            // Hide all parts
            this.$el.find('.powerform-pagination').css({
                'height': '0',
                'opacity': '0',
                'visibility': 'hidden',
                'overflow': 'hidden'
            }).attr('aria-hidden', 'true').attr('hidden', true);

            this.$el.find('.powerform-pagination .powerform-pagination--content').hide();

            // Show desired page
            this.$el.find('[data-step=' + step + ']').css({
                'height': 'auto',
                'opacity': '1',
                'visibility': 'visible'
            }).removeAttr('aria-hidden').removeAttr('hidden');

            this.$el.find('[data-step=' + step + '] .powerform-pagination--content').show();

            //exec responsive captcha
            var powerformFront = this.$el.data('powerformFront');
            if (typeof powerformFront !== 'undefined') {
                powerformFront.responsive_captcha();
            }

            this.update_navigation();

            if (scrollToTop) {
                this.scroll_to_top_form();
            }
        },

        update_navigation: function() {

            // Update navigation
            this.$el.find('.powerform-current').attr('aria-selected', 'false');
            this.$el.find('.powerform-current').removeClass('powerform-current');
            this.$el.find('.powerform-step-' + this.step).attr('aria-selected', 'true');
            this.$el.find('.powerform-step-' + this.step).addClass('powerform-current');

            this.calculate_bar_percentage();
        },

        /**
         * Reset vertical screen position between sections
         * https://app.asana.com/0/385581670491499/784073712068017/f
         * Support Hustle Modal
         */
        scroll_to_top_form: function() {
            var $element = this.$el;
            // find first input row
            var first_input_row = this.$el.find('.powerform-row').not(':hidden').first();
            if (first_input_row.length) {
                $element = first_input_row;
            }

            if ($element.length) {
                var parent_selector = 'html,body';

                // check inside sui modal
                if (this.$el.closest('.sui-dialog').length > 0) {
                    parent_selector = '.sui-dialog';
                }

                // check inside hustle modal (prioritize)
                if (this.$el.closest('.wph-modal').length > 0) {
                    parent_selector = '.wph-modal';
                }

                $(parent_selector).animate({ scrollTop: ($element.offset().top - ($(window).height() - $element.outerHeight(true)) / 2) }, 500, function() {
                    if (!$element.attr("tabindex")) {
                        $element.attr("tabindex", -1);
                    }
                    $element.focus();
                });
            }

        }
    });

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function(options) {
        return this.each(function() {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new PowerformFrontPagination(this, options));
            }
        });
    };

})(jQuery, window, document);