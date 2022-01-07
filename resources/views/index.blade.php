<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Load the jQuery JS library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script type="text/javascript" rel="javascript" src="{{ asset('js/index.js') }}"></script>
        <script type="text/javascript" rel="javascript" src="{{ asset('js/cart.js') }}"></script>
        <script type="text/javascript" rel="javascript" src="{{ asset('js/login.js') }}"></script>
        <script type="text/javascript" rel="javascript" src="{{ asset('js/products.js') }}"></script>
        <script type="text/javascript" rel="javascript" src="{{ asset('js/product.js') }}"></script>
        <script type="text/javascript" rel="javascript" src="{{ asset('js/orders.js') }}"></script>
        <script type="text/javascript" rel="javascript" src="{{ asset('js/order.js') }}"></script>
        <script type="text/javascript" rel="javascript" src="{{ asset('js/translation.js') }}"></script>
        <script type="text/javascript" rel="javascript" src="{{ asset('js/table.js') }}"></script>

        <script>
            var translations = {!! Cache::get('translations') !!};
        </script>

        <!-- Custom JS script -->
        <script type="text/javascript">
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                /**
                 * Submit checkout form
                 */
                $('.checkout').on('submit', function (e) {
                    e.preventDefault();

                    let name = $('#name').val();
                    let contacts = $('#contacts').val();
                    let comments = $('#comments').val();

                    $.ajax({
                        type: 'post',
                        url: '{{ route('checkout') }}',
                        dataType: 'json',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'name': name,
                            'contacts': contacts,
                            'comments': comments,
                        },
                        success: function () {
                            window.location.hash = "#";
                        },
                        error: function (response) {
                            var res = response.responseJSON.errors;
                            if (res.name) {
                                $('#nameErrorMsg').text(res.name);
                            }
                            if (res.contacts) {
                                $('#contactsErrorMsg').text(res.contacts);
                            }
                            if (res.comments) {
                                $('#commentsErrorMsg').text(res.comments);
                            }
                        }
                    });
                });

                /**
                 * Submit login form
                 */
                $('.login-form').on('submit', function (e) {
                    e.preventDefault();

                    let username = $('#username').val();
                    let password = $('#password').val();

                    $.ajax({
                        type: 'post',
                        url: '{{ route('login') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'username': username,
                            'password': password,
                        },
                        dataType: 'json',
                        success: function (response) {
                            window.location.hash = '#products';
                        },
                        error: function (response) {
                            var res = response.responseJSON.errors;
                            if (res.username) {
                                $('#usernameErrorMsg').text(res.username);
                            }
                            if (res.password) {
                                $('#passwordErrorMsg').text(res.password);
                            }
                        }
                    });
                });

                /**
                 * Submit add/edit product form
                 */
                $('.product-form').on('submit', function (e) {
                    e.preventDefault();

                    let title = $('#title').val();
                    let description = $('#description').val();
                    let price = $('#price').val();
                    let fileToUpload = $('#fileToUpload')[0].files[0];
                    let id = window.location.hash.split('/')[1] ? window.location.hash.split('/')[1] : 0;

                    var myForm = new FormData();
                    myForm.append('title', title);
                    myForm.append('description', description);
                    myForm.append('price', price);
                    myForm.append('fileToUpload', fileToUpload);
                    myForm.append('id', id);

                    $.ajax({
                        type: 'post',
                        url: '{{ route('store') }}',
                        processData: false,
                        contentType: false,
                        enctype: 'multipart/form-data',
                        data: myForm,
                        dataType: 'json',
                        success: function () {
                            window.location.hash = '#products';
                        },
                        error: function (response) {
                            var res = response.responseJSON.errors;
                            if (res.title) {
                                $('#titleErrorMsg').text(res.title);
                            }
                            if (res.description) {
                                $('#descErrorMsg').text(res.description);
                            }
                            if (res.price) {
                                $('#priceErrorMsg').text(res.price);
                            }
                            if (res.fileToUpload) {
                                $('#fileErrorMsg').text(res.fileToUpload);
                            }
                        },
                    });
                });

                /**
                 * URL hash change handler
                 */
                window.onhashchange = function () {
                    // First hide all the pages
                    $('.page').hide();
                    switch (window.location.hash) {
                        /**
                         * Case for cart page
                         */
                        case '#cart':
                            $('.page').hide();
                            // Show the cart page
                            $('.cart').show();
                            // Load the cart products from the server
                            $.ajax({
                                url: '{{ route('show.cart') }}',
                                dataType: 'json',
                                success: function (response) {
                                    // Render the products in the cart list
                                    $('.cart .list').html(renderCart(response));
                                }
                            });
                            break;
                        /**
                         * Case for removing products from cart
                         */
                        case (window.location.hash.match(/#cart\/\d+/) || {}).input:
                            $('.page').hide();
                            // Show the cart page
                            $('.cart').show();
                            $.ajax({
                                type: 'post',
                                url: '{{ route('remove.from.cart') }}',
                                data: {'id': window.location.hash.split('/')[1]},
                                dataType: 'json',
                                success: function () {
                                    window.location.hash = "#cart";
                                },
                            });
                            break;
                        /**
                         * Case for adding products to cart
                         */
                        case (window.location.hash.match(/#\d+/) || {}).input:
                            $('.page').hide();
                            // Show the cart page
                            $('.index').show();
                            $.ajax({
                                type: 'post',
                                url: '{{ route('add.to.cart') }}',
                                data: {'id': window.location.hash.split('#')[1]},
                                dataType: 'json',
                                success: function () {
                                    window.location.hash = "#";
                                },
                            });
                            break;
                        /**
                         * Login case
                         */
                        case '#login':
                            $('.page').hide();
                            $('.login').show();
                            $.ajax('{{ route('login.show') }}', {
                                success: function () {
                                    $('.login .login-form').html(login());
                                }
                            });
                            break;
                        /**
                         * Logout case
                         */
                        case '#logout':
                            $('.page').hide();
                            $.ajax({
                                url: '{{route('logout')}}',
                                type: 'post',
                                dataType: 'json',
                                success: function () {
                                    window.location.hash = '#';
                                }
                            });
                        /**
                         * Case for products page
                         */
                        case '#products':
                            $('.page').hide();
                            $('.products').show();
                            // Load the products from the server
                            $.ajax({
                                url: '{{ route('products') }}',
                                dataType: 'json',
                                success: function (response) {
                                    // Render the products in the index list
                                    $('.products .list').html(renderProducts(response));
                                },
                                error: function () {
                                    window.location.hash = '#login';
                                }
                            });
                            break;
                        /**
                         * Case for removing products
                         */
                        case (window.location.hash.match(/#products\/\d+/) || {}).input:
                            $('.page').hide();
                            $('.products').show();
                            $.ajax({
                                type: 'post',
                                url: '{{ route('remove.product') }}',
                                data: {'id': window.location.hash.split('/')[1]},
                                dataType: 'json',
                                success: function (response) {
                                    window.location.hash = "#products";
                                },
                                error: function () {
                                    window.location.hash = '#login';
                                }
                            });
                            break;
                        /**
                         * Case for product form-add
                         */
                        case '#product':
                            $('.page').hide();
                            $('.product').show();
                            $.ajax({
                                type: 'get',
                                url: '{{ route('show.product.form') }}',
                                data: {'id': 0},
                                dataType: 'json',
                                success: function () {
                                    $('.product .product-form').html(renderProductForm());
                                },
                                error: function () {
                                    window.location.hash = '#login';
                                }
                            });
                            break;
                        /**
                         * Case for product form-edit
                         */
                        case (window.location.hash.match(/#product\/\d+/) || {}).input:
                            $('.page').hide();
                            $('.product').show();
                            $.ajax({
                                type: 'get',
                                url: '{{ route('show.product.form') }}',
                                data: {'id': window.location.hash.split('/')[1]},
                                dataType: 'json',
                                success: function () {
                                    $('.product .product-form').html(renderProductForm());
                                },
                                error: function () {
                                    window.location.hash = '#login';
                                }
                            });
                            break;
                        /**
                         * Case for all orders
                         */
                        case '#orders':
                            // Hide all pages
                            $('.page').hide();
                            // Show the orders page
                            $('.orders').show();
                            // Load the orders form the server
                            $.ajax({
                                url: '{{ route('orders') }}',
                                dataType: 'json',
                                success: function (response) {
                                    // Render the orders in the orders list
                                    $('.orders .list').html(renderOrders(response));
                                },
                                error: function () {
                                    window.location.hash = '#login';
                                }
                            });
                            break;
                        /**
                         * Case for an order
                         */
                        case (window.location.hash.match(/#order\/\d+/) || {}).input:
                            // Hide all pages
                            $('.page').hide();
                            // Show the orders page
                            $('.order').show();
                            // Load the order form the server
                            let id = window.location.hash.split('/')[1];
                            $.ajax({
                                url: '{{ route('order') }}',
                                data: {'id': id},
                                dataType: 'json',
                                success: function (response) {
                                    // Render the orders in the orders list
                                    $('.order .order-container').html(renderOrder(response));
                                },
                                error: function () {
                                    window.location.replace('#login');
                                }
                            });
                            break;
                        default:
                            // If all else fails, always default to index
                            $('.page').hide();
                            // Show the index page
                            $('.index').show();
                            // Load the index products from the server
                            $.ajax({
                                url: '{{ route('index') }}',
                                dataType: 'json',
                                success: function (response) {
                                    // Render the products in the index list
                                    $('.index .list').html(renderList(response));
                                }
                            });
                            break;
                    }
                }
                window.onhashchange();
            });
        </script>

    </head>
    <body>
        <!-- The index page -->
        <div class="page index">
            <!-- The index element where the products list is rendered -->
            <table class="list"></table>

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
</html>
