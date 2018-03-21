'use strict';

(function (window, $) {
    window.Product = function ($wrapper) {
        this.$wrapper = $wrapper;
        this.helper = new Helper($wrapper);
        this.$wrapper.on('click', '.js-delete-rep-log', this.handleDelete.bind(this));
        this.$wrapper.on('submit', '.js-new-rep-log-form', this.handleNewFormSubmit.bind(this));
        this.$wrapper.find('.js-total-weight').html(this.helper.calculateTotalWeight());
    };

    window.Product.prototype = {
        handleNewFormSubmit: function (e) {
            e.preventDefault();

            var $form = $(e.currentTarget);
            var formData = {};

            $.each($form.serializeArray(), function(key, fieldData) {
                formData[fieldData.name] = fieldData.value
            });

            $.ajax({
                url: $form.data('url'),
                method: 'POST',
                data: JSON.stringify(formData),
                success: function (data) {
                    console.log('1');
                },
                error: function (jqXHR) {
                    var errorData = JSON.parse(jqXHR.responseText);
                    $form.find('.js-field-error').remove();
                    $form.find('.form-group').removeClass('has-error');

                    $form.find(':input').each(function () {
                        var fieldName = $(this).attr('name');
                        var $wrapper = $(this).closest('.form-group');

                        if (!errorData.errors[fieldName]) {
                            // no error!
                            return;
                        }

                        var $error = $('<span class="js-field-error help-block"></span>');
                        $error.html(errorData.errors[fieldName]);
                        $wrapper.append($error);
                        $wrapper.addClass('has-error');
                    })
                }
            });
        },
        handleDelete: function (e) {
            e.preventDefault();

            var $link = $(e.currentTarget);
            var deleteUrl = $link.data('url');
            var $row = $link.closest('tr');
            var self = this;

            $link.addClass('text-danger');
            $link.find('.fa')
                .removeClass('fa-trash')
                .addClass('fa-spinner')
                .addClass('fa-spin');

            $.ajax({
                url: deleteUrl,
                method: 'POST',
                success: function () {
                    $row.fadeOut('normal', function() {
                        $(this).remove();
                        self.$wrapper.find('.js-total-weight').html(self.helper.calculateTotalWeight());
                    });
                }
            })
        }
    };

    /**
     * A "private" object
     */
    var Helper = function ($wrapper) {
        this.$wrapper = $wrapper;
    };
    Helper.prototype.calculateTotalWeight = function() {
        var totalWeight = 0;

        this.$wrapper.find('tbody tr').each(function () {
            totalWeight += $(this).data('weight');
        });

        return totalWeight;
    }
}(window, jQuery));