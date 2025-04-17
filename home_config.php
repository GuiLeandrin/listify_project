<?php
    session_start();
    $id = @$_SESSION['id'];
    $nome = @$_SESSION['nome'];

    if (!$id) {
        header("Location: index.php");
        exit;
    }

    if(isset($_POST['logout'])) {
        unset($_SESSION['id'], $_SESSION['nome']);
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
    <script src="https://kit.fontawesome.com/576a6b1350.js" crossorigin="anonymous"></script>
    <title>Home</title>
</head>
<body class="vh-100">
    <div class="bg-primary d-flex justify-content-between p-4" style="height: 15vh;">
        <div class="h-100 w-auto d-flex align-items-center">
            <a href="home.php" class="text-decoration-none"><h2 class="text-white m-0">Listify - Configurações</h2></a>
        </div>
        <form action="" class="h-100 d-flex align-items-center justify-content-evenly" method="POST">
            <div>
                <a href="home.php" class="fs-5"><i class="fa-solid fa-share fa-flip-horizontal text-white"></i></a>
            </div>
            <div class="ms-4">
                <button type="submit" name="logout" class="btn btn-lg p-0 border-0">
                    <i class="fa-solid fa-right-from-bracket text-white"></i>
                </button>
            </div>
        </form>
    </div>
    <div style="height: calc(100vh - 15vh); background: linear-gradient(to bottom, #c0c0c0, #fafafa);">

    </div>
</body>
</html>