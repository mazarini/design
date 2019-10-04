/*
 * assets/js/sidebar.js
 */

$("#side-toggle").click(function (e) {
    e.preventDefault();
    $("body").toggleClass("toggled");
});
