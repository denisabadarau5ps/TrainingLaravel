<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Load the jQuery JS library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
                $('.checkout').on('submit', function(e){
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
                            var res = response.responseJSON;
                            $('#nameErrorMsg').text(res.errors.name);
                            $('#contactsErrorMsg').text(res.errors.contacts);
                            $('#commentsErrorMsg').text(res.errors.comments);
                        }
                    });
                });

                /**
                 * Submit login form
                 */
                $('.login-form').on('submit', function(e){
                    e.preventDefault();

                    let username = $('#username').val();
                    let password = $('#password').val();

                    console.log(username);
                    console.log(password);

                    $.ajax({
                        type: 'post',
                        url: '{{ route('login') }}',
                        data: {
                            '_token' : '{{ csrf_token() }}',
                            'username' : username,
                            'password' : password,
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response.success);
                            window.location.hash = '#products';
                        },
                        error: function(response){
                            var res = response.responseJSON.errors;
                            if(res.username) {
                                $('#usernameErrorMsg').text(res.username);
                            }
                            if(res.password) {
                                $('#passwordErrorMsg').text(res.password);
                            }
                        }
                    });
                });

                /**
                 * Submit add product form
                 */
                $('.product-form').on('submit', function(e){
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
                        success: function() {
                            window.location.hash = '#products';
                        },
                        error: function(response){
                            var res = response.responseJSON.errors;
                            console.log(res);
                            if(res.title) {
                                $('#titleErrorMsg').text(res.title);
                            }
                            if(res.description) {
                                $('#descErrorMsg').text(res.description);
                            }
                            if(res.price) {
                                $('#priceErrorMsg').text(res.price);
                            }
                            if(res.fileToUpload) {
                                $('#fileErrorMsg').text(res.fileToUpload);
                            }
                        },
                    });
                });

                /**
                 * A function that takes a products array and renders it's html
                 *
                 * The products array must be in the form of
                 * [{
                 *     "title": "Product 1 title",
                 *     "description": "Product 1 desc",
                 *     "price": 1
                 * },{
                 *     "title": "Product 2 title",
                 *     "description": "Product 2 desc",
                 *     "price": 2
                 * }]
                 */
                function renderList(products) {
                    html = `<tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Options</th>
                            </tr>`;
                    $.each(products, function (key, product) {
                        html += `<tr>
                                    <td>
                                        <img height="100" width="100"
                                         src="storage/images/${product.id}.${product.extension}"/>
                                    </td>
                                    <td> ${product.title} </td>
                                    <td> ${product.description} </td>
                                    <td> ${product.price} $ </td>
                                    <td>
                                        <a href="#${product.id}" class="button-products">@lang('buttons.add')</a>
                                    <td>
                                </tr>`;
                    });
                    return html;
                }

                /**
                 * A function that takes the cart array and renders it's html and renders checkout form too
                 * @param products
                 * @returns {*|string}
                 */
                function renderCart(products) {
                    html = `<tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Options</th>
                            </tr>`;
                    $.each(products, function (key, product) {
                        html += `<tr>
                                    <td>
                                        <img height="100" width="100"
                                         src="storage/images/${product.id}.${product.extension}"/>
                                    </td>
                                    <td> ${product.title} </td>
                                    <td> ${product.description} </td>
                                    <td> ${product.price} $ </td>
                                    <td>
                                        <a href="#cart/${product.id}" class="button-products">@lang('buttons.remove')</a>
                                    <td>
                                </tr>`;
                    });
                    htmlForm = `<input type="text" id="name" name="name"
                                placeholder=@lang('customer.name') value={{ old('name') }}>
                                <br>
                                <span class="errors" id="nameErrorMsg"></span>
                                <br>
                                <input type="email" id="contacts" name="contacts"
                                placeholder=@lang('customer.contacts') value={{old('contacts') }}>
                                <br>
                                <span class="errors" id="contactsErrorMsg"></span>
                                <br>
                                <textarea id="comments" name="comments" rows="5"
                                placeholder=@lang('customer.comments')>{{ old('comments') }}</textarea>
                                <br>
                                <span class="errors" id="commentsErrorMsg"></span>
                                <br>
                                <input type="submit" name="checkout" value=@lang('buttons.checkout')>`;
                    $('.cart .checkout').html(htmlForm);
                    return html;
                }

                /**
                 * A function that render login form for admin
                 * @returns {string}
                 */
                function login() {
                    html = `<h1>@lang('login.login')</h1>
                            <label for="username">@lang('login.username') </label>
                            <input type="text" id="username" name="username" value={{ old('username') }}>
                            <br>
                            <span class="errors" id="usernameErrorMsg"></span>
                            <br>
                            <label for="password">@lang('login.password') </label>
                            <input type="password" name="password" id="password">
                            <br>
                            <span class="errors" id="passwordErrorMsg"></span>
                            <br>
                            <input type="submit" name="login" value=@lang('buttons.login')>`;
                    return html;
                }

                /**
                 * A function that render all products from products table
                 * @param products
                 * @returns {string}
                 */
                function renderProducts(products) {
                    html = `<tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Options</th>
                            </tr>`;
                    $.each(products, function (key, product) {
                        html += `<tr>
                                    <td>
                                        <img height="100" width="100"
                                         src="storage/images/${product.id}.${product.extension}"/>
                                    </td>
                                    <td> ${product.title} </td>
                                    <td> ${product.description} </td>
                                    <td> ${product.price} $ </td>
                                    <td>
                                        <a href="#products/${product.id}" class="button-products">@lang('buttons.delete')</a>
                                        <a href="#product/${product.id}" class="button-products">@lang('buttons.edit')</a>
                                    <td>
                                </tr>`;
                    });
                    return html;
                }

                /**
                 * A function that render edit/add product form
                 * @returns {string}
                 */
                function renderProductForm() {
                    html = `<h1>@lang('general.product')</h1>
                            <input type="text" id="title" placeholder=@lang('product.title') value={{ old('title') }}>
                            <br>
                            <span class="errors" id="titleErrorMsg"></span>
                            <br>
                            <textarea id="description" placeholder=@lang('product.desc')>{{ old('description') }}</textarea>
                            <br>
                            <span class="errors" id="descErrorMsg"></span>
                            <br>
                            <input type="number" id="price" placeholder=@lang('product.price') value={{ old('price') }}>
                            <br>
                            <span class="errors" id="priceErrorMsg"></span>
                            <br>
                            <input type="file" id="fileToUpload" style="margin-left: 20%;">
                            <br>
                            <span class="errors" id="fileErrorMsg"></span>
                            <br>
                            <input type="submit" name="save" value="@lang('buttons.save')"> <br><br>`;
                    return html;
                }

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
                                success: function() {
                                    $('.login .login-form').html(login());
                                }
                            });
                            break;
                        case '#logout':
                            $('.page').hide();
                            $.ajax({
                                url: '{{route('logout')}}',
                                type: 'post',
                                dataType: 'json',
                                success: function (response) {
                                    console.log(response.success);
                                    window.location.hash = '#';
                                }
                            });
                        /**
                         * Case for all products
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
                                }
                            });
                            break;
                        /**
                         * Case for removing products
                         */
                        case (window.location.hash.match(/#products\/\d+/) || {}).input:
                            $.ajax({
                                type: 'post',
                                url: '{{ route('remove.product') }}',
                                data: {'id': window.location.hash.split('/')[1]},
                                dataType: 'json',
                                success: function (response) {
                                    window.location.hash = "#products";
                                },
                            });
                            break;
                        /**
                         * Case for product form-add
                         */
                        case '#product':
                            $('.page').hide();
                            $('.product').show();
                            $('.product .product-form').html(renderProductForm());
                            break;
                        /**
                         * Case for product form-edit
                         */
                        case (window.location.hash.match(/#product\/\d+/) || {}).input:
                            $('.page').hide();
                            $('.product').show();
                            $('.product .product-form').html(renderProductForm());
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
    </body>
</html>
