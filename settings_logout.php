<?php
    session_start();
    $id = @$_SESSION['id'];

    if($id) {
        $conexao = new mysqli("localhost", "root", "", "website");
        $sql = "SELECT * FROM usuarios WHERE id = '$id';";
        $verifica = $conexao->query($sql);
        $usuario = $verifica->fetch_assoc();
        $nome = @$usuario['nome'];
        $email = @$usuario['email'];
        $senha = @$usuario['senha'];
        $cpf = @$usuario['cpf'];
        $telefone = @$usuario['telefone'];
    } else {
        header("Location: index.php");
        exit;
    }

    if(isset($_POST['submit'])) {
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
    <title>Settings</title>
</head>
<body class="vh-100 overflow-hidden">
    <div class="w-100 d-flex" style="height: 13vh; background-color: #2c2c2e;">
        <form action="" class="h-100 w-100 d-flex justify-content-between" method="POST">
            <div class="h-100 w-auto d-flex align-items-center ms-4">
                <span class="fs-2 fw-bold pb-2 text-white">Settings</span>
            </div>
            <div class="h-100 w-auto d-flex align-items-center me-4 gap-4">
                <a href="home.php" class="text-decoration-none border-0 text-white"><i class="fa-solid fa-share fa-flip-horizontal fs-5" title="Voltar"></i></a>
            </div>
        </form>
    </div>
    <div class="d-flex" style="height: calc(100vh - 13vh);">
        <div class="h-100 d-flex flex-column align-items-center" style="background-color: #e0e0e0; width: 22vw;">
            <div class="w-100 h-auto py-3 px-2 d-flex align-items-center justify-content-center border-bottom border-2 border-secondary border-opacity-50">
                <a href="settings.php" class="text-decoration-none border-0 text-dark d-flex flex-column flex-md-row gap-2 align-items-center"><i class="fa-solid fa-circle-user fs-5"></i><h6 class="text-center m-0">My Account</h6></a>
            </div>
            <div class="w-100 h-auto py-3 px-2 d-flex align-items-center justify-content-center border-bottom border-2 border-secondary border-opacity-50">
                <a href="settings_edit.php" class="text-decoration-none border-0 text-dark d-flex flex-column flex-md-row gap-2 align-items-center"><i class="fa-solid fa-user-pen fs-5"></i><h6 class="text-center m-0">Edit Profile</h6></a>
            </div>
            <div class="w-100 h-auto py-3 px-2 d-flex align-items-center justify-content-center border-bottom border-2 border-secondary border-opacity-50">
                <a href="settings_logout.php" class="text-decoration-none border-0 text-dark d-flex flex-column flex-md-row gap-2 align-items-center"><i class="fa-solid fa-right-from-bracket fs-5"></i><h6 class="text-center m-0">Sign Out</h6></a>
            </div>
            <div class="w-100 h-auto py-3 px-2 d-flex align-items-center justify-content-center border-bottom border-2 border-secondary border-opacity-50">
                <a href="settings_delete.php" class="text-decoration-none border-0 text-dark d-flex flex-column flex-md-row gap-2 align-items-center"><i class="fa-solid fa-trash fs-5"></i><h6 class="text-center m-0">Delete Account</h6></a>
            </div>
        </div>
        <div class="h-100 bg-white" style="width: calc(100vw - 22vw);">
            <div class="h-auto w-auto mt-4 mt-xxl-5 ms-2 ms-md-4 ms-xxl-5">
                <h1 class="text-black"> > > Sign Out</h1>
            </div>
            <form action="" method="POST" class="h-auto w-auto mt-4 mt-md-5 ms-2 ms-md-4 ms-xxl-5 d-flex gap-1 gap-md-3">
                    <div class="w-auto h-auto d-flex align-items-center mb-2">
                        <h6 class="m-0 text-decoration-underline">Você deseja encerrar sua sessão?</h6>
                    </div>
                    <div class="w-auto h-auto me-3 d-flex align-items-center justify-content-center mb-2">
                        <input type="submit" name="submit" class="w-auto px-5 btn btn-danger" value="Sign Out">
                    </div>
            </form>
            <div class="h-auto w-75 mt-4 ms-2 ms-md-4 ms-xxl-5">
                <p style="text-align: justify;">Encerrar a sessão garante a segurança das suas informações pessoais. Se você não encerrar a sessão, especialmente em dispositivos públicos, outras pessoas podem acessar sua conta, dados sensíveis ou fazer alterações não autorizadas. Sempre clique em "Sair" quando terminar de usar a plataforma para proteger sua conta.</p>
            </div>
        </div>
    </div>
</body>
</html>