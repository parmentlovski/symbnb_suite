(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["js/ad"],{

/***/ "./assets/js/ad.js":
/*!*************************!*\
  !*** ./assets/js/ad.js ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! core-js/modules/es.regexp.exec */ "./node_modules/core-js/modules/es.regexp.exec.js");

__webpack_require__(/*! core-js/modules/es.string.replace */ "./node_modules/core-js/modules/es.string.replace.js");

$('#add-images').click(function () {
  // Je récupère le numéro des futurs champs que je vais créer
  var index = +$('#widgets-counter').val(); // Je récupère le prototy des entrées

  var tmpl = $('#ad_images').data('prototype').replace(/__name/g, index); // J'injecte ce code au sein de la div

  $('#ad_images').append(tmpl);
  $('#widgets-counter').val(index + 1); // Je gère le button supprimer

  handleDeleteButtons();
});

function handleDeleteButtons() {
  $('button[data-action="delete"]').click(function () {
    var target = this.dataset.target;
    $(target).remove();
  });
}

function updateCounter() {
  var count = +$('#ad_images div.form-group').length;
  $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();

/***/ })

},[["./assets/js/ad.js","runtime","vendors~js/ad"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvYWQuanMiXSwibmFtZXMiOlsiJCIsImNsaWNrIiwiaW5kZXgiLCJ2YWwiLCJ0bXBsIiwiZGF0YSIsInJlcGxhY2UiLCJhcHBlbmQiLCJoYW5kbGVEZWxldGVCdXR0b25zIiwidGFyZ2V0IiwiZGF0YXNldCIsInJlbW92ZSIsInVwZGF0ZUNvdW50ZXIiLCJjb3VudCIsImxlbmd0aCJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7OztBQUFBQSxDQUFDLENBQUMsYUFBRCxDQUFELENBQWlCQyxLQUFqQixDQUF1QixZQUFXO0FBQUU7QUFDaEMsTUFBTUMsS0FBSyxHQUFHLENBQUNGLENBQUMsQ0FBQyxrQkFBRCxDQUFELENBQXNCRyxHQUF0QixFQUFmLENBRDhCLENBRzlCOztBQUNBLE1BQU1DLElBQUksR0FBR0osQ0FBQyxDQUFDLFlBQUQsQ0FBRCxDQUFnQkssSUFBaEIsQ0FBcUIsV0FBckIsRUFBa0NDLE9BQWxDLENBQTBDLFNBQTFDLEVBQXFESixLQUFyRCxDQUFiLENBSjhCLENBTTlCOztBQUNBRixHQUFDLENBQUMsWUFBRCxDQUFELENBQWdCTyxNQUFoQixDQUF1QkgsSUFBdkI7QUFFQUosR0FBQyxDQUFDLGtCQUFELENBQUQsQ0FBc0JHLEdBQXRCLENBQTBCRCxLQUFLLEdBQUcsQ0FBbEMsRUFUOEIsQ0FXOUI7O0FBQ0FNLHFCQUFtQjtBQUN0QixDQWJEOztBQWVBLFNBQVNBLG1CQUFULEdBQStCO0FBQzNCUixHQUFDLENBQUMsOEJBQUQsQ0FBRCxDQUFrQ0MsS0FBbEMsQ0FBd0MsWUFBVztBQUMvQyxRQUFNUSxNQUFNLEdBQUcsS0FBS0MsT0FBTCxDQUFhRCxNQUE1QjtBQUNBVCxLQUFDLENBQUNTLE1BQUQsQ0FBRCxDQUFVRSxNQUFWO0FBRUgsR0FKRDtBQUtIOztBQUVELFNBQVNDLGFBQVQsR0FBeUI7QUFDckIsTUFBTUMsS0FBSyxHQUFHLENBQUNiLENBQUMsQ0FBQywyQkFBRCxDQUFELENBQStCYyxNQUE5QztBQUVBZCxHQUFDLENBQUMsa0JBQUQsQ0FBRCxDQUFzQkcsR0FBdEIsQ0FBMEJVLEtBQTFCO0FBQ0g7O0FBRURELGFBQWE7QUFFYkosbUJBQW1CLEciLCJmaWxlIjoianMvYWQuanMiLCJzb3VyY2VzQ29udGVudCI6WyIkKCcjYWRkLWltYWdlcycpLmNsaWNrKGZ1bmN0aW9uKCkgeyAvLyBKZSByw6ljdXDDqHJlIGxlIG51bcOpcm8gZGVzIGZ1dHVycyBjaGFtcHMgcXVlIGplIHZhaXMgY3LDqWVyXHJcbiAgICBjb25zdCBpbmRleCA9ICskKCcjd2lkZ2V0cy1jb3VudGVyJykudmFsKCk7XHJcblxyXG4gICAgLy8gSmUgcsOpY3Vww6hyZSBsZSBwcm90b3R5IGRlcyBlbnRyw6llc1xyXG4gICAgY29uc3QgdG1wbCA9ICQoJyNhZF9pbWFnZXMnKS5kYXRhKCdwcm90b3R5cGUnKS5yZXBsYWNlKC9fX25hbWUvZywgaW5kZXgpO1xyXG5cclxuICAgIC8vIEonaW5qZWN0ZSBjZSBjb2RlIGF1IHNlaW4gZGUgbGEgZGl2XHJcbiAgICAkKCcjYWRfaW1hZ2VzJykuYXBwZW5kKHRtcGwpO1xyXG5cclxuICAgICQoJyN3aWRnZXRzLWNvdW50ZXInKS52YWwoaW5kZXggKyAxKTtcclxuXHJcbiAgICAvLyBKZSBnw6hyZSBsZSBidXR0b24gc3VwcHJpbWVyXHJcbiAgICBoYW5kbGVEZWxldGVCdXR0b25zKCk7XHJcbn0pO1xyXG5cclxuZnVuY3Rpb24gaGFuZGxlRGVsZXRlQnV0dG9ucygpIHtcclxuICAgICQoJ2J1dHRvbltkYXRhLWFjdGlvbj1cImRlbGV0ZVwiXScpLmNsaWNrKGZ1bmN0aW9uKCkge1xyXG4gICAgICAgIGNvbnN0IHRhcmdldCA9IHRoaXMuZGF0YXNldC50YXJnZXQ7XHJcbiAgICAgICAgJCh0YXJnZXQpLnJlbW92ZSgpO1xyXG5cclxuICAgIH0pO1xyXG59XHJcblxyXG5mdW5jdGlvbiB1cGRhdGVDb3VudGVyKCkge1xyXG4gICAgY29uc3QgY291bnQgPSArJCgnI2FkX2ltYWdlcyBkaXYuZm9ybS1ncm91cCcpLmxlbmd0aDtcclxuXHJcbiAgICAkKCcjd2lkZ2V0cy1jb3VudGVyJykudmFsKGNvdW50KTtcclxufVxyXG5cclxudXBkYXRlQ291bnRlcigpO1xyXG5cclxuaGFuZGxlRGVsZXRlQnV0dG9ucygpOyJdLCJzb3VyY2VSb290IjoiIn0=