<html>
<head>
    <title>Birl</title>
</head>

<body>
<form method="POST" id="form" enctype="multipart/form-data" action="{{ config('app.url') }}/admin/album/create">
    {{ csrf_field() }}
    <label>Nome:</label>
    <input name="name">
    <label>User</label>
    <input type="number" name="user_id">
    <button type="submit">Vai!</button>

</form>
<div id="content">

</div>
<script>
    var form = document.getElementById('form');
    var request = new XMLHttpRequest();

    form.addEventListener('submit', function (e){
        e.preventDefault();
        var formData = new FormData(form);

        request.open('post', '/admin/album/create');
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

