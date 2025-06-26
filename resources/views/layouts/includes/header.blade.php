<header id="main-header" class="fullwidth border-b">
    <nav class=" navbar md:py-3 p-0 border-b border-gray-200" style="background-color:white">
        <div class="container">
            <div class="collapse navbar-collapse" id="fullnav">
                <!-- Mobile Offcanvas -->
                <div class="mr-2 offcanvas-wrapper md:hidden">
                    <span id="offcanvas-toggler">
                        <i class="bi bi-list" style="color:black"></i>
                    </span>
                </div>

                <!-- Logo -->
                <div class="logo-wrap">
                    <a class="navbar-brand" href="/">
                        <img class="img-fluid" src="assets/images/logo.png" style="height:px" alt="Ek Online BD">

                    </a>
                </div>

                <!-- Search -->
                <div id="search-box" class="search-box relative hidden md:block  mx-5" data-tip="Search Products">
                    <div class="pure-form" data-httpPath="/">
                        <div class="input-group">
                            <input type="text" autocomplete="off" name="searchproduct" id="search"
                                class="input input-primary  text-black w-full" placeholder="Search product .."
                                aria-label="searchproduct" aria-describedby="searchproduct" required="">
                            <button class="btn btn-primary -ml-4 !h-[36px] md:h-full"><i
                                    class="bi bi-search md:text-lg"></i></button>
                        </div>
                    </div>
                    <div id="match-list"></div>
                </div>

                <!-- Others -->
                <div class="others-options flex align-items-center items-center ml-auto mr-3">
                    <!-- Search Icon -->
                    <div id="search-toggler" class="search-icon-wrap block md:hidden ml-1">
                        <i class="bi bi-search md:text-2xl text-lg text-black cursor-pointer" style="color:black"></i>
                    </div>


                    <!-- Call now -->

                    <div class="call-now relative tooltip md:border md:text-primary text-primary px-3 py-1 rounded-md"
                        data-tip="Call Us">
                        <a href="tel:01516137894" class="stretched-link"></a>
                        <div class="flex items-center black">

                            <div class="md:mr-3">
                                <i class="bi bi-telephone md:text-xl text-lg" style="color: black;"></i>
                            </div>

                            <div class="text-lg md:block hidden " style="color: black;">
                                <strong style="color: black;">01516137894</strong>
                            </div>
                        </div>
                    </div>



                    <!-- Login -->
                    <div class="login-area">
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" class="m-1 text-black cursor-pointer flex items-center">
                                <i class="bi bi-person md:text-2xl text-xl text-black cursor-pointer mr-2"
                                    style="color:black"></i>
                                <span class=" md:block hidden" style="color:black">Login / Sign In
                                    <i class="bi bi-chevron-down" style="color:black"> </i>
                                </span>
                            </div>
                            <div tabindex="0"
                                class="md:p-6 p-3 shadow-lg menu dropdown-content bg-base-100 rounded-box w-[280px] md:w-80  text-black z-50">
                                <h2 class="text-center text-xl font-bold text-black mb-3 w-full">Login to my account
                                </h2>
                                <form method="POST" action="#" class="pure-form small-form">
                                    <div class="form-control mb-4">
                                        <label class="mb-1" for="username">Mobile Number</label>
                                        <input type="text" name="username" maxlength="11"
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            class="input input-bordered w-full" id="username"
                                            placeholder="017847093..." required>
                                    </div>
                                    <div class="form-control mb-4">
                                        <label class="mb-1" for="password">Password</label>
                                        <input type="password" name="password" class="input input-bordered w-full"
                                            id="password" placeholder="*****" required>
                                    </div>
                                    <button type="submit" class="w-full btn btn-success text-white">Login</button>
                                </form>
                                <p class="mt-3 text-sm">New customer?
                                    <a href="users/register.html" class="text-black">Create your
                                        account</a>
                                </p>
                                <p class="text-sm">Lost password? <a href="users/forgetPassword.html"
                                        class="text-black">Reset
                                        account</a>
                                </p>
                                <h3 class="mt-3 text-center">Order Tracking</h3>
                                <form method="get" action="#">
                                    <div class="form-control mb-2">
                                        <input type="text" name="orderid" maxlength="11"
                                            class="input input-bordered w-full" id="orderid"
                                            placeholder="Mobile Number or Order ID" required>
                                    </div>
                                    <button type="submit" class="w-full btn btn-success text-white"
                                        style="height: 2rem; min-height: 2rem;">Check</button>
                                </form>
                            </div>
                        </div>

                    </div>

                    <!-- Cart Menu -->

                    <div class="cart-menu-wrap">
                        <a href="products.html" class="flex text-black hover:text-black items-center">
                            <span id="cart-menu" class="relative">

                                <i class="bi bi-cart3 md:text-2xl text-lg" style="color:black"></i>
                                <span class="cart-notification bg-primary text-white"
                                    style="color: white; background-color: black;">
                                    0
                                </span>
                            </span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <!-- menu -->
    <div class="mainmenu-wrap">
        <div class="container">
            <div class="flex">
                <div class="product-categories-menu">

                    <nav class="wh-catmenu-layout text-md lg:text-sm font-bold hidden md:flex flex-1 items-center uppercase tracking-wide "
                        role="navigation">
                        <ul>

                            <li class="menu-item">
                                <a href="/" title="Home">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z" />
                                        <path
                                            d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z" />
                                    </svg>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('categories') }}">
                                    Premium Light
                                </a>
                                <!-- Toggle Icon -->
                                <!-- child -->

                            </li>


                            <li class="menu-item">
                                <a href="{{ route('categories') }}">
                                    Metal Light
                                </a>
                                <!-- Toggle Icon -->

                                <!-- child -->
                            </li>

                            <li class="menu-item">
                                <a href="{{ route('categories') }}">
                                    Humidifier
                                </a>
                                <!-- Toggle Icon -->

                                <!-- child -->
                            </li>


                            <li class="menu-item">
                                <a href="{{ route('categories') }}">
                                    Table Lamps
                                </a>
                                <!-- Toggle Icon -->

                                <!-- child -->
                            </li>


                            <li class="menu-item">
                                <a href="{{ route('categories') }}">
                                    String Light
                                </a>
                                <!-- Toggle Icon -->

                                <!-- child -->
                            </li>


                            <li class="menu-item">

                                <a href="{{ route('categories') }}">
                                    Light
                                </a>
                                <!-- Toggle Icon -->

                                <!-- child -->

                            </li>

                            <li class="menu-item">
                                <a href="{{ route('categories') }}">
                                    COSMETICS
                                </a>
                                <!-- Toggle Icon -->

                                <!-- child -->
                            </li>


                            <li class="menu-item">
                                <a href="{{ route('categories') }}">
                                    Combo Offer
                                </a>
                                <!-- Toggle Icon -->
                                <!-- child -->
                            </li>


                            <!-- related Pages -->

                            <li class="menu-item has-child">
                                <a href="#" title="Home">Pages</a>
                                <span class="toggle-icon"><i class="bi bi-chevron-down text-black"></i></span>
                                <ul class="menu-child">


                                    <li class="menu-item">
                                        <a href="{{ route('policies') }}">Returns &amp; Refunds
                                            Policy</a>
                                    </li>

                                    <li class="menu-item">
                                        <a href="{{ route('conditions') }}">Terms &amp; Condition</a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>

</header>
<div id="offcanvas-wrap">
    <div class="">
        <div class="offcanvas-close absolute top-3 right-3"><i class="bi bi-x-circle text-2xl"></i></div>
        <div class="categories-dropdown">
            <!-- Category Menu -->

            <nav id="wh-catmenu" class="wh-catmenu-wrapper" role="navigation">
                <ul>
                    <li class="menu-item">
                        <a href="/" title="Home">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                                <path
                                    d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z" />
                                <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z" />
                            </svg>
                        </a>
                    </li>

                    </li>

                    <li class="menu-item">

                        <a href="{{ route('categories') }}"> Premium Light </a>
                        <!-- Toggle Icon -->

                        <!-- child -->

                    </li>

                    </li>

                    <li class="menu-item">

                        <a href="{{ route('categories') }}"> Metal Light </a>
                        <!-- Toggle Icon -->

                        <!-- child -->

                    </li>

                    </li>

                    <li class="menu-item">

                        <a href="{{ route('categories') }}"> Humidifier </a>
                        <!-- Toggle Icon -->

                        <!-- child -->

                    </li>

                    </li>

                    <li class="menu-item">

                        <a href="{{ route('categories') }}"> Table Lamps </a>
                        <!-- Toggle Icon -->

                        <!-- child -->

                    </li>

                    </li>

                    <li class="menu-item">

                        <a href="{{ route('categories') }}"> String Light </a>
                        <!-- Toggle Icon -->

                        <!-- child -->

                    </li>

                    </li>

                    <li class="menu-item">

                        <a href="{{ route('categories') }}"> Light </a>
                        <!-- Toggle Icon -->

                        <!-- child -->

                    </li>

                    </li>

                    <li class="menu-item">

                        <a href="{{ route('categories') }}"> COSMETICS </a>
                        <!-- Toggle Icon -->

                        <!-- child -->

                    </li>

                    </li>

                    <li class="menu-item">

                        <a href="{{ route('categories') }}"> Combo Offer </a>
                        <!-- Toggle Icon -->

                        <!-- child -->

                    </li>

                </ul>
            </nav>

        </div>
    </div>
</div>
