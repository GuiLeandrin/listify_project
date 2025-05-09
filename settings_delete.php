<?php
    include 'funcoes.php';
    session_start();
    $id = @$_SESSION['id'];
    $erro = @$_SESSION['erro'];
    $txtConfirmaExcluir = @$_SESSION['txtConfirmaExcluir'];
    $confirmaExcluir = @$_SESSION['confirmaExcluir'];
    unset($_SESSION['erro'], $_SESSION['confirmaExcluir'], $_SESSION['txtConfirmaExcluir']);

    if($id) {
        $conexao = new mysqli("localhost", "root", "", "listify");
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

    if (isset($_POST['delete'])) {
        $dados = verificaDelete($email);
        $_SESSION['txtConfirmaExcluir'] = $dados['bloco_texto'];
        $_SESSION['confirmaExcluir'] =  $dados['formulario_verifica'];
        $_SESSION['erro'] = $erro;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    if (isset($_POST['confirmDelete'])) {
        $dados = verificaDelete($email);
        $_SESSION['txtConfirmaExcluir'] = $dados['bloco_texto'];
        $_SESSION['confirmaExcluir'] =  $dados['formulario_verifica'];
        $frase = @$_SESSION['frase'];
        $fraseInserida = @$_POST['fraseConfirm'];
        if($fraseInserida == $frase) {
            unset($_SESSION['frase']);
            $delete = "DELETE FROM usuarios WHERE id = '$id';";
            $exclusao = $conexao->query($delete);

            if($exclusao) {
                unset($_SESSION['id']);
                header("Location: index.php");
                exit;
            } else {
                $erro = "
                    <div class='h-auto w-auto ms-2 ms-md-4 ms-xxl-5'>
                        <div class='rounded text-center p-2 h-auto w-75 ms-2 ms-md-4 ms-xxl-5' style='background-color: #f8d7da; color: #721c24;'>
                            <p class='m-0 d-flex justify-content-center align-items-center'>Erro em Deletar o Usuário</p>
                        </div>
                    </div>
                ";
            }
        } else {
            $erro = "
                <div class='h-auto w-auto ms-2 ms-md-4 ms-xxl-5'>
                    <div class='rounded text-center p-2 h-auto w-75 ms-2 ms-md-4 ms-xxl-5' style='background-color: #f8d7da; color: #721c24;'>
                        <p class='m-0 d-flex justify-content-center align-items-center'>Frase Incorreta</p>
                    </div>
                </div>
            ";
        }
        $_SESSION['erro'] = $erro;
        header("Location: " . $_SERVER['PHP_SELF']);
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
    <style>
        @media (min-width: 768px) {
            #responsive {
                overflow: hidden;
            }
        }
        @media (max-width: 767px) {
            #responsive {
                overflow: auto;
            }
        }
    </style>
</head>
<body class="vh-100">
    <div class="w-100 d-flex" style="height: 13vh; background-color: #2c2c2e;">
        <form action="" class="h-100 w-100 d-flex justify-content-between" method="POST">
            <div class="h-100 w-auto d-flex align-items-center ms-4">
                <span class="fs-2 fw-bold pb-2 text-white">Settings</span>
            </div>
            <div class="h-100 w-auto d-flex align-items-center me-4 gap-4">
                <a href="home.php" class="text-decoration-none border-0 text-white" title="Voltar"><i class="fa-solid fa-share fa-flip-horizontal fs-5"></i></a>
            </div>
        </form>
    </div>
    <div class="d-flex" id="responsive" style="height: calc(100vh - 13vh);">
        <div class="vh-100 d-flex flex-column align-items-center" style="background-color: #e0e0e0; width: 22vw;">
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
            <div class="h-auto w-auto mt-4 mt-xxl-5 ms-1 ms-md-4 ms-xxl-5">
                <h1 class="text-black"> > > Delete Account</h1>
            </div>
            <form action="" method="POST" class="h-auto w-auto mt-4 ms-2 ms-md-4 ms-xxl-5 gap-3">
                <div class="h-auto w-75 ms-2 ms-md-4 ms-xxl-5">
                    <p style="text-align: justify;">A exclusão da sua conta é permanente. Todos os dados serão removidos e não poderão ser recuperados. Salve tudo o que for importante antes de prosseguir. Esta ação é irreversível.</p>
                </div>
                <div class="h-auto w-75 ms-2 ms-md-4 ms-xxl-5 mb-3">
                    <input type="submit" name="delete" class="w-100 btn btn-danger mb-3" value="Delete">
                </div>
            </form>
            <?php if ($txtConfirmaExcluir): ?>
                <?php echo $txtConfirmaExcluir; ?>
            <?php endif; ?>
            <?php if ($erro): ?>
                <?php echo $erro; ?>
            <?php endif; ?>
            <?php if ($confirmaExcluir): ?>
                <?php echo $confirmaExcluir; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>