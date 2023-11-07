document.addEventListener("DOMContentLoaded", function () {
    var messages = document.querySelectorAll('.auto-dismiss');

    messages.forEach(function (message) {
        setTimeout(function () {
            message.style.display = 'none';
        }, 10000); // 10 seconds
    });
});
