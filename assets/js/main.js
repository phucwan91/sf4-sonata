/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.

// console.log('Hello Webpack Encore !');

require('../css/main.scss');

import $    from 'jquery';
import Text from './block/Text';

const importedModules = {
    '#text-block': Text,
};

window.$ = window.jQuery = $;

$(document).ready(() => {
    $.each(importedModules, (key, module) => {
        if($(key).length > 0) {
            window[module.name] = module;
        }
    });
});
