<html>
<head>
    <style>
        .w-5
        {
            width:25px !important;
        }
    </style>

</head>
<body>
<ol>
    @foreach($posts as $post)
        <li> {{$post->title}}</li>
    @endforeach

</ol>


<ul>
    {{$posts->appends(request()->input())->links()}}
</ul>

</body>
</html>
