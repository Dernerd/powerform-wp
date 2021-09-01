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
    var pluginName = "powerformFront",
        defaults = {
            form_type: 'custom-form',
            rules: {},
            messages: {},
            conditions: {},
            inline_validation: false,
            chart_design: 'bar',
            chart_options: {},
            powerform_fields: [],
            max_nested_formula: 5,
            general_messages: {
                calculation_error: 'Failed to calculate field.',
                payment_require_ssl_error: 'SSL required to submit this form, please check your URL.',
                payment_require_amount_error: 'PayPal amount must be greater than 0.'
            },
            payment_require_ssl: false,
        };

    // The actual plugin constructor
    function PowerformFront(element, options) {
        this.element = element;
        this.$el = $(this.element);
        this.powerform_selector = '#' + $(this.element).attr('id') + '[data-powerform-render="' + $(this.element).data('powerform-render') + '"]';
        this.powerform_loader_selector = 'div[data-powerform-render="' + $(this.element).data('powerform-render') + '"]' + '[data-form="' + $(this.element).attr('id') + '"]';

        // jQuery has an extend method which merges the contents of two or
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
        this.settings = $.extend({}, defaults, options);

        // special treatment for rules, messages, and conditions
        if (typeof this.settings.messages !== 'undefined') {
            this.settings.messages = this.maybeParseStringToJson(this.settings.messages, 'object');
        }
        if (typeof this.settings.rules !== 'undefined') {
            this.settings.rules = this.maybeParseStringToJson(this.settings.rules, 'object');
        }
        if (typeof this.settings.calendar !== 'undefined') {
            this.settings.calendar = this.maybeParseStringToJson(this.settings.calendar, 'array');
        }

        this._defaults = defaults;
        this._name = pluginName;
        this.form_id = 0;
        this.template_type = '';

        this.init();
    }

    // Avoid Plugin.prototype conflicts
    $.extend(PowerformFront.prototype, {
        init: function() {
            var self = this;

            if (this.$el.find('input[name=form_id]').length > 0) {
                this.form_id = this.$el.find('input[name=form_id]').val();
            }
            if (this.$el.find('input[name=form_type]').length > 0) {
                this.template_type = this.$el.find('input[name=form_type]').val();
            }

            $(this.powerform_loader_selector).remove();

            // If form from hustle popup, do not show
            if (this.$el.closest('.wph-modal').length === 0) {
                this.$el.show();
            }

            // Show form when popup trigger with click
            $(document).on("hustle:module:displayed", function(e, data) {
                var $modal = $('.wph-modal-active');
                $modal.find('form').css('display', '');
            });

            // Show form when popup trigger
            setTimeout(function() {
                var $modal = $('.wph-modal-active');
                $modal.find('form').css('display', '');
            }, 10);

            //selective activation based on type of form
            switch (this.settings.form_type) {
                case 'custom-form':
                    this.init_custom_form();
                    break;
                case 'poll':
                    this.init_poll_form();
                    break;
                case 'quiz':
                    this.init_quiz_form();
                    break;

            }

            //init submit
            var submitOptions = {
                form_type: self.settings.form_type,
                powerform_selector: self.powerform_selector,
                chart_design: self.settings.chart_design,
                chart_options: self.settings.chart_options,
                fadeout: self.settings.fadeout,
                fadeout_time: self.settings.fadeout_time,
                has_quiz_loader: self.settings.has_quiz_loader,
                has_loader: self.settings.has_loader,
                loader_label: self.settings.loader_label,
                resetEnabled: self.settings.is_reset_enabled,
                inline_validation: self.settings.inline_validation,
            };

            if ('leads' === this.template_type || 'quiz' === this.settings.form_type) {
                submitOptions.form_placement = self.settings.form_placement;
                submitOptions.hasLeads = self.settings.hasLeads;
                submitOptions.leads_id = self.settings.leads_id;
                submitOptions.quiz_id = self.settings.quiz_id;
                submitOptions.skip_form = self.settings.skip_form;
            }

            $(this.element).powerformFrontSubmit(submitOptions);


            // TODO: confirm usage on form type
            // Handle field activation classes
            this.activate_field();
            // Handle special classes for material design
            // this.material_field();

            // Init small form for all type of form
            this.small_form();

        },
        init_custom_form: function() {

            var self = this;

            //initiate validator

            this.init_intlTelInput_validation();

            if (this.settings.inline_validation) {

                $(this.element).powerformFrontValidate({
                    rules: self.settings.rules,
                    messages: self.settings.messages
                });
            }

            // initiate calculator
            $(this.element).powerformFrontCalculate({
                powerformFields: self.settings.powerform_fields,
                maxExpand: self.settings.max_nested_formula,
                generalMessages: self.settings.general_messages,
                memoizeTime: self.settings.calcs_memoize_time || 300,
            });

            // initiate merge tags
            $(this.element).powerformFrontMergeTags({
                powerformFields: self.settings.powerform_fields,
            });

            //initiate pagination
            this.init_pagination();

            // initiate payment if exist
            var first_payment = $(this.element).find('div[data-is-payment="true"], input[data-is-payment="true"]').first();

            if (first_payment.length) {
                var payment_type = first_payment.data('paymentType');
                if (payment_type === 'stripe') {
                    $(this.element).powerformFrontPayment({
                        type: payment_type,
                        paymentEl: first_payment,
                        paymentRequireSsl: self.settings.payment_require_ssl,
                        generalMessages: self.settings.general_messages,
                        fadeout_time: self.settings.fadeout_time,
                        has_loader: self.settings.has_loader,
                        loader_label: self.settings.loader_label,
                    });
                }
                if (payment_type === 'paypal') {
                    $(this.element).powerformFrontPayPal({
                        type: payment_type,
                        paymentEl: this.settings.paypal_config,
                        paymentRequireSsl: self.settings.payment_require_ssl,
                        generalMessages: self.settings.general_messages,
                        has_loader: self.settings.has_loader,
                        loader_label: self.settings.loader_label,
                    });
                }
            }

            //initiate condition
            $(this.element).powerformFrontCondition(this.settings.conditions, this.settings.calendar);

            //initiate powerform ui scripts
            this.init_fui();

            //initiate datepicker
            $(this.element).find('.powerform-datepicker').powerformFrontDatePicker(this.settings.calendar);

            // Handle responsive captcha
            this.responsive_captcha();

            // Handle field counter
            this.field_counter();

            // Handle number input
            this.field_number();

            // Handle time fields
            this.field_time();

            // Handle upload field change
            $(this.element).find('.powerform-multi-upload').powerformFrontMultiFile(this.$el);

            this.upload_field();

            // Handle function on resize
            $(window).on('resize', function() {
                self.responsive_captcha();
            });

            if ('undefined' !== typeof self.settings.hasLeads) {
                if ('beginning' === self.settings.form_placement) {
                    $('#powerform-module-' + this.settings.quiz_id).css({
                        'height': 0,
                        'opacity': 0,
                        'overflow': 'hidden',
                        'visibility': 'hidden',
                        'pointer-events': 'none',
                        'margin': 0,
                        'padding': 0,
                        'border': 0
                    });
                }
                if ('end' === self.settings.form_placement) {
                    $(this.element).css({
                        'height': 0,
                        'opacity': 0,
                        'overflow': 'hidden',
                        'visibility': 'hidden',
                        'pointer-events': 'none',
                        'margin': 0,
                        'padding': 0,
                        'border': 0
                    });
                }
            }

        },
        init_poll_form: function() {

            var self = this,
                $fieldset = this.$el.find('fieldset'),
                $selection = this.$el.find('.powerform-radio input'),
                $input = this.$el.find('.powerform-input'),
                $field = $input.closest('.powerform-field');

            // Load input states
            FUI.inputStates($input);

            // Show input when option has been selected
            $selection.on('click', function() {

                // Reset
                $field.addClass('powerform-hidden');
                $field.attr('aria-hidden', 'true');
                $input.removeAttr('tabindex');
                $input.attr('name', '');

                var checked = this.checked,
                    $id = $(this).attr('id'),
                    $name = $(this).attr('name');

                // Once an option has been chosen, remove error class.
                $fieldset.removeClass('powerform-has_error');

                if (self.$el.find('.powerform-input#' + $id + '-extra').length) {

                    var $extra = self.$el.find('.powerform-input#' + $id + '-extra'),
                        $extraField = $extra.closest('.powerform-field');

                    if (checked) {

                        $extra.attr('name', $name + '-extra');

                        $extraField.removeClass('powerform-hidden');
                        $extraField.removeAttr('aria-hidden');

                        $extra.attr('tabindex', '-1');
                        $extra.focus();

                    } else {

                        $extraField.addClass('powerform-hidden');
                        $extraField.attr('aria-hidden', 'true');

                        $extra.removeAttr('tabindex');

                    }
                }

                return true;

            });

            // Disable options
            if (this.$el.hasClass('powerform-poll-disabled')) {

                this.$el.find('.powerform-radio').each(function() {

                    $(this).addClass('powerform-disabled');
                    $(this).find('input').attr('disabled', true);

                });
            }
        },

        init_quiz_form: function() {
            var self = this,
                lead_placement = 'undefined' !== typeof self.settings.form_placement ? self.settings.form_placement : '',
                quiz_id = 'undefined' !== typeof self.settings.quiz_id ? self.settings.quiz_id : 0;

            this.$el.find('.powerform-button').each(function() {
                $(this).prop("disabled", true);
            });

            this.$el.find('.powerform-answer input').each(function() {
                $(this).attr('checked', false);
            });

            this.$el.find('.powerform-result--info button').on('click', function() {
                location.reload();
            });

            if ('end' !== lead_placement) {
                this.$el.find('.powerform-submit-rightaway').click(function() {
                    self.$el.submit();
                    $(this).closest('.powerform-question').find('.powerform-submit-rightaway').addClass('powerform-has-been-disabled').attr('disabled', 'disabled');
                });
            }

            if (self.settings.hasLeads) {
                if ('beginning' === lead_placement) {
                    self.$el.css({
                        'height': 0,
                        'opacity': 0,
                        'overflow': 'hidden',
                        'visibility': 'hidden',
                        'pointer-events': 'none',
                        'margin': 0,
                        'padding': 0,
                        'border': 0
                    });
                }
                if ('end' === lead_placement) {
                    self.$el.closest('div').find('#powerform-module-' + self.settings.leads_id).css({
                        'height': 0,
                        'opacity': 0,
                        'overflow': 'hidden',
                        'visibility': 'hidden',
                        'pointer-events': 'none',
                        'margin': 0,
                        'padding': 0,
                        'border': 0
                    });
                    $('#powerform-quiz-leads-' + quiz_id + ' .powerform-lead-form-skip').hide();
                }
            }

            this.$el.on('click', '.powerform-social--icon a', function(e) {
                e.preventDefault();
                var social = $(this).data('social'),
                    url = $(this).closest('.powerform-social--icons').data('url'),
                    message = $(this).closest('.powerform-social--icons').data('message'),
                    message = encodeURIComponent(message),
                    social_shares = {
                        'facebook': 'https://www.facebook.com/sharer/sharer.php?u=' + url + '&t=' + message,
                        'twitter': 'https://twitter.com/intent/tweet?&url=' + url + '&text=' + message,
                        'google': 'https://plus.google.com/share?url=' + url,
                        'linkedin': 'https://www.linkedin.com/shareArticle?mini=true&url=' + url + '&title=' + message
                    };

                if (social_shares[social] !== undefined) {
                    var newwindow = window.open(social_shares[social], social, 'height=' + $(window).height() + ',width=' + $(window).width());
                    if (window.focus) {
                        newwindow.focus();
                    }
                    return false;
                }
            });

            this.$el.on('change', '.powerform-answer input', function(e) {
                var count = 0,
                    amount_answers = self.$el.find('.powerform-question').length;

                self.$el.find('.powerform-answer input').each(function() {
                    if ($(this).prop('checked')) {
                        count++;
                    }

                    if (count === amount_answers) {
                        self.$el.find('.powerform-button').each(function() {
                            $(this).prop("disabled", false);
                        });
                    }
                });

            });

        },

        small_form: function() {

            var form = $(this.element),
                formWidth = form.width();

            if (783 < Math.max(document.documentElement.clientWidth, window.innerWidth || 0)) {

                if (form.hasClass('powerform-size--small')) {

                    if (480 < formWidth) {
                        form.removeClass('powerform-size--small');
                    }
                } else {
                    var hasHustle = form.closest('.hustle-content');

                    if (480 >= formWidth && !hasHustle.length) {
                        form.addClass('powerform-size--small');
                    }
                }
            }
        },

        init_intlTelInput_validation: function() {

            var form = $(this.element),
                is_material = form.is('.powerform-design--material'),
                fields = form.find('.powerform-field--phone');

            fields.each(function() {

                // Initialize intlTelInput plugin on each field with "format check" enabled and
                // set to check either "international" or "standard" phones.
                var is_national_phone = $(this).data('national_mode'),
                    country = $(this).data('country'),
                    validation = $(this).data('validation');

                if ('undefined' !== typeof(is_national_phone)) {

                    if (is_material) {
                        //$(this).unwrap('.powerform-input--wrap');
                    }

                    var args = {
                        nationalMode: ('enabled' === is_national_phone) ? true : false,
                        initialCountry: 'undefined' !== typeof(country) ? country : 'us',
                        utilsScript: window.PowerformFront.cform.intlTelInput_utils_script,
                    };

                    if ('undefined' !== typeof(validation) && 'standard' === validation) {
                        args.allowDropdown = false;
                    }

                    $(this).intlTelInput(args);

                    if (!is_material) {
                        $(this).closest('.powerform-field').find('div.intl-tel-input').addClass('powerform-phone');
                    } else {
                        $(this).closest('.powerform-field').find('div.intl-tel-input').addClass('powerform-input-with-phone');
                    }

                    // intlTelInput plugin adds a markup that's not compatible with 'material' theme when 'allowDropdown' is true (default).
                    // If we're going to allow users to disable the dropdown, this should be adjusted accordingly.
                    if (is_material) {
                        //$(this).closest('.intl-tel-input.allow-dropdown').addClass('powerform-phone-intl').removeClass('intl-tel-input');
                        //$(this).wrap('<div class="powerform-input--wrap"></div>');
                    }
                }
            });

        },

        init_fui: function() {

            var form = $(this.element),
                input = form.find('.powerform-input'),
                textarea = form.find('.powerform-textarea'),
                select = form.find('.powerform-select'),
                select2 = form.find('.powerform-select2'),
                multiselect = form.find('.powerform-multiselect'),
                stripe = form.find('.powerform-stripe-element');

            var isDefault = (form.attr('data-design') === 'default'),
                isBold = (form.attr('data-design') === 'bold'),
                isFlat = (form.attr('data-design') === 'flat'),
                isMaterial = (form.attr('data-design') === 'material');

            if (input.length) {
                input.each(function() {
                    FUI.inputStates(this);
                });
            }

            if (textarea.length) {
                textarea.each(function() {
                    FUI.textareaStates(this);
                });
            }

            if (select2.length) {
                FUI.select2();
            }

            if ((isDefault || isBold || isFlat || isMaterial) && select.length) {

                select.each(function() {
                    FUI.select(this);
                });
            }

            if (multiselect.length) {
                FUI.multiSelectStates(multiselect);
            }

            if (form.hasClass('powerform-design--material')) {
                if (input.length) {
                    input.each(function() {
                        FUI.inputMaterial(this);
                    });
                }

                if (textarea.length) {
                    textarea.each(function() {
                        FUI.textareaMaterial(this);
                    });
                }

                if (stripe.length) {
                    stripe.each(function() {
                        var field = $(this).closest('.powerform-field');
                        var label = field.find('.powerform-label');

                        if (label.length) {
                            field.addClass('powerform-stripe-floating');
                            // Add floating class
                            label.addClass('powerform-floating--input');
                        }
                    });
                }
            }
        },

        responsive_captcha: function() {
            $(this.element).find('.powerform-g-recaptcha').each(function() {
                if ($(this).is(':visible')) {
                    var width = $(this).parent().width(),
                        scale = 1;
                    if (width < 302) {
                        scale = width / 302;
                    }
                    $(this).css('transform', 'scale(' + scale + ')');
                    $(this).css('-webkit-transform', 'scale(' + scale + ')');
                    $(this).css('transform-origin', '0 0');
                    $(this).css('-webkit-transform-origin', '0 0');
                }
            });
        },

        init_pagination: function() {
            var self = this,
                num_pages = $(this.element).find(".powerform-pagination").length,
                hash = window.location.hash,
                hashStep = false,
                step = 0;

            if (num_pages > 0) {
                //find from hash
                if (typeof hash !== "undefined" && hash.indexOf('step-') >= 0) {
                    hashStep = true;
                    step = hash.substr(6, 8);
                }

                $(this.element).powerformFrontPagination({
                    totalSteps: num_pages,
                    hashStep: hashStep,
                    step: step,
                    inline_validation: self.settings.inline_validation
                });
            }
        },

        activate_field: function() {

            var form = $(this.element);
            var input = form.find('.powerform-input');
            var textarea = form.find('.powerform-textarea');

            function classFilled(el) {

                var element = $(el);
                var elementValue = element.val().trim();
                var elementField = element.closest('.powerform-field');
                var elementAnswer = element.closest('.powerform-poll--answer');

                var filledClass = 'powerform-is_filled';

                if ('' !== elementValue) {
                    elementField.addClass(filledClass);
                    elementAnswer.addClass(filledClass);
                } else {
                    elementField.removeClass(filledClass);
                    elementAnswer.removeClass(filledClass);
                }

                element.change(function(e) {

                    if ('' !== elementValue) {
                        elementField.addClass(filledClass);
                        elementAnswer.addClass(filledClass);
                    } else {
                        elementField.removeClass(filledClass);
                        elementAnswer.removeClass(filledClass);
                    }

                    e.stopPropagation();

                });
            };

            function classHover(el) {

                var element = $(el);
                var elementField = element.closest('.powerform-field');
                var elementAnswer = element.closest('.powerform-poll--answer');

                var hoverClass = 'powerform-is_hover';

                element.mouseover(function(e) {
                    elementField.addClass(hoverClass);
                    elementAnswer.addClass(hoverClass);
                    e.stopPropagation();
                }).mouseout(function(e) {
                    elementField.removeClass(hoverClass);
                    elementAnswer.removeClass(hoverClass);
                    e.stopPropagation();
                });
            };

            function classActive(el) {

                var element = $(el);
                var elementField = element.closest('.powerform-field');
                var elementAnswer = element.closest('.powerform-poll--answer');

                var activeClass = 'powerform-is_active';

                element.focus(function(e) {
                    elementField.addClass(activeClass);
                    elementAnswer.addClass(activeClass);
                    e.stopPropagation();
                }).blur(function(e) {
                    elementField.removeClass(activeClass);
                    elementAnswer.removeClass(activeClass);
                    e.stopPropagation();
                });
            };

            function classError(el) {

                var element = $(el);
                var elementValue = element.val().trim();
                var elementField = element.closest('.powerform-field');
                var elementTime = element.attr('data-field');

                var timePicker = element.closest('.powerform-timepicker');
                var timeColumn = timePicker.parent();

                var errorField = elementField.find('.powerform-error-message');

                var errorClass = 'powerform-has_error';

                element.on('load change keyup keydown', function(e) {

                    if ('undefined' !== typeof elementTime && false !== elementTime) {

                        if ('hours' === element.data('field')) {

                            var hoursError = timeColumn.find('.powerform-error-message[data-error-field="hours"]');

                            if ('' !== elementValue && 0 !== hoursError.length) {
                                hoursError.remove();
                            }
                        }

                        if ('minutes' === element.data('field')) {

                            var minutesError = timeColumn.find('.powerform-error-message[data-error-field="minutes"]');

                            if ('' !== elementValue && 0 !== minutesError.length) {
                                minutesError.remove();
                            }
                        }
                    } else {

                        if ('' !== elementValue && errorField.text()) {
                            errorField.remove();
                            elementField.removeClass(errorClass);
                        }
                    }

                    e.stopPropagation();

                });
            };

            if (input.length) {

                input.each(function() {
                    //classFilled( this );
                    //classHover( this );
                    //classActive( this );
                    classError(this);
                });
            }

            if (textarea.length) {

                textarea.each(function() {
                    //classFilled( this );
                    //classHover( this );
                    //classActive( this );
                    classError(this);
                });
            }

            form.find('.powerform-select + .select2, .powerform-time + .select2').each(function() {

                var $select = $(this);

                // Set field active class on hover
                $select.mouseover(function(e) {
                    e.stopPropagation();
                    $(this).closest('.powerform-field').addClass('powerform-is_hover');

                }).mouseout(function(e) {
                    e.stopPropagation();
                    $(this).closest('.powerform-field').removeClass('powerform-is_hover');

                });

                // Set field active class on focus
                $select.on('click', function(e) {
                    e.stopPropagation();
                    checkSelectActive();
                    if ($select.hasClass('select2-container--open')) {
                        $(this).closest('.powerform-field').addClass('powerform-is_active');
                    } else {
                        $(this).closest('.powerform-field').removeClass('powerform-is_active');
                    }

                });


            });

            function checkSelectActive() {
                if (form.find('.select2-container').hasClass('select2-container--open')) {
                    setTimeout(checkSelectActive, 300);
                } else {
                    form.find('.select2-container').closest('.powerform-field').removeClass('powerform-is_active');
                }
            }
        },

        field_counter: function() {
            var form = $(this.element);
            form.find('.powerform-input, .powerform-textarea').each(function() {
                var $input = $(this),
                    numwords = 0,
                    count = 0;

                $input.on('change keyup keydown', function(e) {
                    e.stopPropagation();
                    var $field = $(this).closest('.powerform-col'),
                        $limit = $field.find('.powerform-description span');

                    if ($limit.length) {
                        if ($limit.data('limit')) {
                            if ($limit.data('type') !== "words") {
                                count = $(this).val().length;
                            } else {
                                count = $(this).val().trim().split(/\s+/).length;

                                // Prevent additional words from being added when limit is reached.
                                numwords = $(this).val().trim().split(/\s+/).length;
                                if (numwords >= $limit.data('limit')) {
                                    // Allow delete and backspace when limit is reached.
                                    if (e.which === 32) {
                                        e.preventDefault();
                                    }
                                }
                            }
                            $limit.html(count + ' / ' + $limit.data('limit'));
                        }
                    }
                });

            });
        },

        field_number: function() {
            // var form = $(this.element);
            // form.find('input[type=number]').on('change keyup', function () {
            // 	if( ! $(this).val().match(/^\d+$/) ){
            // 		var sanitized = $(this).val().replace(/[^0-9]/g, '');
            // 		$(this).val(sanitized);
            // 	}
            // });
            var form = $(this.element);
            form.find('input[type=number]').each(function() {
                $(this).keypress(function(e) {
                    var i;
                    var allowed = [44, 45, 46];
                    var key = e.which;

                    for (i = 48; i < 58; i++) {
                        allowed.push(i);
                    }

                    if (!(allowed.indexOf(key) >= 0)) {
                        e.preventDefault();
                    }
                });
            });

            form.find('.powerform-currency').each(function() {
                var decimals = $(this).data('decimals');
                $(this).change(function(e) {
                    this.value = parseFloat(this.value).toFixed(decimals);
                });
            });

            // form.find('.powerform-number--field').each(function () {
            // 	var separators = $(this).data('separators');
            // 	$(this).mask( separators, { reverse: false } );
            // });
            // form.find('.powerform-currency').each(function () {
            //     var separators = $(this).data('separators');
            //     $(this).mask( separators, { reverse: false } );
            // });
        },

        field_time: function() {
            $('.powerform-input-time').on('input', function(e) {
                var $this = $(this),
                    value = $this.val();

                // Allow only 2 digits for time fields
                if (value && value.length >= 2) {
                    $this.val(value.substr(0, 2));
                }
            });
        },

        material_field: function() {
            /*
            var form = $(this.element);
            if (form.is('.powerform-design--material')) {
            	var $input    = form.find('.powerform-input--wrap'),
            	    $textarea = form.find('.powerform-textarea--wrap'),
            	    $date     = form.find('.powerform-date'),
            	    $product  = form.find('.powerform-product');

            	var $navigation = form.find('.powerform-pagination--nav'),
            	    $navitem    = $navigation.find('li');

            	$('<span class="powerform-nav-border"></span>').insertAfter($navitem);

            	$input.prev('.powerform-field--label').addClass('powerform-floating--input');
            	$input.closest('.powerform-phone-intl').prev('.powerform-field--label').addClass('powerform-floating--input');
            	$textarea.prev('.powerform-field--label').addClass('powerform-floating--textarea');

            	if ($date.hasClass('powerform-has_icon')) {
            		$date.prev('.powerform-field--label').addClass('powerform-floating--date');
            	} else {
            		$date.prev('.powerform-field--label').addClass('powerform-floating--input');
            	}
            }
            */
        },

        toggle_file_input: function() {

            var $form = $(this.element);

            $form.find('.powerform-file-upload').each(function() {

                var $field = $(this);
                var $input = $field.find('input');
                var $remove = $field.find('.powerform-button-delete');

                // Toggle remove button depend on input value
                if ('' !== $input.val()) {
                    $remove.show(); // Show remove button
                } else {
                    $remove.hide(); // Hide remove button
                }
            });
        },

        upload_field: function() {

            var self = this,
                form = $(this.element);
            // Toggle file remove button
            this.toggle_file_input();

            // Handle remove file button click
            form.find('.powerform-button-delete').on('click', function(e) {

                e.preventDefault();

                var $self = $(this),
                    $input = $self.siblings('input'),
                    $label = $self.closest('.powerform-file-upload').find('> span');

                // Cleanup
                $input.val('');
                $label.html($label.data('empty-text'));
                $self.hide();

            });

            form.find('.powerform-input-file, .powerform-input-file-required').change(function() {
                var $nameLabel = $(this).closest('.powerform-file-upload').find('> span'),
                    vals = $(this).val(),
                    val = vals.length ? vals.split('\\').pop() : '';

                $nameLabel.text(val);

                self.toggle_file_input();
            });

            form.find('.powerform-button-upload').on('click', function(e) {
                e.preventDefault();;

                var $id = $(this).attr('data-id'),
                    $target = form.find('input#' + $id);

                $target.trigger('click');
            });

            form.find('.powerform-input-file, .powerform-input-file-required').on('change', function(e) {

                e.preventDefault();

                var $file = $(this)[0].files.length,
                    $remove = $(this).find('.powerform-button-delete');

                if ($file === 0) {
                    $remove.hide();
                } else {
                    $remove.show();
                }

            });
        },

        renderCaptcha: function(captcha_field) {
            var self = this;
            //render captcha only if not rendered
            if (typeof $(captcha_field).data('powerform-recapchta-widget') === 'undefined') {
                var size = $(captcha_field).data('size'),
                    data = {
                        sitekey: $(captcha_field).data('sitekey'),
                        theme: $(captcha_field).data('theme'),
                        size: size
                    };

                if (size === 'invisible') {
                    data.badge = 'inline';
                    data.callback = function(token) {
                        $(self.element).trigger('submit.frontSubmit');
                    };
                }

                if (data.sitekey !== "") {
                    // noinspection Annotator
                    var widget = window.grecaptcha.render(captcha_field, data);
                    // mark as rendered
                    $(captcha_field).data('powerform-recapchta-widget', widget);
                    this.responsive_captcha();
                }
            }
        },

        hide: function() {
            this.$el.hide();
        },
        /**
         * Return JSON object if possible
         *
         * We tried our best here
         * if there is an error/exception, it will return empty object/array
         *
         * @param string
         * @param type ('array'/'object')
         */
        maybeParseStringToJson: function(string, type) {
            var object = {};
            // already object
            if (typeof string === 'object') {
                return string;
            }

            if (type === 'object') {
                string = '{' + string.trim() + '}';
            } else if (type === 'array') {
                string = '[' + string.trim() + ']';
            } else {
                return {};
            }

            try {
                // remove trailing comma, duh
                /**
                 * find `,`, after which there is no any new attribute, object or array.
                 * New attribute could start either with quotes (" or ') or with any word-character (\w).
                 * New object could start only with character {.
                 * New array could start only with character [.
                 * New attribute, object or array could be placed after a bunch of space-like symbols (\s).
                 *
                 * Feel free to hack this regex if you got better idea
                 * @type {RegExp}
                 */
                var trailingCommaRegex = /\,(?!\s*?[\{\[\"\'\w])/g;
                string = string.replace(trailingCommaRegex, '');

                object = JSON.parse(string);
            } catch (e) {
                console.error(e.message);
                if (type === 'object') {
                    object = {};
                } else if (type === 'array') {
                    object = [];
                }
            }

            return object;

        },

    });

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function(options) {
        return this.each(function() {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new PowerformFront(this, options));
            }
        });
    };

    // hook from wp_editor tinymce
    $(document).on('tinymce-editor-init', function(event, editor) {
        // trigger editor change to save value to textarea,
        // default wp tinymce textarea update only triggered when submit
        var count = 0;
        editor.on('change', function() {
            // only powerform
            if (editor.id.indexOf('powerform-wp-editor-') === 0) {
                editor.save();
            }
            var editor_id = editor.id,
                $field = $('#' + editor_id).closest('.powerform-col'),
                $limit = $field.find('.powerform-description span');
            if ($limit.length) {
                if ($limit.data('limit')) {
                    if ($limit.data('type') !== "words") {
                        count = editor.getContent({ format: 'text' }).length;
                    } else {
                        count = editor.getContent({ format: 'text' }).split(/\s+/).length;
                    }
                    $limit.html(count + ' / ' + $limit.data('limit'));
                }
            }


        });
    });

})(jQuery, window, document);

// noinspection JSUnusedGlobalSymbols
var powerform_render_captcha = function() {
    // TODO: avoid conflict with another plugins that provide recaptcha
    //  notify powerform front that grecaptcha loaded. anc can be used
    jQuery('.powerform-g-recaptcha').each(function() {
        // find closest form
        var form = jQuery(this).closest('form');
        if (form.length > 0) {
            var powerformFront = form.data('powerformFront');
            if (typeof powerformFront !== 'undefined') {
                powerformFront.renderCaptcha(jQuery(this)[0]);
            }
        }
    });
};

// Source: http://stackoverflow.com/questions/497790
var powerformDateUtil = {
    month_number: function(v) {
        var months_short = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
        var months_full = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
        if (v.constructor === Number) {
            return v;
        }
        var n = NaN;
        if (v.constructor === String) {
            v = v.toLowerCase();
            var index = months_short.indexOf(v);
            if (index === -1) {
                index = months_full.indexOf(v);
            }
            n = (index === -1) ? NaN : index;
        }

        return n;
    },
    convert: function(d) {
        // Converts the date in d to a date-object. The input can be:
        //   a date object: returned without modification
        //  an array      : Interpreted as [year,month,day]. NOTE: month is 0-11.
        //   a number     : Interpreted as number of milliseconds
        //                  since 1 Jan 1970 (a timestamp)
        //   a string     : Any format supported by the javascript engine, like
        //                  "YYYY/MM/DD", "MM/DD/YYYY", "Jan 31 2009" etc.
        //  an object     : Interpreted as an object with year, month and date
        //                  attributes.  **NOTE** month is 0-11.
        return (
            d.constructor === Date ? d :
            d.constructor === Array ? new Date(d[0], this.month_number(d[1]), d[2]) :
            d.constructor === Number ? new Date(d) :
            d.constructor === String ? new Date(d) :
            typeof d === "object" ? new Date(d.year, this.month_number(d.month), d.date) :
            NaN
        );
    },
    compare: function(a, b) {
        // Compare two dates (could be of any type supported by the convert
        // function above) and returns:
        //  -1 : if a < b
        //   0 : if a = b
        //   1 : if a > b
        // NaN : if a or b is an illegal date
        // NOTE: The code inside isFinite does an assignment (=).
        return (
            isFinite(a = this.convert(a).valueOf()) &&
            isFinite(b = this.convert(b).valueOf()) ?
            (a > b) - (a < b) :
            NaN
        );
    },
    inRange: function(d, start, end) {
        // Checks if date in d is between dates in start and end.
        // Returns a boolean or NaN:
        //    true  : if d is between start and end (inclusive)
        //    false : if d is before start or after end
        //    NaN   : if one or more of the dates is illegal.
        // NOTE: The code inside isFinite does an assignment (=).
        return (
            isFinite(d = this.convert(d).valueOf()) &&
            isFinite(start = this.convert(start).valueOf()) &&
            isFinite(end = this.convert(end).valueOf()) ?
            start <= d && d <= end :
            NaN
        );
    },

    diffInDays: function(d1, d2) {
        d1 = this.convert(d1);
        d2 = this.convert(d2);
        if (typeof d1.getMonth !== 'function' || typeof d2.getMonth !== 'function') {
            return NaN;
        }

        var t2 = d2.getTime();
        var t1 = d1.getTime();

        return parseFloat((t2 - t1) / (24 * 3600 * 1000));
    },

    diffInWeeks: function(d1, d2) {
        d1 = this.convert(d1);
        d2 = this.convert(d2);
        if (typeof d1.getMonth !== 'function' || typeof d2.getMonth !== 'function') {
            return NaN;
        }

        var t2 = d2.getTime();
        var t1 = d1.getTime();

        return parseInt((t2 - t1) / (24 * 3600 * 1000 * 7));
    },

    diffInMonths: function(d1, d2) {
        d1 = this.convert(d1);
        d2 = this.convert(d2);
        if (typeof d1.getMonth !== 'function' || typeof d2.getMonth !== 'function') {
            return NaN;
        }

        var d1Y = d1.getFullYear();
        var d2Y = d2.getFullYear();
        var d1M = d1.getMonth();
        var d2M = d2.getMonth();

        return (d2M + 12 * d2Y) - (d1M + 12 * d1Y);
    },

    diffInYears: function(d1, d2) {
        d1 = this.convert(d1);
        d2 = this.convert(d2);
        if (typeof d1.getMonth !== 'function' || typeof d2.getMonth !== 'function') {
            return NaN;
        }

        return d2.getFullYear() - d1.getFullYear();
    }
};