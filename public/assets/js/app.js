'use strict';

const $ = require('jquery');
const Product = require('./Components/Product');

$(document).ready(function() {
    let $wrapper = $('.js-product-module');
    let product = new Product($wrapper);
});