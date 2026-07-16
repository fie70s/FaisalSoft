<aside class="fixed right-0 top-0 h-screen w-64 bg-gray-900 text-white z-50">


    <!-- Logo -->

    <div class="h-20 flex items-center justify-center border-b border-gray-800">

        <a href="{{ route('admin.dashboard') }}"
           class="text-2xl font-bold">

            FaisalSoft

        </a>

    </div>





    <!-- User -->

    <div class="p-5 border-b border-gray-800">

        <div class="flex items-center gap-3">

            <div class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center">

                <i class="fa-solid fa-user"></i>

            </div>


            <div>

                <h4 class="font-semibold">

                    {{ auth()->user()->name ?? 'Admin' }}

                </h4>


                <p class="text-sm text-gray-400">

                    Administrator

                </p>

            </div>

        </div>

    </div>







    <!-- Menu -->

    <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-220px)]">





        <!-- Dashboard -->

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-600 text-white">

            <i class="fa-solid fa-gauge"></i>

            Dashboard

        </a>







        <!-- Products -->

        <div x-data="{open:false}">

            <button
                @click="open=!open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-gray-800">


                <span class="flex items-center gap-3">

                    <i class="fa-solid fa-box"></i>

                    Products

                </span>


                <i class="fa-solid fa-chevron-down"></i>


            </button>





            <div x-show="open"
                 x-transition
                 class="mt-2 mr-6 space-y-2">


                <a href="{{ route('admin.products.index') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-800">

                    All Products

                </a>



                <a href="{{ route('admin.products.create') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-800">

                    Add Product

                </a>



            </div>

        </div>







        <!-- Hotspot -->

        <div x-data="{open:false}">


            <button
                @click="open=!open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-gray-800">


                <span class="flex items-center gap-3">

                    <i class="fa-solid fa-wifi"></i>

                    Hotspot

                </span>


                <i class="fa-solid fa-chevron-down"></i>


            </button>





            <div x-show="open"
                 x-transition
                 class="mt-2 mr-6 space-y-2">



                <a href="{{ route('admin.hotspot.users.index') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-800">

                    Users

                </a>


                <a href="#"
                   class="block px-3 py-2 rounded hover:bg-gray-800">

                    Profiles

                </a>



                <a href="#"
                   class="block px-3 py-2 rounded hover:bg-gray-800">

                    Cards

                </a>


                <a href="#"
                   class="block px-3 py-2 rounded hover:bg-gray-800">

                    Active Sessions

                </a>


            </div>


        </div>







        <!-- Orders -->

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800">


            <i class="fa-solid fa-cart-shopping"></i>

            Orders


        </a>






        <!-- Customers -->

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800">


            <i class="fa-solid fa-users"></i>

            Customers


        </a>






        <!-- Reports -->

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800">


            <i class="fa-solid fa-chart-line"></i>

            Reports


        </a>






        <!-- Settings -->

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800">


            <i class="fa-solid fa-gear"></i>

            Settings


        </a>



    </nav>









    <!-- Logout -->

    <div class="absolute bottom-0 w-full p-4 border-t border-gray-800">


        <form method="POST"
              action="{{ route('logout') }}">

            @csrf


            <button
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-600">


                <i class="fa-solid fa-right-from-bracket"></i>


                Logout


            </button>


        </form>


    </div>



</aside>