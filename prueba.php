<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autocompletar con PHP y jQuery</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
    <label for="pais">País: </label>
    <input type="text" id="pais">

    <script>
        $(function() {
            $("#pais").autocomplete({
                source: "autocompletar2.php",
                minLength: 1
            });
        });
    </script>
</body>
</html>
