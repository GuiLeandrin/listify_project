<?php
    session_start();
    $id = @$_SESSION['id'];
    $erro = '';

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

    if(isset($_POST['excluir']) && $_POST['excluir'] == "1") {
        $inicioFrase = explode('@', $email)[0];
        $frase = "$inicioFrase/confirmExclusion";

        if(isset($_POST['confirmar']) && $_POST['confirmar'] == "1") {
            $fraseInserida = @$_POST['fraseConfirm'];
            if($fraseInserida == $frase) {
                $delete = "DELETE FROM usuarios WHERE id = '$id';";
                $exclusao = $conexao->query($delete);

                if($exclusao) {
                    unset($_SESSION['id']);
                    header("Location: index.php");
                    exit;
                } else {
                    $erro = "
                        <div class='rounded text-center w-100 p-1' style='background-color: #f8d7da; color: #721c24;'>
                            <p class='m-0 d-flex justify-content-center align-items-center h-100'>Erro no Delete!</p>
                        </div>
                    ";
                }
            } else {
                $erro = "
                    <div class='rounded text-center w-100 p-1' style='background-color: #f8d7da; color: #721c24;'>
                        <p class='m-0 d-flex justify-content-center align-items-center h-100'>Frase Incorreta!</p>
                    </div>
                ";
            }
        }
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
                <a href="home.php" class="text-decoration-none border-0 text-white"><i class="fa-solid fa-share fa-flip-horizontal fs-5" title="Back to Home"></i></a>
            </div>
        </form>
    </div>
    <div class="d-flex" style="height: calc(100vh - 13vh);">
        <div class="h-100 w-25 d-flex flex-column align-items-center" style="background-color: #e0e0e0;">
            <div class="w-100 h-auto p-3 d-flex align-items-center justify-content-center border-bottom border-2 border-secondary border-opacity-50">
                <a href="settings.php" class="text-decoration-none border-0 text-dark d-flex flex-column flex-md-row gap-2 align-items-center"><i class="fa-solid fa-circle-user fs-5"></i><h6 class="text-center m-0">My Account</h6></a>
            </div>
            <div class="w-100 h-auto p-3 d-flex align-items-center justify-content-center border-bottom border-2 border-secondary border-opacity-50">
                <a href="settings_edit.php" class="text-decoration-none border-0 text-dark d-flex flex-column flex-md-row gap-2 align-items-center"><i class="fa-solid fa-user-pen fs-5"></i><h6 class="text-center m-0">Edit Profile</h6></a>
            </div>
            <div class="w-100 h-auto p-3 d-flex align-items-center justify-content-center border-bottom border-2 border-secondary border-opacity-50">
                <a href="settings_logout.php" class="text-decoration-none border-0 text-dark d-flex flex-column flex-md-row gap-2 align-items-center"><i class="fa-solid fa-right-from-bracket fs-5"></i><h6 class="text-center m-0">Sign Out</h6></a>
            </div>
            <div class="w-100 h-auto p-3 d-flex align-items-center justify-content-center border-bottom border-2 border-secondary border-opacity-50">
                <a href="settings_delete.php" class="text-decoration-none border-0 text-dark d-flex flex-column flex-md-row gap-2 align-items-center"><i class="fa-solid fa-trash fs-5"></i><h6 class="text-center m-0">Delete Account</h6></a>
            </div>
        </div>
        <div class="h-100 w-75 bg-white">
            <div class="h-auto w-auto mt-4 mt-xxl-5 ms-1 ms-md-4 ms-xxl-5">
                <h1 class="text-black"> > > Delete Account</h1>
            </div>
            <form action="" method="POST" class="h-auto w-auto mt-4 ms-2 ms-md-4 ms-xxl-5 gap-3">
                <input type="hidden" name="excluir" value="1">
                <div class="h-auto w-75 ms-2 ms-md-4 ms-xxl-5">
                    <p style="text-align: justify;">Deleting your account is permanent. All data and preferences will be removed and cannot be recovered. Save anything important before proceeding. This action is irreversible.</p>
                </div>
                <div class="h-auto w-75 ms-2 ms-md-4 ms-xxl-5">
                    <input type="submit" class="w-100 btn btn-danger mb-3" value="Delete">
                </div>
            </form>
            <?php if(isset($_POST['excluir']) && $_POST['excluir'] == "1"): ?>
                <form action="" method="POST" class="h-auto w-auto mt-4 ms-2 ms-md-4 ms-xxl-5 gap-3">
                    <input type="hidden" name="excluir" value="1">
                    <input type="hidden" name="confirmar" value="1">
                    <div class='h-auto w-75 mt-4 ms-2 ms-md-4 ms-xxl-5'> 
                        <div class='h-auto w-100'>
                            <p style='text-align: justify;'>To proceed with the deletion of your account, please enter the standard confirmation phrase shown below into the designated text field: <?php echo "($frase)"; ?></p>
                        </div>
                        <div class='h-auto w-100 d-flex flex-column align-items-center justify-content-center gap-3'>
                            <?php if ($erro): ?>
                                <?php echo $erro; ?>
                            <?php endif; ?>
                            <input type='text' name='fraseConfirm' class='form-control bg-white border-2' placeholder='xxxxxxxx/confirmExclusion'>
                            <input type='submit' class='w-100 btn btn-danger' value='Confirm Delete'>
                        </div>
                    </div>
                </form>
            <?php endif;?>
        </div>
    </div>
</body>
</html>

