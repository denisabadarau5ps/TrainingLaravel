<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Load the jQuery JS library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script>
            var translations = {!! Cache::get('translations') !!};
        </script>

    </head>
    <body>
        <!-- The index page -->
        <div class="page index">
            <!-- The index element where the products list is rendered -->
            <table class="list paginated"></table>

            <!-- A link to go to the cart by changing the hash -->
            <div class="button-container">
                <a href="#cart" class="button">@lang('buttons.cart')</a>
            </div>
        </div>

        <!-- The cart page -->
        <div class="page cart">
            <!-- The cart element where the products list is rendered -->
            <table class="list"></table>

            <!-- The checkout form for the customer-->
            <div class="checkout-details-container">
                <form class="checkout"></form>
            </div>

            <!-- A link to go to the index by changing the hash -->
            <div class="button-container">
                <a href="#" class="button">@lang('buttons.index')</a>
            </div>
        </div>

        <!-- Login page -->
        <div class="page login login-container">
            <form class="login-form"></form>
        </div>

        <!-- The products page -->
        <div class="page products">
            <!-- The index element where the products list is rendered -->
            <table class="list"></table>

            <!-- A link to go to the add product by changing the hash -->
            <div class="button-container">
                <a href="#product" class="button">@lang('buttons.add')</a>
            </div>
            <br>
            <div class="button-container">
                <a href="#logout" class="button">@lang('buttons.logout')</a>
            </div>
        </div>

        <!-- The product form page -->
        <div class="page product">
            <div class="login-container">
                <form class="product-form"></form>
                <a href="#products" class="button-products">@lang('buttons.products')</a>
            </div>
        </div>

        <!-- The orders page -->
        <div class="page orders">
            <!-- The index element where the products list is rendered -->
            <table class="list"></table>
        </div>

        <!-- The single order page -->
        <div class="page order">
            <div class="order-container"></div>
        </div>
    </body>
    <script type="text/javascript" rel="javascript" src="{{ asset('js/routing.js') }}"></script>
    <script type="text/javascript" rel="javascript" src="{{ asset('js/common.js') }}"></script>
    <script type="text/javascript" rel="javascript" src="{{ asset('js/index.js') }}"></script>
    <script type="text/javascript" rel="javascript" src="{{ asset('js/cart.js') }}"></script>
    <script type="text/javascript" rel="javascript" src="{{ asset('js/login.js') }}"></script>
    <script type="text/javascript" rel="javascript" src="{{ asset('js/products.js') }}"></script>
    <script type="text/javascript" rel="javascript" src="{{ asset('js/product.js') }}"></script>
    <script type="text/javascript" rel="javascript" src="{{ asset('js/orders.js') }}"></script>
    <script type="text/javascript" rel="javascript" src="{{ asset('js/order.js') }}"></script>

</html>
