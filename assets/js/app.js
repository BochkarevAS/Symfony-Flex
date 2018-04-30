'use strict';

import $ from 'jquery';
import Product from './Components/Product';
import User from './Components/VK/User';

$(document).ready(function() {
    let $wrapper = $('.js-product-module');
    let product = new Product($wrapper);

    let $wrapper1 = $('.js-user-module');
    let user = new User($wrapper1);
});