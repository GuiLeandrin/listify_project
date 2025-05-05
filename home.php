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
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #2f2f2f;
        }
        ::-webkit-scrollbar-thumb {
            background: #888; 
        }
    </style>
</head>
<body class="min-vh-100 bg-light">
    <div class="bg-primary w-100 d-flex" style="height: 13vh;">
        <form action="" class="h-100 w-100 d-flex justify-content-between" method="POST">
            <div class="h-100 w-auto d-flex align-items-center ms-4">
                <a href="home.php" class="text-decoration-none pb-2 border-0 text-white"><span class="fs-1 fw-bold">Listify</span></a>
            </div>
            <div class="h-100 w-auto d-flex align-items-center me-4 gap-4">
                <a href="settings.php" class="text-decoration-none border-0 text-white" title="Settings"><i class="fa-solid fa-gear fs-5"></i></a>
                <button name="logout" class="text-decoration-none border-0 p-0 text-white bg-transparent" title="Log Out"><i class="fa-solid fa-right-from-bracket fs-5"></i></button>
            </div>
        </form>
    </div>
    <div class="d-flex flex-column align-items-center justify-content-center bg-white" style="height: calc(100vh - 13vh);">
        <div class="container-fluid pt-5 px-md-5 overflow-auto" style="height: calc(100vh - 13vh);">
            <div class="table-responsive shadow-lg rounded mb-5">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th class="p-3 align-middle" colspan="2">nome_tabela</th>
                            <th class="p-3" colspan="2">
                                <div class="d-flex justify-content-end gap-1">
                                    <form action="" method="POST">
                                        <button name="adicionar_lista" class="text-decoration-none border-0 p-1 px-2 rounded bg-secondary text-white shadow" title="Adicionar Novo Item"><i class="fa-solid fa-plus"></i></button>
                                        <button name="editar_lista" class="text-decoration-none border-0 p-1 px-2 rounded bg-secondary text-white shadow" title="Editar Nome"><i class="fa-solid fa-pencil"></i></button>
                                        <button name="excluir_lista" class="text-decoration-none border-0 p-1 px-2 rounded bg-secondary text-white shadow" title="Excluir Lista"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider text-center">
                        <tr class="fw-bold">
                            <td class="w-25 text-decoration-underline">Nome:</td>
                            <td class="w-25 text-decoration-underline">Link:</td>
                            <td class="w-25 text-decoration-underline">Valor:</td>
                            <td class="w-25 align-middle"><i class="fa-solid fa-gears"></i>:</td>
                        </tr>
                        <tr>
                            <td class="align-middle">nome_item</td>
                            <td class="align-middle">link_item</td>
                            <td class="align-middle">valor_item</td>
                            <td class="gap-1">
                                <form method="POST" action="">
                                    <button name="check_item" class="text-decoration-none border-0 rounded shadow" title="Concluído"><i class="fa-solid fa-check"></i></button>
                                    <button name="editar_item" class="text-decoration-none border-0 rounded shadow" title="Editar Item"><i class="fa-solid fa-pen"></i></button>
                                    <button name="excluir_item" class="text-decoration-none border-0 rounded shadow" title="Excluir Item"><i class="fa-solid fa-minus"></i></button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>