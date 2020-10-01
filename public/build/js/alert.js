(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["js/alert"],{

/***/ "./assets/js/alert.js":
/*!****************************!*\
  !*** ./assets/js/alert.js ***!
  \****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! sweetalert2 */ "./node_modules/sweetalert2/dist/sweetalert2.all.js");
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(sweetalert2__WEBPACK_IMPORTED_MODULE_0__);

$("document").ready(function () {
  sweetalert2__WEBPACK_IMPORTED_MODULE_0___default.a.fire({
    width: "100%",
    heightAuto: "false",
    position: 'bottom',
    background: '#C0B293',
    text: 'Nous utilisons des cookies pour vous garantir la meilleure expérience sur notre site web. Si vous continuez à utiliser ce site, nous supposerons que vous en êtes satisfait.',
    confirmButtonText: '<i class="fas fa-check hvr-icon" style="padding-right:1px"></i>Ok',
    customClass: {
      container: 'container-class',
      popup: 'popup-class',
      header: 'header-class',
      title: 'title-class',
      closeButton: 'close-button-class',
      icon: 'icon-class',
      image: 'image-class',
      content: 'content-class',
      input: 'input-class',
      actions: 'hvr-icon-rotate',
      confirmButton: 'confirm-button-class',
      cancelButton: 'cancel-button-class',
      footer: 'footer-class'
    }
  }), $(".fas").click(function () {
    sweetalert2__WEBPACK_IMPORTED_MODULE_0___default.a.fire({
      title: "<strong>Alerte Bloqueur de pub !</strong>",
      icon: "info",
      html: "Pour une meilleure expérience veuillez désactiver Adblock ou tout autre bloqueur de pub",
      showCloseButton: true,
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonText: '<i class="fa fa-thumbs-up"></i>',
      confirmButtonAriaLabel: "Thumbs up",
      cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
      cancelButtonAriaLabel: "Thumbs down",
      customClass: {
        container: 'adblock-class'
      }
    });
  });
});

/***/ })

},[["./assets/js/alert.js","runtime","vendors~js/alert~js/info"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvYWxlcnQuanMiXSwibmFtZXMiOlsiJCIsInJlYWR5IiwiU3dhbCIsImZpcmUiLCJ3aWR0aCIsImhlaWdodEF1dG8iLCJwb3NpdGlvbiIsImJhY2tncm91bmQiLCJ0ZXh0IiwiY29uZmlybUJ1dHRvblRleHQiLCJjdXN0b21DbGFzcyIsImNvbnRhaW5lciIsInBvcHVwIiwiaGVhZGVyIiwidGl0bGUiLCJjbG9zZUJ1dHRvbiIsImljb24iLCJpbWFnZSIsImNvbnRlbnQiLCJpbnB1dCIsImFjdGlvbnMiLCJjb25maXJtQnV0dG9uIiwiY2FuY2VsQnV0dG9uIiwiZm9vdGVyIiwiY2xpY2siLCJodG1sIiwic2hvd0Nsb3NlQnV0dG9uIiwic2hvd0NhbmNlbEJ1dHRvbiIsImZvY3VzQ29uZmlybSIsImNvbmZpcm1CdXR0b25BcmlhTGFiZWwiLCJjYW5jZWxCdXR0b25UZXh0IiwiY2FuY2VsQnV0dG9uQXJpYUxhYmVsIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7O0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFFQUEsQ0FBQyxDQUFDLFVBQUQsQ0FBRCxDQUFjQyxLQUFkLENBQW9CLFlBQVc7QUFFM0JDLG9EQUFJLENBQUNDLElBQUwsQ0FBVTtBQUNOQyxTQUFLLEVBQUUsTUFERDtBQUVOQyxjQUFVLEVBQUUsT0FGTjtBQUdOQyxZQUFRLEVBQUUsUUFISjtBQUlOQyxjQUFVLEVBQUUsU0FKTjtBQUtOQyxRQUFJLEVBQUUsOEtBTEE7QUFNTkMscUJBQWlCLEVBQUUsbUVBTmI7QUFPTkMsZUFBVyxFQUFFO0FBQ1RDLGVBQVMsRUFBRSxpQkFERjtBQUVUQyxXQUFLLEVBQUUsYUFGRTtBQUdUQyxZQUFNLEVBQUUsY0FIQztBQUlUQyxXQUFLLEVBQUUsYUFKRTtBQUtUQyxpQkFBVyxFQUFFLG9CQUxKO0FBTVRDLFVBQUksRUFBRSxZQU5HO0FBT1RDLFdBQUssRUFBRSxhQVBFO0FBUVRDLGFBQU8sRUFBRSxlQVJBO0FBU1RDLFdBQUssRUFBRSxhQVRFO0FBVVRDLGFBQU8sRUFBRSxpQkFWQTtBQVdUQyxtQkFBYSxFQUFFLHNCQVhOO0FBWVRDLGtCQUFZLEVBQUUscUJBWkw7QUFhVEMsWUFBTSxFQUFFO0FBYkM7QUFQUCxHQUFWLEdBd0JJdkIsQ0FBQyxDQUFDLE1BQUQsQ0FBRCxDQUFVd0IsS0FBVixDQUFnQixZQUFVO0FBRXZCdEIsc0RBQUksQ0FBQ0MsSUFBTCxDQUFVO0FBQ2JXLFdBQUssRUFBRSwyQ0FETTtBQUViRSxVQUFJLEVBQUUsTUFGTztBQUdiUyxVQUFJLEVBQUUseUZBSE87QUFJYkMscUJBQWUsRUFBRSxJQUpKO0FBS2JDLHNCQUFnQixFQUFFLElBTEw7QUFNYkMsa0JBQVksRUFBRSxLQU5EO0FBT2JuQix1QkFBaUIsRUFBRSxpQ0FQTjtBQVFib0IsNEJBQXNCLEVBQUUsV0FSWDtBQVNiQyxzQkFBZ0IsRUFBRSxtQ0FUTDtBQVViQywyQkFBcUIsRUFBRSxhQVZWO0FBV2JyQixpQkFBVyxFQUFFO0FBQ1RDLGlCQUFTLEVBQUU7QUFERjtBQVhBLEtBQVY7QUFlRixHQWpCRCxDQXhCSjtBQTBDSCxDQTVDRCxFIiwiZmlsZSI6ImpzL2FsZXJ0LmpzIiwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IFN3YWwgZnJvbSBcInN3ZWV0YWxlcnQyXCI7XHJcblxyXG4kKFwiZG9jdW1lbnRcIikucmVhZHkoZnVuY3Rpb24oKSB7XHJcblxyXG4gICAgU3dhbC5maXJlKHtcclxuICAgICAgICB3aWR0aDogXCIxMDAlXCIsXHJcbiAgICAgICAgaGVpZ2h0QXV0bzogXCJmYWxzZVwiLFxyXG4gICAgICAgIHBvc2l0aW9uOiAnYm90dG9tJyxcclxuICAgICAgICBiYWNrZ3JvdW5kOiAnI0MwQjI5MycsXHJcbiAgICAgICAgdGV4dDogJ05vdXMgdXRpbGlzb25zIGRlcyBjb29raWVzIHBvdXIgdm91cyBnYXJhbnRpciBsYSBtZWlsbGV1cmUgZXhww6lyaWVuY2Ugc3VyIG5vdHJlIHNpdGUgd2ViLiBTaSB2b3VzIGNvbnRpbnVleiDDoCB1dGlsaXNlciBjZSBzaXRlLCBub3VzIHN1cHBvc2Vyb25zIHF1ZSB2b3VzIGVuIMOqdGVzIHNhdGlzZmFpdC4nLFxyXG4gICAgICAgIGNvbmZpcm1CdXR0b25UZXh0OiAnPGkgY2xhc3M9XCJmYXMgZmEtY2hlY2sgaHZyLWljb25cIiBzdHlsZT1cInBhZGRpbmctcmlnaHQ6MXB4XCI+PC9pPk9rJyxcclxuICAgICAgICBjdXN0b21DbGFzczoge1xyXG4gICAgICAgICAgICBjb250YWluZXI6ICdjb250YWluZXItY2xhc3MnLFxyXG4gICAgICAgICAgICBwb3B1cDogJ3BvcHVwLWNsYXNzJyxcclxuICAgICAgICAgICAgaGVhZGVyOiAnaGVhZGVyLWNsYXNzJyxcclxuICAgICAgICAgICAgdGl0bGU6ICd0aXRsZS1jbGFzcycsXHJcbiAgICAgICAgICAgIGNsb3NlQnV0dG9uOiAnY2xvc2UtYnV0dG9uLWNsYXNzJyxcclxuICAgICAgICAgICAgaWNvbjogJ2ljb24tY2xhc3MnLFxyXG4gICAgICAgICAgICBpbWFnZTogJ2ltYWdlLWNsYXNzJyxcclxuICAgICAgICAgICAgY29udGVudDogJ2NvbnRlbnQtY2xhc3MnLFxyXG4gICAgICAgICAgICBpbnB1dDogJ2lucHV0LWNsYXNzJyxcclxuICAgICAgICAgICAgYWN0aW9uczogJ2h2ci1pY29uLXJvdGF0ZScsXHJcbiAgICAgICAgICAgIGNvbmZpcm1CdXR0b246ICdjb25maXJtLWJ1dHRvbi1jbGFzcycsXHJcbiAgICAgICAgICAgIGNhbmNlbEJ1dHRvbjogJ2NhbmNlbC1idXR0b24tY2xhc3MnLFxyXG4gICAgICAgICAgICBmb290ZXI6ICdmb290ZXItY2xhc3MnXHJcbiAgICAgICAgICB9XHJcbiAgICAgICAgfSksXHJcblxyXG4gICAgICAgICQoXCIuZmFzXCIpLmNsaWNrKGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgIFN3YWwuZmlyZSh7XHJcbiAgICAgICAgdGl0bGU6IFwiPHN0cm9uZz5BbGVydGUgQmxvcXVldXIgZGUgcHViICE8L3N0cm9uZz5cIixcclxuICAgICAgICBpY29uOiBcImluZm9cIixcclxuICAgICAgICBodG1sOiBcIlBvdXIgdW5lIG1laWxsZXVyZSBleHDDqXJpZW5jZSB2ZXVpbGxleiBkw6lzYWN0aXZlciBBZGJsb2NrIG91IHRvdXQgYXV0cmUgYmxvcXVldXIgZGUgcHViXCIsXHJcbiAgICAgICAgc2hvd0Nsb3NlQnV0dG9uOiB0cnVlLFxyXG4gICAgICAgIHNob3dDYW5jZWxCdXR0b246IHRydWUsXHJcbiAgICAgICAgZm9jdXNDb25maXJtOiBmYWxzZSxcclxuICAgICAgICBjb25maXJtQnV0dG9uVGV4dDogJzxpIGNsYXNzPVwiZmEgZmEtdGh1bWJzLXVwXCI+PC9pPicsXHJcbiAgICAgICAgY29uZmlybUJ1dHRvbkFyaWFMYWJlbDogXCJUaHVtYnMgdXBcIixcclxuICAgICAgICBjYW5jZWxCdXR0b25UZXh0OiAnPGkgY2xhc3M9XCJmYSBmYS10aHVtYnMtZG93blwiPjwvaT4nLFxyXG4gICAgICAgIGNhbmNlbEJ1dHRvbkFyaWFMYWJlbDogXCJUaHVtYnMgZG93blwiLFxyXG4gICAgICAgIGN1c3RvbUNsYXNzOiB7XHJcbiAgICAgICAgICAgIGNvbnRhaW5lcjogJ2FkYmxvY2stY2xhc3MnLFxyXG4gICAgICAgICAgfVxyXG4gICAgICAgICAgfSk7XHJcbiAgICAgICAgfSk7XHJcbn0pOyJdLCJzb3VyY2VSb290IjoiIn0=