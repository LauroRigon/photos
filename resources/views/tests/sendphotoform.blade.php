<html>
<head>
    <title>Bla</title>
</head>

<body>
<form method="POST" id="form" enctype="multipart/form-data" action="{{ config('app.url') }}/admin/photo/create">
    {{ csrf_field() }}
    <input type="file" name="photos[]" multiple><br>
    <label>User</label><input type="number" name="user_id" value="{{old('user_id')}}"><br>
    <label>Album</label>
    <input type="number" name="album_id" value="{{old('album_id')}}">
    <img src="{{ config('app.url') }}/userarea/photos/get/IMG_0405.JPG">
    <button class="button button-primary" type="submit">Send</button>
    <br>
    <div id="content"></div>

</form>

<script>
    var form = document.getElementById('form');
    var request = new XMLHttpRequest();

    form.addEventListener('submit', function (e){
        e.preventDefault();
        var formData = new FormData(form);

        request.open('post', '/admin/photo/create');
        request.addEventListener('load', transferComplete);
        request.send(formData);
    });

    function transferComplete(data){
        console.log(data.currentTarget.response);
        $content = document.getElementById('content');
        $content.innerHTML = data.currentTarget.response;
    }

</script>
</body>
</html>

