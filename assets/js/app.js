'use strict';

import $ from 'jquery';
import Product from './Components/Product';

$(document).ready(function() {
    let $wrapper = $('.js-product-module');
    let product = new Product($wrapper);
});