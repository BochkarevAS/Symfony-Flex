'use strict';

import $ from 'jquery';
import '../css/login.css';

$(document).ready(function() {
    $('.js-login-field-username').on('keydown', function(e) {
        const $usernameInput = $(e.currentTarget);
        $('.login-long-username-warning').remove();

        if ($usernameInput.val().length >= 20) {
            const $warning = $('<div class="login-long-username-warning">Слишком длиное имя пользователя</div>');
            $usernameInput.before($warning);
        }
    });
});
