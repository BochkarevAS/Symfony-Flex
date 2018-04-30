'use strict';

import $ from 'jquery';
import User from './Components/VK/User';

$(document).ready(function() {
    let $wrapper = $('.js-user-module');
    let user = new User($wrapper);
});