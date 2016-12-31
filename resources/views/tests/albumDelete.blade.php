<html>
<head>
    <title>Birl</title>
</head>

<body>
<form method="POST" id="form" enctype="multipart/form-data">
    {{ csrf_field() }}
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

        request.open('delete', '/admin/album/delete/3');
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

