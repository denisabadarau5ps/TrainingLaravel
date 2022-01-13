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
            url: '/checkout',
            dataType: 'json',
            data: {
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
            url: '/login',
            data: {
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
            url: '/product',
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
                    url: '/cart',
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
                    url: '/cart',
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
                    url: '/',
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
                $('.login .login-form').html(login());
                break;
            /**
             * Logout case
             */
            case '#logout':
                $('.page').hide();
                $.ajax({
                    url: '/logout',
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
                    url: '/products',
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
                    url: '/products',
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
                $('.product .product-form').html(renderProductForm());
                break;
            /**
             * Case for product form-edit
             */
            case (window.location.hash.match(/#product\/\d+/) || {}).input:
                $('.page').hide();
                $('.product').show();
                $.ajax({
                    type: 'get',
                    url: '/product',
                    data: {'id': window.location.hash.split('/')[1]},
                    dataType: 'json',
                    success: function (product) {
                        $('.product .product-form').html(renderProductForm(product));
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
                    url: '/orders',
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
                    url: '/order',
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

                const page = getCurrentPage();
                console.log(page);
                // Load the index products from the server
                $.ajax({
                    url: `/?pageSize=2&page=${page}`,
                    dataType: 'json',
                    success: function ({ data, ...paginationData }) {
                        // Render the products in the index list
                        console.log(paginationData);
                        $('.index .list').html(renderList(data, paginationData));
                    }
                });
                break;
        }
    }
    window.onhashchange();
});
