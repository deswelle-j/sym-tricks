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
require('./plugins/jasny-bootstrap.min.js');
require('./trickForm.js')

function scrollToAnchor(aid){
    var aTag = $("a[name='"+ aid +"']");
    $('html,body').animate({scrollTop: aTag.offset().top},'slow');
}

document.querySelectorAll('a.js-load-more-trick').forEach(function(link){
  link.addEventListener('click', onClickBtnLoadMoreTricks);
})

document.querySelectorAll('a.js-load-more-comment').forEach(function(link){
    link.addEventListener('click', onClickBtnLoadMoreComments);
})

function onClickBtnLoadMoreComments(event){
    event.preventDefault();
    $.ajax({
        type: "post",
        url: routeComment ,
        beforeSend: function () {
            $('.loader').show();
        },
        success: function (response) {
        //   console.log(response.view)
            if (response.view.length !== 0) {
                $('.comment-item').last().after(response.view);
                $('.loader').hide();
            } else {
                $('.loader').hide();
            }
        }
    });

    index++;
    if( index >= paginationsComment.length ){
        document.querySelector('a.js-load-more-comment').style.display = 'none';
    }else {
        routeComment = paginationsComment[index];
    }
    // console.log(paginationsComment[index]);
}

function onClickBtnLoadMoreTricks(event){
    event.preventDefault();
    $.ajax({
        type: "post",
        url: routeTrick ,
        beforeSend: function () {
            $('.loader').show();
        },
        success: function (response) {
        // console.log(response.view)
            if (response.view.length !== 0) {
                $('.trick-item').last().after(response.view);
                $('.loader').hide();
            } else {
                $('.loader').hide();
            }
        }
    });

    index++;
    if( index >= paginationsTrick.length ){
        document.querySelector('a.js-load-more-trick').style.display = 'none';
    }else {
        routeTrick = paginationsTrick[index];
    }
        routeTrick = paginationsTrick[index];
    //   console.log(routeTrick);
}


$(function() {
    $('[data-toggle="popover"]').popover();
    var theHREF;
    $(".confirmModalLink").on( "click", function(e) {
        e.preventDefault();
        theHREF = $(this).attr("href");
        $("#confirmModal").modal("show");
    });

    $("#confirmModalYes").on( "click", function(e) {
        window.location.href = theHREF;
    });

});

$("#arrow-scroll-down").on( "click", function(e) {
    scrollToAnchor('tricks-list');
 });

