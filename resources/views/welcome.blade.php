<!doctype html >
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="{{ asset('asset/js/food-search.js') }} "></script>

    @vite('resources/css/app.css')

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .flex-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh; /* 100% of the viewport height */
            background: url('/asset/images/home-bg.jpg') no-repeat center center fixed;
            background-size: cover; /* or 'contain' depending on your preference */
        }

        .button-container {
            margin-bottom: 20px;
        }

        .button-container a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button-container a:hover {
            background-color: #45a049;
        }
    </style>
    <title>Snapp Food</title>

</head>
<body>
<div class="flex items-center justify-center h-screen flex-col flex-container">
    <div class="mb-8">
        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">
            ورود
        </a>
        <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            ثبت نام
        </a>
    </div>

    <div id="banners" class="flex items-center justify-center w-full h-64">
        <!-- The banner box will be displayed here -->
    </div>
</div>

<script>
    const banners = @json($banners);

    let currentBannerIndex = 0;

    function changeBanner() {
        const bannerElement = document.getElementById('banners');
        bannerElement.innerHTML = ''; // Clear existing content

        const bannerBox = document.createElement('div');
        bannerBox.classList.add('relative', 'border', 'p-4', 'rounded', 'bg-white', 'w-96', 'h-64', 'overflow-hidden', 'mx-auto');

        const imageUrl = banners[currentBannerIndex].image ? `/storage/${banners[currentBannerIndex].image.url}` : '';
        const imageElement = document.createElement('img');
        imageElement.src = imageUrl;
        imageElement.alt = 'Banner Image';
        imageElement.classList.add('w-full', 'h-full', 'object-cover', 'object-center', 'mb-2');

        const overlay = document.createElement('div');
        overlay.classList.add('absolute', 'inset-0', 'bg-black', 'opacity-50');

        const textContainer = document.createElement('div');
        textContainer.classList.add('absolute', 'inset-0', 'flex', 'flex-col', 'items-center', 'justify-center', 'text-white');

        const titleElement = document.createElement('h2');
        titleElement.textContent = banners[currentBannerIndex].title || ''; // Assuming there is a 'title' property in your banners
        titleElement.classList.add('text-xl', 'font-bold', 'mb-2');

        const textElement = document.createElement('p');
        textElement.textContent = banners[currentBannerIndex].text || '';
        textElement.classList.add('text-gray-300');

        bannerBox.appendChild(imageElement);
        bannerBox.appendChild(overlay);
        textContainer.appendChild(titleElement);
        textContainer.appendChild(textElement);
        bannerBox.appendChild(textContainer);
        bannerElement.appendChild(bannerBox);

        currentBannerIndex = (currentBannerIndex + 1) % banners.length;
    }

    setInterval(changeBanner, 5000);

    // Initial banner setup
    changeBanner();
</script>




</body>
