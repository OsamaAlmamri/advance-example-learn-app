<form action="posts/create" method="post">
    @csrf

    <select>
        @foreach($channels as $channel)
            <option value="{{$channel->id}}"> {{$channel->name  }}</option>

        @endforeach
    </select>
</form>
