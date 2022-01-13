<div class="row">
        <table class="table table-bordered" id="laravel">
            <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Option</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($data) && $data->count())
                @foreach($data as $user)
                    <tr>
                        <td>
                            <img height="100" width="100"
                                 src="{{ url('storage/images/'.$user->id . '.' . $user->extension) }}"/>
                        </td>
                        <td>{{ $user->title }}</td>
                        <td>{{ $user->description }}</td>
                        <td>{{ $user->price }}</td>
                        <td>ffff</td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">No data found.</td>
                </tr>
            @endif
            </tbody>
        </table>
</div>
<div class="row">
    {!! $data->links() !!}
</div>
