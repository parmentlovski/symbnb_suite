import Swal from "sweetalert2";

$("document").ready(function() {
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
        cancelButtonAriaLabel: "Thumbs down"
    });
});