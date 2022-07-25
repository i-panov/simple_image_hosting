document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.modal-img').forEach(function(img) {
        img.addEventListener('click', function() {
            Swal.fire({
                imageUrl: img.src,
                showConfirmButton: false,
                showCloseButton: true,
            });
        });
    });
});
