/*
 * assets/js/app.js
 */
// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');

// Add jQuery
const $ = require('jquery');

// create global $ to use jQuery
global.$ = global.jQuery = $;

// Add javascript from popper
// require('popper.js')

// Add javascript from bootstrap
require('bootstrap');

// Add javascript from bootstrap
require('./sidebar.js');
