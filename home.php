<?php
    session_start();
    $id = @$_SESSION['id'];
    $nome = @$_SESSION['nome'];

    if (!$id) {
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Home</title>
</head>
<body class="d-flex flex-column justify-content-center align-items-center vh-100">
    <h1 class="text-center text-primary display-3 p-5">
        <?php if ($id && $nome): ?>
            <?php echo "Bem Vindo(a), $nome. Que bom ter você aqui conosco!"; ?>
        <?php endif; ?>
    </h1>
    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="mt-5 btn btn-secondary w-25">Voltar</a>
</body>
</html>