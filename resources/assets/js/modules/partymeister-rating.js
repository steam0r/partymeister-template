/*!
 * jQuery rating plugin for PartyMeister
 */
;(function ($, window, document, undefined) {

// Create the defaults once
    var pluginName = "partymeisterRating",
        defaults = {
            readOnly: false,
            stars: 5,
            negative: false,
            value: 0,
            starOn: 'partymeister-rating-star-on',
            starOff: 'partymeister-rating-star-off',
            negativeOn: 'partymeister-rating-negative-on',
            negativeOff: 'partymeister-rating-negative-off',
            cancelOn: 'partymeister-rating-cancel-on',
            cancelOff: 'partymeister-rating-cancel-off',
            wrapperClass: 'partymeister-rating-wrapper',
            ratingClass: 'partymeister-rating',
            hints: ['Cancel vote', 'This entry is really bad :( -1 points', 'Bad: 1 point', 'Ok: 2 points', 'Good: 3 points', 'Great: 4 points', 'Fan-fucking-tastic: 5 points']
        };

    // The actual plugin constructor
    function PartymeisterRating(element, options) {
        var plugin = this;
        this.element = element;

        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this._negative = false;
        this._cancel = false;
        this._stars = [];

        this.init();
    }

    PartymeisterRating.prototype = {

        init: function () {
            if (!this.options.readonly) {
                this.buildCancel(this);
            }
            if (this.options.negative) {
                this.buildNegative(this);
            }
            this.buildStars(this);
        },

        buildStars: function (that) {
            $('<input />', {name: 'points', value: that.options.value, type: 'hidden'}).appendTo(that.element);

            for (i = 1; i <= that.options.stars; i++) {
                var attrs = {
                    'data-points': i,
                    'data-on': that.options.starOn,
                    'data-off': that.options.starOff,
                    'class': that.options.wrapperClass + ' ' + that.options.ratingClass + ' ' + that.options.starOff,
                    'title': that.options.hints[i + 1]
                };

                var star = $('<div/>', attrs).appendTo(that.element);

                if (!that.options.readonly) {
                    star.on('mouseout', that, that._bindMouseOut);
                    star.on('mouseover', that, that._bindMouseOver);
                    star.on('click', that, that._bindClick);
                }

                that._stars.push(star);
            }

            // Trigger highlight method
            that._switchHighlightClasses(star, that.options.value, that);
        },

        buildCancel: function (that) {
            var attrs = {
                'data-points': 0,
                'data-on': that.options.cancelOn,
                'data-off': that.options.cancelOff,
                'class': that.options.wrapperClass + ' ' + that.options.ratingClass + ' ' + that.options.cancelOff,
                'title': that.options.hints[0]
            };

            that._cancel = $('<div/>', attrs).appendTo(that.element);

            if (!that.options.readonly) {
                that._cancel.on('mouseout', that, that._bindMouseOut);
                that._cancel.on('mouseover', that, that._bindMouseOver);
                that._cancel.on('click', that, that._bindClick);
            }
        },

        buildNegative: function (that) {
            var attrs = {
                'data-points': -1,
                'data-on': that.options.negativeOn,
                'data-off': that.options.negativeOff,
                'class': that.options.wrapperClass + ' ' + that.options.ratingClass + ' ' + that.options.negativeOff,
                'title': that.options.hints[1]
            };

            that._negative = $('<div/>', attrs).appendTo(that.element);

            if (!that.options.readonly) {
                that._negative.on('mouseout', that, that._bindMouseOut);
                that._negative.on('mouseover', that, that._bindMouseOver);
                that._negative.on('click', that, that._bindClick);
            }
        },

        _bindClick: function (e) {
            // Set score
            $(this).parent().find('input[name="points"]').val($(this).data('points'));
            $(this).trigger('mouseout');
            $(this).parent().data('value', $(this).data('points'));

            e.data.options.click(parseInt($(this).parent().find('input[name="points"]').val()), $(this).parent()[0]);
        },

        _bindMouseOver: function (e) {

            var points = parseInt($(this).data('points'));

            if (!$(this).hasClass('star')) {
                $(this).removeClass($(this).data('off'));
                $(this).addClass($(this).data('on'));
            }

            e.data._switchHighlightClasses(this, points, e.data);
        },

        _bindMouseOut: function (e) {
            var actualPoints = parseInt($(this).parent().find('input[name="points"]').val());
            if (isNaN(actualPoints)) {
                actualPoints = 0;
            }

            if (!$(this).hasClass('star')) {
                $(this).removeClass($(this).data('on'));
                $(this).addClass($(this).data('off'));
            }

            e.data._switchHighlightClasses(this, actualPoints, e.data);
        },

        _switchHighlightClasses: function (element, points, plugin) {
            // First we remove all highlights
            if (points != -1) {
                $(element).parent().find('div[data-points="-1"]').removeClass(plugin.options.negativeOn);
                $(element).parent().find('div[data-points="-1"]').addClass(plugin.options.negativeOff);
            }

            for (i = 1; i <= plugin.options.stars; i++) {
                $(element).parent().find('div[data-points="' + i + '"]').removeClass(plugin.options.starOn);
                $(element).parent().find('div[data-points="' + i + '"]').addClass(plugin.options.starOff);
            }

            // Then we re-add the appropriate hightlights again
            for (i = 1; i <= points; i++) {
                $(element).parent().find('div[data-points="' + i + '"]').removeClass((plugin.options.starOff));
                $(element).parent().find('div[data-points="' + i + '"]').addClass((plugin.options.starOn));
            }

            if (points == -1) {
                $(element).parent().find('div[data-points="-1"]').removeClass(plugin.options.negativeOff);
                $(element).parent().find('div[data-points="-1"]').addClass(plugin.options.negativeOn);
            }
        },
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function (options) {
        return this.each(function () {
            options.value = $(this).data('value');
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                    new PartymeisterRating(this, options));
            }
        });
    };

})(jQuery, window, document);
