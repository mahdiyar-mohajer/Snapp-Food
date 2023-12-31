<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!---Custom CSS File--->
    <link rel="stylesheet" href="asset/css/style.css">
    <script src="{{ mix('resource/js/auto-dismiss.js') }}"></script>

    <title>@yield('title')</title>
</head>
<body>
<div class="container">
@yield('content')

</div>
<script>
    setTimeout(function () {
        document.querySelectorAll('.auto-dismiss').forEach(function (message) {
            message.classList.add('fade-out'); // Add a class for fade-out effect
            setTimeout(function () {
                message.style.display = 'none';
            }, 500); // Delayed hiding (half a second)
        });
    }, 5000); // 5 seconds
</script>

</body>
</html>
