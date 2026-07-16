<header class="fixed top-0 right-0 left-0 mr-64 h-20 bg-white shadow-sm z-20 flex items-center justify-between px-6">


    <!-- Page Info -->

    <div>

        <h1 class="text-xl font-bold text-gray-800">

            Admin Dashboard

        </h1>


        <p class="text-sm text-gray-500">

            Welcome back, {{ auth()->user()->name ?? 'Admin' }}

        </p>


    </div>





    <!-- Actions -->

    <div class="flex items-center gap-6">



        <!-- Notification -->

        <button class="relative text-gray-600 hover:text-blue-600 transition">


            <i class="fa-solid fa-bell text-xl"></i>


            <span
            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs 
            w-5 h-5 rounded-full flex items-center justify-center">


                3


            </span>


        </button>






        <!-- User Dropdown -->

        <div x-data="{open:false}" class="relative">


            <button
            @click="open=!open"
            class="flex items-center gap-3 focus:outline-none">


                <div
                class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">


                    <i class="fa-solid fa-user"></i>


                </div>




                <div class="hidden md:block text-right">


                    <p class="text-sm font-semibold text-gray-800">


                        {{ auth()->user()->name ?? 'Admin' }}


                    </p>



                    <span class="text-xs text-gray-500">


                        Administrator


                    </span>


                </div>



                <i class="fa-solid fa-chevron-down text-xs text-gray-500"></i>


            </button>





            <!-- Dropdown -->

            <div
            x-show="open"
            @click.outside="open=false"
            x-transition
            class="absolute left-0 mt-3 w-48 bg-white rounded-lg shadow-lg border py-2">


                <a href="#"
                   class="block px-4 py-2 text-sm hover:bg-gray-100">

                    Profile

                </a>


                <a href="#"
                   class="block px-4 py-2 text-sm hover:bg-gray-100">

                    Settings

                </a>



                <form method="POST" action="{{ route('logout') }}">


                    @csrf


                    <button
                    class="w-full text-right px-4 py-2 text-sm hover:bg-red-50 text-red-600">


                        Logout


                    </button>


                </form>


            </div>


        </div>


    </div>


</header>