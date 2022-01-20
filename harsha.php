<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
    ob_clean();

    $output = array();
    $files = (object)$_FILES['files'];

    foreach ($files->name as $i => $void) {
        $name = $files->name[$i];
        $size = $files->size[$i];
        $type = $files->type[$i];
        $tmp  = $files->tmp_name[$i];
        $error = $files->error[$i];

        $output[] = array('name' => $name, 'size' => $size, 'type' => $type);
    }
    exit(json_encode($output));
}
?>
<!doctype html>
<html>

<head>
    <meta charset='utf-8' />
    <title>Browse multiple locations</title>
    <script>
        (function() {
            function ajax(url, payload, callback) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) callback.call(this, this.response);
                };
                xhr.open('POST', url, true);
                xhr.send(payload);
            }


            document.addEventListener('DOMContentLoaded', function() {

                    let fd = new FormData();

                    const callback = function(r) {
                        console.info(r)
                        let json = JSON.parse(r);
                        fd = new FormData();
                        console.log(typeof(json))
                        document.getElementById('count').innerHTML = Object.keys(json).length + ' files uploaded';
                    }; 
                    console.log(files)

                    let oFile = document.querySelector('input[type="file"]');
                    let oBttn = document.querySelector('input[type="button"]');

                    oFile.addEventListener('change', function(e) {
                        for (var i = 0; i < this.files.length; i++) fd.append('files[]', this.files[i], this.files[i].name);

                        document.getElementById('count').innerHTML = fd.getAll('files[]').length + ' files in array';
                    }, false);




                    oBttn.addEventListener('click', function(e) {
                        if (fd.getAll('files[]').length > 0) ajax.call(this, location.href, fd, callback);
                    }, false);

                },
                false);
        })();
    </script>
</head>

<body>
    <form>
        <div id='count'></div>
        <input type='file' name='files' multiple />
        <input type='button' value='Upload Files' />
    </form>
</body>

</html>