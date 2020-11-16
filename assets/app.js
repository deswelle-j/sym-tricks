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
document.querySelectorAll('a.js-load-more').forEach(function(link){
  link.addEventListener('click', onClickBtnLoadMore);
})

function onClickBtnLoadMore(event){
  event.preventDefault();
      $.ajax({
          type: "post",
          url: routeTrick ,
          beforeSend: function () {
              $('.loader').show();
          },
          success: function (response) {
            console.log(response.view)
              if (response.view.length !== 0) {
                  $('.trick-item').last().after(response.view);
                  $('.loader').hide();
              } else {
                  $('.loader').hide();
              }
          }
      });

      index++;
      routeTrick = paginationsTrick[index];
      console.log(routeTrick);
}


$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

$("#arrow-scroll-down").click(function() {
    scrollToAnchor('tricks-list');
 });

