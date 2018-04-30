'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class User {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.find('.js-show-followers').on('click',
            this.showFollowers.bind(this)
        );

        this.$wrapper.find('.js-show-friends').on('click',
            this.showFriends.bind(this)
        );
    }

    showFriends(e) {
        e.preventDefault();

        let $target = $(e.currentTarget);
        let id = $target.data('id');

        $target.find('.fa').addClass('fa-spinner').addClass('fa-spin');

        $.ajax({
            url: Routing.generate('vk_user_friends', {
                'id': id
            }),
            method: 'POST'
        }).then((data) => {
            $target.fadeOut('normal', () => {
                for (let friend of data.items) {
                    this._addUsers(friend, '.js-friends-template');
                }
            });
        })
    }

    showFollowers(e) {
        e.preventDefault();

        let $target = $(e.currentTarget);
        let id = $target.data('id');

        $target.find('.fa').addClass('fa-spinner').addClass('fa-spin');

        $.ajax({
            url: Routing.generate('vk_user_followers', {
                'id': id
            }),
            method: 'POST'
        }).then((data) => {
            $target.fadeOut('normal', () => {
                for (let follower of data.items) {
                    this._addUsers(follower, '.js-followers-template');
                }
            });
        })
    }

    _addUsers(user, filter) {
        let html = rowTemplate(user);
        this.$wrapper.find('.js-followers-template').append($.parseHTML(html));
    }
}

const rowTemplate = (user) => `
    <div>
        <img src="${user.photo_50}">
        <a target="_blank" href="https://vk.com/id${user.id}">
            ${user.first_name} ${user.first_name} 
        </a>
    </div>`;

export default User;
