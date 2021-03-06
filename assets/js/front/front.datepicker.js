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
    var pluginName = "powerformFrontDatePicker",
        defaults = {};

    // The actual plugin constructor
    function PowerformFrontDatePicker(element, options) {
        this.element = element;
        this.$el = $(this.element);

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
    $.extend(PowerformFrontDatePicker.prototype, {
        init: function() {
            var self = this,
                dateFormat = this.$el.data('format'),
                restrictType = this.$el.data('restrict-type'),
                restrict = this.$el.data('restrict'),
                restrictedDays = this.$el.data('restrict'),
                minYear = this.$el.data('start-year'),
                maxYear = this.$el.data('end-year'),
                pastDates = this.$el.data('past-dates'),
                dateValue = this.$el.val(),
                startOfWeek = this.$el.data('start-of-week'),
                minDate = this.$el.data('start-date'),
                maxDate = this.$el.data('end-date'),
                startField = this.$el.data('start-field'),
                endField = this.$el.data('end-field'),
                startOffset = this.$el.data('start-offset'),
                endOffset = this.$el.data('end-offset'),
                disableDate = this.$el.data('disable-date'),
                disableRange = this.$el.data('disable-range');

            //possible restrict only one
            if (!isNaN(parseFloat(restrictedDays)) && isFinite(restrictedDays)) {
                restrictedDays = [restrictedDays.toString()];
            } else {
                restrictedDays = restrict.split(',');
            }
            disableDate = disableDate.split(',');
            disableRange = disableRange.split(',');

            if (!minYear) {
                minYear = "c-95";
            }
            if (!maxYear) {
                maxYear = "c+95";
            }
            var disabledWeekDays = function(current_date) {
                return self.restrict_date(restrictedDays, disableDate, disableRange, current_date);
            };

            var parent = this.$el.closest('.powerform-custom-form'),
                add_class = "powerform-calendar";

            if (parent.hasClass('powerform-design--default')) {
                add_class = "powerform-calendar--default";
            } else if (parent.hasClass('powerform-design--material')) {
                add_class = "powerform-calendar--material";
            } else if (parent.hasClass('powerform-design--flat')) {
                add_class = "powerform-calendar--flat";
            } else if (parent.hasClass('powerform-design--bold')) {
                add_class = "powerform-calendar--bold";
            }


            this.$el.datepicker({
                "beforeShow": function(input, inst) {
                    // Remove all Hustle UI related classes
                    (inst.dpDiv).removeClass(function(index, css) {
                        return (css.match(/\bhustle-\S+/g) || []).join(' ');
                    });

                    // Remove all Powerform UI related classes
                    (inst.dpDiv).removeClass(function(index, css) {
                        return (css.match(/\bpowerform-\S+/g) || []).join(' ');
                    });
                    (inst.dpDiv).addClass('powerform-custom-form-' + parent.data('form-id') + ' ' + add_class);
                    // Enable/disable past dates
                    if ('disable' === pastDates) {
                        $(this).datepicker('option', 'minDate', dateValue);
                    } else {
                        $(this).datepicker('option', 'minDate', null);
                    }
                    if (minDate) {
                        var min_date = new Date(minDate);
                        $(this).datepicker('option', 'minDate', min_date);
                    }
                    if (maxDate) {
                        var max_date = new Date(maxDate);
                        $(this).datepicker('option', 'maxDate', max_date);
                    }
                    if (startField) {
                        var fieldVal = $('input[name ="' + startField + '"]').val();
                        if (typeof fieldVal !== 'undefined') {
                            var startDate = new Date(fieldVal),
                                sdata = startOffset.split('_'),
                                start_new_date = moment(startDate).add(sdata[1], sdata[2]);
                            if ('-' === sdata[0]) {
                                start_new_date = moment(startDate).subtract(sdata[1], sdata[2]);
                            }
                            var start_date_format = moment(start_new_date).format(dateFormat.toUpperCase()),
                                startDateVal = new Date(start_date_format);
                            $(this).datepicker('option', 'minDate', startDateVal);
                        }
                    }

                    if (endField) {
                        var endFieldVal = $('input[name ="' + endField + '"]').val();
                        if (typeof endFieldVal !== 'undefined') {
                            var endDate = new Date(endFieldVal),
                                edata = endOffset.split('_'),
                                end_new_date = moment(endDate).add(edata[1], edata[2]);
                            if ('-' === edata[0]) {
                                end_new_date = moment(endDate).subtract(edata[1], edata[2]);
                            }
                            var end_date_format = moment(end_new_date).format(dateFormat.toUpperCase()),
                                endDateVal = new Date(end_date_format);
                            $(this).datepicker('option', 'maxDate', endDateVal);
                        }
                    }
                },
                "beforeShowDay": disabledWeekDays,
                "monthNames": datepickerLang.monthNames,
                "monthNamesShort": datepickerLang.monthNamesShort,
                "dayNames": datepickerLang.dayNames,
                "dayNamesShort": datepickerLang.dayNamesShort,
                "dayNamesMin": datepickerLang.dayNamesMin,
                "changeMonth": true,
                "changeYear": true,
                "dateFormat": dateFormat,
                "yearRange": minYear + ":" + maxYear,
                "minDate": new Date(minYear, 0, 1),
                "maxDate": new Date(maxYear, 11, 31),
                "firstDay": startOfWeek,
                "onClose": function() {
                    //Called when the datepicker is closed, whether or not a date is selected
                    $(this).valid();
                },
            });

            //Disables google translator for the datepicker - this prevented that when selecting the date the result is presented as follows: NaN/NaN/NaN
            $('.ui-datepicker').addClass('notranslate');
        },

        restrict_date: function(restrictedDays, disableDate, disableRange, date) {
            var hasRange = true,
                day = date.getDay(),
                date_string = jQuery.datepicker.formatDate('mm/dd/yy', date);

            for (var i = 0; i < disableRange.length; i++) {

                var disable_date_range = disableRange[i].split("-"),
                    start_date = new Date($.trim(disable_date_range[0])),
                    end_date = new Date($.trim(disable_date_range[1]));
                if (date >= start_date && date <= end_date) {
                    hasRange = false;
                    break;
                }
            }

            if (-1 !== restrictedDays.indexOf(day.toString()) ||
                -1 !== disableDate.indexOf(date_string) ||
                false === hasRange
            ) {
                return [false, "disabledDate"]
            } else {
                return [true, "enabledDate"]
            }
        },
    });

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function(options) {
        return this.each(function() {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new PowerformFrontDatePicker(this, options));
            }
        });
    };

})(jQuery, window, document);