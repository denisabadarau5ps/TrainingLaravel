<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Load the jQuery JS library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Custom JS script -->
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function () {
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
                    html = [
                        '<tr>',
                            '<th>Image</th>',
                            '<th>Title</th>',
                            '<th>Description</th>',
                            '<th>Price</th>',
                            '<th>Options</th>',
                        '</tr>'
                    ].join('');

                    $.each(products, function (key, product) {
                        html += [
                            '<tr>',
                                '<td> ' ,
                                    '<img height="100" ' ,
                                    'width="100" ' ,
                                    'src="storage/images/' + product.id + '.' + product.extension + '"/> ' ,
                                '</td>',
                                '<td>' + product.title + '</td>',
                                '<td>' + product.description + '</td>',
                                '<td>' + product.price + '$</td>',
                                '<td>',
                                    '<a href="',
                                    (window.location.hash.match(/#cart(\/\d+)*/) ? '#cart/' : '#'),
                                    product.id,
                                    '" class="button-products">',
                                    (window.location.hash.match(/#cart(\/\d+)*/) ? '@lang('buttons.remove')' : '@lang('buttons.add')'),
                                    '</a>',
                                '<td>'
                            ].join('');
                    });

                    return html;
                }

                /**
                 * URL hash change handler
                 */
                window.onhashchange = function () {
                    // First hide all the pages
                    $('.page').hide();

                    switch (window.location.hash) {
                        case '#cart':
                            // Show the cart page
                            $('.cart').show();
                            // Load the cart products from the server
                            $.ajax('/cart', {
                                dataType: 'json',
                                success: function (response) {
                                    // Render the products in the cart list
                                    $('.cart .list').html(renderList(response));
                                }
                            });
                            break;

                        /**
                         * case for removing products from cart
                         */
                        case (window.location.hash.match(/#cart\/\d+/) || {}).input:
                            $.ajax({
                                type: 'post',
                                url: '/cart',
                                data: {'id': window.location.hash.split('/')[1]},
                                dataType: 'json',
                                success: function () {
                                    window.location.hash = "#cart";
                                },
                            });
                            break;
                        /**
                         * case for adding products to cart
                         */
                        case (window.location.hash.match(/#\d+/) || {}).input:
                            $.ajax({
                                type: 'post',
                                url: '/',
                                data: {'id': window.location.hash.split('#')[1]},
                                dataType: 'json',
                                success: function () {
                                    window.location.hash = "#";
                                },
                            });
                            break;
                        default:
                            // If all else fails, always default to index
                            // Show the index page
                            $('.index').show();
                            // Load the index products from the server
                            $.ajax('/', {
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
                <a href="#cart" class="button">Go to cart</a>
            </div>
        </div>

        <!-- The cart page -->
        <div class="page cart">
            <!-- The cart element where the products list is rendered -->
            <table class="list"></table>

            <!-- A link to go to the index by changing the hash -->
            <div class="button-container">
                <a href="#" class="button">Go to index</a>
            </div>
        </div>
    </body>
</html>
