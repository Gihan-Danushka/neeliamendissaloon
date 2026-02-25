<aside
    class = "w-60 -translate-x-48 fixed transition transform ease-in-out duration-1000 z-50 flex h-screen bg-customPalette-darker ">
    <!-- open sidebar button -->
    <div
        class = "max-toolbar  px-1 translate-x-24 scale-x-0 w-full -right-6 transition transform ease-in duration-300 flex items-center justify-between border-4 border-white bg-customPalette-darker absolute top-2 rounded-full h-12">
        <div
            class="flex items-center space-x-3 group bg-customPalette-darker w-full py-1 rounded-full text-customPalette-darker">
            <div class= "transform ease-in-out duration-300 mx-5 text-[#f7f7f7]">
                Neeliya Mendis Salons
            </div>
        </div>
    </div>
    <div onclick="openNav()"
        class = "-right-6 transition transform ease-in-out duration-500 flex border-4 border-white bg-customPalette-darker hover:bg-customPalette-light absolute top-2 p-3 rounded-full text-white hover:rotate-45 hover:text-customPalette-darker">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={3} stroke="currentColor"
            class="w-6 h-6">
            <path strokeLinecap="round" strokeLinejoin="round"
                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
        </svg>
    </div>
    <!-- MAX SIDEBAR-->
    <div class="max hidden text-white mt-20 flex-col space-y-2 w-full h-[calc(100vh)]">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="hover:ml-4 w-full text-white hover:text-white hover:bg-customPalette-light/20 bg-customPalette-darker p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
            <img src="{{ asset('icons/dashboard.png') }}" alt="Dashboard" class="w-10 h-10">
            <div>Dashboard</div>
        </a>

        <!-- Services -->
        <a href="{{ route('services') }}"
            class="hover:ml-4 w-full text-white hover:text-white hover:bg-customPalette-light/20 bg-customPalette-darker p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
            <img src="{{ asset('icons/service.png') }}" alt="Service" class="w-10 h-10">
            <div>Services</div>
        </a>

        <!-- Client -->
        <a href="{{ route('client') }}"
            class="hover:ml-4 w-full text-white hover:text-white hover:bg-customPalette-light/20 bg-customPalette-darker p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
            <img src="{{ asset('icons/client.png') }}" alt="Client" class="w-10 h-10">
            <div>Client</div>
        </a>

         <!-- Booking -->
        <a href="{{ route('bookings.create') }}"
            class="hover:ml-4 w-full text-white hover:text-white hover:bg-customPalette-light/20 bg-customPalette-darker p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
            <img src="{{ asset('icons/calendar.png') }}" alt="Booking" class="w-10 h-10">
            <div>Booking</div>
        </a>
        
        <!-- Employee Management -->
        <a href="{{ route('staff.index') }}"
            class="hover:ml-4 w-full text-white hover:text-white hover:bg-customPalette-light/20 bg-customPalette-darker p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
            <img src="{{ asset('icons/emp.png') }}" alt="Employee" class="w-10 h-10">
            <div>Staff</div>
        </a>


        <!-- Payroll -->
        <a href="{{ route('payroll.index') }}"
            class="hover:ml-4 w-full text-white hover:text-white hover:bg-customPalette-light/20 bg-customPalette-darker p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
            <img src="{{ asset('icons/pay.png') }}" alt="Employee" class="w-10 h-10"> 
            <div>Payroll</div>
        </a>
        

        <!-- Invoice -->
        <a href="{{ route('invoice') }}"
            class="hover:ml-4 w-full text-white hover:text-white hover:bg-customPalette-light/20 bg-customPalette-darker p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
            <img src="{{ asset('icons/invoice.png') }}" alt="Invoice" class="w-10 h-10">
            <div>Invoice</div>
        </a>

        <!-- History -->
        <a href="{{ route('history') }}"
            class="hover:ml-4 w-full text-white hover:text-white hover:bg-customPalette-light/20 bg-customPalette-darker p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
            <img src="{{ asset('icons/history.png') }}" alt="History" class="w-10 h-10">
            <div>History</div>
        </a>

        <!-- Log Out -->
        <a href="{{ route('logout') }}">
            <div
                class="hover:ml-4 w-full text-white hover:text-white hover:bg-customPalette-light/20 bg-customPalette-darker p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
                <img src="{{ asset('icons/logout.png') }}" alt="Log Out" class="w-10 h-10">
                <div>Log Out</div>
            </div>
        </a>
    </div>


    <!-- MINI SIDEBAR-->

    <div class="mini mt-20 flex flex-col space-y-2 w-full h-[calc(100vh)]">
        <!-- Dashboard (Home Icon) -->
        <a href="{{ route('dashboard') }}" title="Dashboard"
            class="hover:ml-4 justify-end text-white hover:text-white hover:bg-customPalette-light/20 w-full bg-customPalette-darker p-3 rounded-full transform ease-in-out duration-300 flex items-center">
            <img src="{{ asset('icons/dashboard.png') }}" alt="Dashboard" class="w-8 h-8">
        </a>

        <!-- Services (Users Icon) -->
        <a href="{{ route('services') }}" title="Services"
            class="hover:ml-4 justify-end text-white hover:text-white hover:bg-customPalette-light/20 w-full bg-customPalette-darker p-3 rounded-full transform ease-in-out duration-300 flex items-center">
            <img src="{{ asset('icons/service.png') }}" alt="Services" class="w-8 h-8">
        </a>

        <!-- Client (Users Icon) -->
        <a href="{{ route('client') }}" title="Client"
            class="hover:ml-4 justify-end text-white hover:text-white hover:bg-customPalette-light/20 w-full bg-customPalette-darker p-3 rounded-full transform ease-in-out duration-300 flex items-center">
            <img src="{{ asset('icons/client.png') }}" alt="Client" class="w-8 h-8">
        </a>

        <!-- Booking (Booking Icon) -->
        <a href="{{ route('bookings.create') }}" title="Booking"
            class="hover:ml-4 justify-end text-white hover:text-white hover:bg-customPalette-light/20 w-full bg-customPalette-darker p-3 rounded-full transform ease-in-out duration-300 flex items-center">
            <img src="{{ asset('icons/calendar.png') }}" alt="Booking" class="w-8 h-8">
        </a>

        <!-- Employee Management (Staff Icon) -->
        <a href="{{ route('staff.index') }}" title="Staff Management"
            class="hover:ml-4 justify-end text-white hover:text-white hover:bg-customPalette-light/20 w-full bg-customPalette-darker p-3 rounded-full transform ease-in-out duration-300 flex items-center">
            <img src="{{ asset('icons/emp.png') }}" alt="Employee Management" class="w-8 h-8">
        </a>


        <!-- Payroll (Payroll Icon) -->
        <a href="{{ route('payroll.index') }}" title="Payroll"
            class="hover:ml-4 justify-end text-white hover:text-white hover:bg-customPalette-light/20 w-full bg-customPalette-darker p-3 rounded-full transform ease-in-out duration-300 flex items-center">
            <img src="{{ asset('icons/pay.png') }}" alt="Employee Management" class="w-8 h-8">
        </a>

        <!-- Invoice (Document Icon) -->
        <a href="{{ route('invoice') }}" title="Invoice"
            class="hover:ml-4 justify-end text-white hover:text-white hover:bg-customPalette-light/20 w-full bg-customPalette-darker p-3 rounded-full transform ease-in-out duration-300 flex items-center">
            <img src="{{ asset('icons/invoice.png') }}" alt="Invoice" class="w-8 h-8">
        </a>

        <!-- History (History Icon) -->
        <a href="{{ route('history') }}" title="History"
            class="hover:ml-4 justify-end text-white hover:text-white hover:bg-customPalette-light/20 w-full bg-customPalette-darker p-3 rounded-full transform ease-in-out duration-300 flex items-center">
            <img src="{{ asset('icons/history.png') }}" alt="History" class="w-8 h-8">
        </a>

        <!-- Log Out (Logout Icon) -->
        <a href="{{ route('logout') }}" title="Log Out">
            <div
                class="hover:ml-4 justify-end text-white hover:text-white hover:bg-customPalette-light/20 w-full bg-customPalette-darker p-3 rounded-full transform ease-in-out duration-300 flex">
                <img src="{{ asset('icons/logout.png') }}" alt="Log Out" class="w-8 h-8">
            </div>
        </a>
    </div>

</aside>
