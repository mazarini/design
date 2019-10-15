/*
 * assets/js/sidebar.js
 */

$("#side-toggler").click(function (e) {
    e.preventDefault();
    $("body").toggleClass("toggled");
});
