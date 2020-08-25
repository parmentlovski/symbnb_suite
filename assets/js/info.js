import Swal from "sweetalert2";

$("document").ready(function() {

    Swal.fire({
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
        }),

        $(".fas").click(function(){

           Swal.fire({
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
            container: 'adblock-class',
          }
          });
        });
});