(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["js/info"],{

/***/ "./assets/js/info.js":
/*!***************************!*\
  !*** ./assets/js/info.js ***!
  \***************************/
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

},[["./assets/js/info.js","runtime","vendors~js/alert~js/info"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvaW5mby5qcyJdLCJuYW1lcyI6WyIkIiwicmVhZHkiLCJTd2FsIiwiZmlyZSIsIndpZHRoIiwiaGVpZ2h0QXV0byIsInBvc2l0aW9uIiwiYmFja2dyb3VuZCIsInRleHQiLCJjb25maXJtQnV0dG9uVGV4dCIsImN1c3RvbUNsYXNzIiwiY29udGFpbmVyIiwicG9wdXAiLCJoZWFkZXIiLCJ0aXRsZSIsImNsb3NlQnV0dG9uIiwiaWNvbiIsImltYWdlIiwiY29udGVudCIsImlucHV0IiwiYWN0aW9ucyIsImNvbmZpcm1CdXR0b24iLCJjYW5jZWxCdXR0b24iLCJmb290ZXIiLCJjbGljayIsImh0bWwiLCJzaG93Q2xvc2VCdXR0b24iLCJzaG93Q2FuY2VsQnV0dG9uIiwiZm9jdXNDb25maXJtIiwiY29uZmlybUJ1dHRvbkFyaWFMYWJlbCIsImNhbmNlbEJ1dHRvblRleHQiLCJjYW5jZWxCdXR0b25BcmlhTGFiZWwiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUVBQSxDQUFDLENBQUMsVUFBRCxDQUFELENBQWNDLEtBQWQsQ0FBb0IsWUFBVztBQUUzQkMsb0RBQUksQ0FBQ0MsSUFBTCxDQUFVO0FBQ05DLFNBQUssRUFBRSxNQUREO0FBRU5DLGNBQVUsRUFBRSxPQUZOO0FBR05DLFlBQVEsRUFBRSxRQUhKO0FBSU5DLGNBQVUsRUFBRSxTQUpOO0FBS05DLFFBQUksRUFBRSw4S0FMQTtBQU1OQyxxQkFBaUIsRUFBRSxtRUFOYjtBQU9OQyxlQUFXLEVBQUU7QUFDVEMsZUFBUyxFQUFFLGlCQURGO0FBRVRDLFdBQUssRUFBRSxhQUZFO0FBR1RDLFlBQU0sRUFBRSxjQUhDO0FBSVRDLFdBQUssRUFBRSxhQUpFO0FBS1RDLGlCQUFXLEVBQUUsb0JBTEo7QUFNVEMsVUFBSSxFQUFFLFlBTkc7QUFPVEMsV0FBSyxFQUFFLGFBUEU7QUFRVEMsYUFBTyxFQUFFLGVBUkE7QUFTVEMsV0FBSyxFQUFFLGFBVEU7QUFVVEMsYUFBTyxFQUFFLGlCQVZBO0FBV1RDLG1CQUFhLEVBQUUsc0JBWE47QUFZVEMsa0JBQVksRUFBRSxxQkFaTDtBQWFUQyxZQUFNLEVBQUU7QUFiQztBQVBQLEdBQVYsR0F3Qkl2QixDQUFDLENBQUMsTUFBRCxDQUFELENBQVV3QixLQUFWLENBQWdCLFlBQVU7QUFFdkJ0QixzREFBSSxDQUFDQyxJQUFMLENBQVU7QUFDYlcsV0FBSyxFQUFFLDJDQURNO0FBRWJFLFVBQUksRUFBRSxNQUZPO0FBR2JTLFVBQUksRUFBRSx5RkFITztBQUliQyxxQkFBZSxFQUFFLElBSko7QUFLYkMsc0JBQWdCLEVBQUUsSUFMTDtBQU1iQyxrQkFBWSxFQUFFLEtBTkQ7QUFPYm5CLHVCQUFpQixFQUFFLGlDQVBOO0FBUWJvQiw0QkFBc0IsRUFBRSxXQVJYO0FBU2JDLHNCQUFnQixFQUFFLG1DQVRMO0FBVWJDLDJCQUFxQixFQUFFLGFBVlY7QUFXYnJCLGlCQUFXLEVBQUU7QUFDVEMsaUJBQVMsRUFBRTtBQURGO0FBWEEsS0FBVjtBQWVGLEdBakJELENBeEJKO0FBMENILENBNUNELEUiLCJmaWxlIjoianMvaW5mby5qcyIsInNvdXJjZXNDb250ZW50IjpbImltcG9ydCBTd2FsIGZyb20gXCJzd2VldGFsZXJ0MlwiO1xuXG4kKFwiZG9jdW1lbnRcIikucmVhZHkoZnVuY3Rpb24oKSB7XG5cbiAgICBTd2FsLmZpcmUoe1xuICAgICAgICB3aWR0aDogXCIxMDAlXCIsXG4gICAgICAgIGhlaWdodEF1dG86IFwiZmFsc2VcIixcbiAgICAgICAgcG9zaXRpb246ICdib3R0b20nLFxuICAgICAgICBiYWNrZ3JvdW5kOiAnI0MwQjI5MycsXG4gICAgICAgIHRleHQ6ICdOb3VzIHV0aWxpc29ucyBkZXMgY29va2llcyBwb3VyIHZvdXMgZ2FyYW50aXIgbGEgbWVpbGxldXJlIGV4cMOpcmllbmNlIHN1ciBub3RyZSBzaXRlIHdlYi4gU2kgdm91cyBjb250aW51ZXogw6AgdXRpbGlzZXIgY2Ugc2l0ZSwgbm91cyBzdXBwb3Nlcm9ucyBxdWUgdm91cyBlbiDDqnRlcyBzYXRpc2ZhaXQuJyxcbiAgICAgICAgY29uZmlybUJ1dHRvblRleHQ6ICc8aSBjbGFzcz1cImZhcyBmYS1jaGVjayBodnItaWNvblwiIHN0eWxlPVwicGFkZGluZy1yaWdodDoxcHhcIj48L2k+T2snLFxuICAgICAgICBjdXN0b21DbGFzczoge1xuICAgICAgICAgICAgY29udGFpbmVyOiAnY29udGFpbmVyLWNsYXNzJyxcbiAgICAgICAgICAgIHBvcHVwOiAncG9wdXAtY2xhc3MnLFxuICAgICAgICAgICAgaGVhZGVyOiAnaGVhZGVyLWNsYXNzJyxcbiAgICAgICAgICAgIHRpdGxlOiAndGl0bGUtY2xhc3MnLFxuICAgICAgICAgICAgY2xvc2VCdXR0b246ICdjbG9zZS1idXR0b24tY2xhc3MnLFxuICAgICAgICAgICAgaWNvbjogJ2ljb24tY2xhc3MnLFxuICAgICAgICAgICAgaW1hZ2U6ICdpbWFnZS1jbGFzcycsXG4gICAgICAgICAgICBjb250ZW50OiAnY29udGVudC1jbGFzcycsXG4gICAgICAgICAgICBpbnB1dDogJ2lucHV0LWNsYXNzJyxcbiAgICAgICAgICAgIGFjdGlvbnM6ICdodnItaWNvbi1yb3RhdGUnLFxuICAgICAgICAgICAgY29uZmlybUJ1dHRvbjogJ2NvbmZpcm0tYnV0dG9uLWNsYXNzJyxcbiAgICAgICAgICAgIGNhbmNlbEJ1dHRvbjogJ2NhbmNlbC1idXR0b24tY2xhc3MnLFxuICAgICAgICAgICAgZm9vdGVyOiAnZm9vdGVyLWNsYXNzJ1xuICAgICAgICAgIH1cbiAgICAgICAgfSksXG5cbiAgICAgICAgJChcIi5mYXNcIikuY2xpY2soZnVuY3Rpb24oKXtcblxuICAgICAgICAgICBTd2FsLmZpcmUoe1xuICAgICAgICB0aXRsZTogXCI8c3Ryb25nPkFsZXJ0ZSBCbG9xdWV1ciBkZSBwdWIgITwvc3Ryb25nPlwiLFxuICAgICAgICBpY29uOiBcImluZm9cIixcbiAgICAgICAgaHRtbDogXCJQb3VyIHVuZSBtZWlsbGV1cmUgZXhww6lyaWVuY2UgdmV1aWxsZXogZMOpc2FjdGl2ZXIgQWRibG9jayBvdSB0b3V0IGF1dHJlIGJsb3F1ZXVyIGRlIHB1YlwiLFxuICAgICAgICBzaG93Q2xvc2VCdXR0b246IHRydWUsXG4gICAgICAgIHNob3dDYW5jZWxCdXR0b246IHRydWUsXG4gICAgICAgIGZvY3VzQ29uZmlybTogZmFsc2UsXG4gICAgICAgIGNvbmZpcm1CdXR0b25UZXh0OiAnPGkgY2xhc3M9XCJmYSBmYS10aHVtYnMtdXBcIj48L2k+JyxcbiAgICAgICAgY29uZmlybUJ1dHRvbkFyaWFMYWJlbDogXCJUaHVtYnMgdXBcIixcbiAgICAgICAgY2FuY2VsQnV0dG9uVGV4dDogJzxpIGNsYXNzPVwiZmEgZmEtdGh1bWJzLWRvd25cIj48L2k+JyxcbiAgICAgICAgY2FuY2VsQnV0dG9uQXJpYUxhYmVsOiBcIlRodW1icyBkb3duXCIsXG4gICAgICAgIGN1c3RvbUNsYXNzOiB7XG4gICAgICAgICAgICBjb250YWluZXI6ICdhZGJsb2NrLWNsYXNzJyxcbiAgICAgICAgICB9XG4gICAgICAgICAgfSk7XG4gICAgICAgIH0pO1xufSk7Il0sInNvdXJjZVJvb3QiOiIifQ==