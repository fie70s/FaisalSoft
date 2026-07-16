<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>
        Admin Panel
    </title>


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


</head>



<body class="bg-gray-100">


    @include('admin.partials.sidebar')


    @include('admin.partials.topbar')



    <main class="mr-64 pt-24 p-6 min-h-screen bg-gray-100">


        @yield('content')


    </main>



</body>


</html>