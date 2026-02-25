<div class = "fixed w-full z-30 flex bg-customPalette-darker p-2 items-center justify-center h-[57px] px-10">
    <!-- Google Fonts: Playfair Display -->
                <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">

                <style>
                    .font-playfair {
                        font-family: 'Playfair Display', serif;
                    }
                </style>
    <div

        class="logo ml-12 transform ease-in-out duration-500 flex-none h-full flex items-center justify-center text-white font-playfair display text-2xl font-bold">
        Neeliya Mendis Salons
    </div>
    <!-- SPACER -->
    <div class = "grow h-full flex items-center justify-center"></div>
    <div class = "flex-none h-full text-center flex items-center justify-center">

        <div class = "flex space-x-3 items-center px-3">
            <div class = "flex-none flex justify-center">
                <div class="w-8 h-8 flex border border-white rounded-full">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShta_GXR2xdnsxSzj_GTcJHcNykjVKrCBrZ9qouUl0usuJWG2Rpr_PbTDu3sA9auNUH64&usqp=CAU"
                        alt="profile" class="shadow rounded-full object-cover" />
                </div>
            </div>

            @if (Auth::check())
                <div class="hidden md:block text-sm md:text-md text-white">{{ Auth::user()->name }}</div>
            @endif

        </div>

    </div>
</div>
