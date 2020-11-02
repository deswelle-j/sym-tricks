/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
const $ = require('jquery');

require('bootstrap');
require('./now-ui-kit.js');
require('./trickForm.js')

// jQuery(function() {
//     $('[data-toggle="popover"]').popover();
// })
$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});