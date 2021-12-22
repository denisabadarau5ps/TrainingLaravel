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
                            '<td> ',
                            '<img height="100" ',
                            'width="100" ',
                            'src="storage/images/' + product.id + '.' + product.extension + '"/> ',
                            '</td>',
                            '<td>' + product.title + '</td>',
                            '<td>' + product.description + '</td>',
                            '<td>' + product.price + '$</td>',
                            '<td>',
                            '<a href="',
                            (window.location.hash.match(/#cart(\/\d+)*/) ? '#cart/' : '#'),
                            product.id,
                            '" class="button-products">',
                            (window.location.hash.match(/#cart(\/\d+)*/) ?
                                '@lang('buttons.remove')' :
                                '@lang('buttons.add')'),
                            '</a>',
                            '<td>'
                        ].join('');
                    });

                    if (window.location.hash === '#cart') {
                        htmlForm = [
                            '<input type="text" id="name" name="name"  ' +
                            'placeholder=@lang('customer.name') value="{{ old('name') }}">',
                            '<br>',
                            '<span class="errors" id="nameErrorMsg"></span>',
                            '<br>',
                            '<input type="email" id="contacts" name="contacts" ' +
                            'placeholder=@lang('customer.contacts')
                                value={{old('contacts') }} >',
                            '<br>',
                            '<span class="errors" id="contactsErrorMsg"></span>',
                            '<br>',
                            '<textarea id="comments" name="comments" rows="5" ' +
                            'placeholder=@lang('customer.comments')>{{ old('comments') }}</textarea>',
                            '<br>' +
                            '<span class="errors" id="commentsErrorMsg"></span>',
                            '<br>',
                            '<input type="submit" name="checkout" value=@lang('buttons.checkout')>',
                        ].join('');
                        $('.cart .checkout').html(htmlForm);
                        $('.checkout').on('submit', function(e){
                            e.stopImmediatePropagation();
                            e.preventDefault();

                            let name = $('#name').val();
                            let contacts = $('#contacts').val();
                            let comments = $('#comments').val();

                            $.ajax({
                                type: 'post',
                                url: '{{ route('checkout') }}',
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
                                    console.log(res);
                                    if (res.errors.name) {
                                        $('#nameErrorMsg').text(res.errors.name);
                                    } else if (res.errors.contacts) {
                                        $('#contactsErrorMsg').text(res.errors.contacts);
                                    } else if (res.errors.comments) {
                                        $('#commentsErrorMsg').text(res.errors.comments);
                                    }
                                }
                            });
                        });
                    }
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
                            // Show the cart page
                            $('.cart').show();
                            // Load the cart products from the server
                            $.ajax({
                                url: '{{ route('show.cart') }}',
                                dataType: 'json',
                                success: function (response) {
                                    // Render the products in the cart list
                                    $('.cart .list').html(renderList(response));
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
                        default:
                            // If all else fails, always default to index
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
    </body>
</html>
