<html lang="en">
<head>
    <title>Laravel 7 Ajax Pagination Example Using Jquery - XpertPhp</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div id="table_data">
        @include('pagination_data')
    </div>
</div>
</body>
<script>
    $(document).ready(function(){

        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page)
        {
            $.ajax({
                url:"get_ajax_data?page="+page,
                success:function(data)
                {
                    $('#table_data').html(data);
                }
            });
        }
    });
</script>
</html>
