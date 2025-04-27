<?php
    session_start();
    $id = @$_SESSION['id'];

    if(!$id) {
        header("Location: index.php");
        exit;
    }

    if(isset($_POST['logout'])) {
        unset($_SESSION['id']);
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
<body class="vh-100 overflow-hidden">
    <div class="bg-primary w-100 d-flex" style="height: 13vh;">
        <form action="" class="h-100 w-100 d-flex justify-content-between" method="POST">
            <div class="h-100 w-auto d-flex align-items-center ms-4">
                <a href="home.php" class="text-decoration-none pb-2 border-0 text-white"><span class="fs-1 fw-bold">Listify</span></a>
            </div>
            <div class="h-100 w-auto d-flex align-items-center me-4 gap-4">
                <a href="settings.php" class="text-decoration-none border-0 text-white"><i class="fa-solid fa-gear fs-5" stitle="Settings"></i></a>
                <button name="logout" class="text-decoration-none border-0 p-0 text-white bg-transparent"><i class="fa-solid fa-right-from-bracket fs-5" title="Log Out"></i></button>
            </div>
        </form>
    </div>
    <div style="height: calc(100vh - 13vh); background: linear-gradient(to bottom, #fafafa,  #c0c0c0);"></div>
</body>
</html>