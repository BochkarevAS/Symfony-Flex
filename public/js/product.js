'use strict';

(function (window, $, Routing, swal) {

    let HelperInstances = new WeakMap();

    class Product {

        constructor($wrapper) {
            this.$wrapper = $wrapper;
            this.count = [];
            HelperInstances.set(this, new Helper(this.count));

            this.$wrapper.on('click', '.js-delete',
                this.handleDelete.bind(this)
            );

            this.$wrapper.on('submit', '.js-new',
                this.handleNewFormSubmit.bind(this)
            );

            this.load();
        }

        static _removeFormErrors($form) {
            $form.find('.js-field-error').remove();
            $form.find('.form-group').removeClass('has-error');
        }

        static _clearForm($form) {
            Product._removeFormErrors($form);
            $form[0].reset();
        }

        load() {
            $.ajax({
                url: Routing.generate('product_render')
            }).then((data) => {
                for (let row of data) {
                    this._addRow(row);
                }
                this._calculateTotalWeight();
            });
        }

        _calculateTotalWeight(cnt = 0) {
            let count = HelperInstances.get(this).calculateTotalWeight();
            this.$wrapper.find('.js-total-weight').html(count - cnt);
        }

        _addRow(product) {
            this.count.push(product.price);
            let html = rowTemplate(product); // Create a template object
            this.$wrapper.find('tbody').append($.parseHTML(html));
        }

        handleNewFormSubmit(e) {
            e.preventDefault();

            let $form = $(e.currentTarget);
            let formData = {};

            for (let fieldData of $form.serializeArray()) {
                formData[fieldData.name] = fieldData.value
            }

            $.ajax({
                url: $form.data('url'),
                method: 'POST',
                data: JSON.stringify(formData)
            }).then(data => {
                Product._clearForm($form);
                this._addRow(data);
                this._calculateTotalWeight();
            }).catch(jqXHR => {
                let errorData = JSON.parse(jqXHR.responseText);
                Product._removeFormErrors($form);

                for (let element of $form.find(':input')) {
                    let fieldName = $(element).attr('name');
                    let $wrapper = $(element).closest('.form-group');

                    if (!errorData.errors[fieldName]) {
                        // no error!
                        return;
                    }

                    let $error = $('<span class="js-field-error help-block"></span>');
                    $error.html(errorData.errors[fieldName]);
                    $wrapper.append($error);
                    $wrapper.addClass('has-error');
                }
            });
        }

        _delete($link) {
            let deleteUrl = $link.data('url');
            let $row = $link.closest('tr');

            $link.addClass('text-danger');
            $link.find('.fa').removeClass('fa-trash').addClass('fa-spinner').addClass('fa-spin');

            $.ajax({
                url: deleteUrl,
                method: 'POST'
            }).then(() => {
                $row.fadeOut('normal', () => {
                    $row.remove();
                    this._calculateTotalWeight($row.data('weight'));
                });
            })
        }

        handleDelete(e) {
            e.preventDefault();

            let $link = $(e.currentTarget);

            swal({
                title: 'Удаление',
                text: 'Вы уверены ?',
                showCancelButton: true
            }).then(willDelete => {
                this._delete($link);
            }).catch(function(arg) {
                console.log('canceled', arg);
            });
        }
    }

    /**
     * A "private" object
     */
    class Helper {
        constructor(count) {
            this.count = count;
        }

        calculateTotalWeight() {
            let totalWeight = 0;
            for (let element of this.count) {
                totalWeight += element;
            }
            return totalWeight;
        }
    }

    const rowTemplate = (prod) => `
        <tr data-weight="${prod.price}">
            <td>${prod.name}</td>
            <td>${prod.price}</td>
            <td></td>
            <td>
                <a href="#" class="js-delete" data-url="${prod.self}">
                    <span class="fa fa-trash"></span>
                </a>
            </td>
        </tr>`;

    window.Product = Product;

}(window, jQuery, Routing, swal));