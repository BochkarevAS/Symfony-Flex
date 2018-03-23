'use strict';

(function (window, $, Routing) {
    window.Product = function ($wrapper) {
        this.$wrapper = $wrapper;
        this.helper = new Helper($wrapper);
        this.$wrapper.on('click', '.js-delete-rep-log', this.handleDelete.bind(this));
        this.$wrapper.on('submit', '.js-new-rep-log-form', this.handleNewFormSubmit.bind(this));
        this.load();
    };

    window.Product.prototype = {
        load: function () {
            $.ajax({
                url: Routing.generate('product_render')
            }).then((data) => {
                for (let row of data) {
                    this._addRow(row);
                }
                this._calculateTotalWeight();
            });
        },
        _calculateTotalWeight: function () {
            this.$wrapper.find('.js-total-weight').html(this.helper.calculateTotalWeight());
        },
        _removeFormErrors: function ($form) {
            $form.find('.js-field-error').remove();
            $form.find('.form-group').removeClass('has-error');
        },
        _clearForm: function ($form) {
            this._removeFormErrors($form);
            $form[0].reset();
        },
        _addRow: function (product) {
            let tplText = $('#js-rep-log-row-template').html();
            let tpl = _.template(tplText); // Create a template object
            let html = tpl(product);

            this.$wrapper.find('tbody').append($.parseHTML(html));
        },
        handleNewFormSubmit: function (e) {
            e.preventDefault();

            let $form = $(e.currentTarget);
            let formData = {};
            let self = this;

            $.each($form.serializeArray(), function(key, fieldData) {
                formData[fieldData.name] = fieldData.value
            });

            $.ajax({
                url: $form.data('url'),
                method: 'POST',
                data: JSON.stringify(formData)
            }).then(data => {
                self._clearForm($form);
                self._addRow(data);
                self._calculateTotalWeight();
            }).catch(jqXHR => {
                let errorData = JSON.parse(jqXHR.responseText);
                self._removeFormErrors($form);

                $form.find(':input').each(function () {
                    let fieldName = $(this).attr('name');
                    let $wrapper = $(this).closest('.form-group');

                    if (!errorData.errors[fieldName]) {
                        // no error!
                        return;
                    }

                    let $error = $('<span class="js-field-error help-block"></span>');
                    $error.html(errorData.errors[fieldName]);
                    $wrapper.append($error);
                    $wrapper.addClass('has-error');
                })
            });
        },
        handleDelete: function (e) {
            e.preventDefault();

            let $link = $(e.currentTarget);
            let deleteUrl = $link.data('url');
            let $row = $link.closest('tr');
            let self = this;

            $link.addClass('text-danger');
            $link.find('.fa').removeClass('fa-trash').addClass('fa-spinner').addClass('fa-spin');

            $.ajax({
                url: deleteUrl,
                method: 'POST'
            }).then(() => {
                $row.fadeOut('normal', () => {
                    $(this).remove();
                    self._calculateTotalWeight();
                });
            })
        }
    };

    /**
     * A "private" object
     */
    let Helper = function ($wrapper) {
        this.$wrapper = $wrapper;
    };
    Helper.prototype.calculateTotalWeight = function() {
        let totalWeight = 0;

        this.$wrapper.find('tbody tr').each(function () {
            totalWeight += $(this).data('weight');
        });

        return totalWeight;
    }
}(window, jQuery, Routing));