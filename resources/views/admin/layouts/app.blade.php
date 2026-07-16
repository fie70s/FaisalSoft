<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        FaisalSoft Admin
    </title>


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>


<body class="bg-gray-100">


<div class="min-h-screen">


    <!-- Sidebar -->

    @include('admin.partials.sidebar')



    <!-- Main Area -->

    <div class="mr-64">


        <!-- Topbar -->

        <header class="fixed top-0 right-64 left-0 h-20 bg-white shadow flex items-center justify-between px-6 z-50">

            @include('admin.partials.topbar')

        </header>



        <!-- Content -->

        <main class="pt-24 p-6 min-h-screen bg-gray-100">


            @yield('content')


        </main>


    </div>


</div>


</body>

</html>