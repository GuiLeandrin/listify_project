<?php
    session_start();
    $erro = @$_SESSION['erro'];
    $cpf = @$_SESSION['cpf'];
    unset($_SESSION['erro'], $_SESSION['cpf']);

    if(isset($_POST['submit'])) {
        $conexao = new mysqli("localhost", "root", "", "listify");
        $cpf = @$_POST['cpf'];
        
        if($cpf) {
            if(strlen($cpf) == 14) {
                $sql = "SELECT * FROM usuarios WHERE cpf = '$cpf';";
                $verifica = $conexao->query($sql);
                $usuario = $verifica->fetch_assoc();

                if($usuario) {
                    $_SESSION['cpf'] = $usuario['cpf'];
                    header("Location: login_verifica_email.php");
                    exit;
                } else {
                    $erro = "
                        <div class='rounded text-center w-75 p-2 mb-2' style='background-color: #f8d7da; color: #721c24;'>
                            <p class='m-0 d-flex justify-content-center align-items-center h-100'>CPF não cadastrado</p>
                        </div>
                    ";
                }
            } else {
                $erro = "
                    <div class='rounded text-center w-75 p-2 mb-2' style='background-color: #f8d7da; color: #721c24;'>
                        <p class='m-0 d-flex justify-content-center align-items-center h-100'>CPF inválido</p>
                    </div>
                ";
            } 
        } else {
            $erro = "
                <div class='rounded text-center w-75 p-2 mb-2' style='background-color: #f8d7da; color: #721c24;'>
                    <p class='m-0 d-flex justify-content-center align-items-center h-100'>Formulário não preenchido corretamente</p>
                </div>
            ";
        }
        $_SESSION['erro'] = $erro;
        $_SESSION['cpf'] = $cpf;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="favicon.png">
    <script src="https://kit.fontawesome.com/576a6b1350.js" crossorigin="anonymous"></script>
    <title>Redefinir Senha</title>
</head>
<body class="vh-100 d-flex align-items-center justify-content-center p-1 row overflow-hidden" style="background: linear-gradient(45deg, #f0f0f0, #d6d6d6);">
    <div class="bg-white shadow-lg rounded-5 d-flex flex-column align-items-center col-md-4 col-sm-8 col-10" style="min-height: 300px; padding: 2rem 0;">
        <div class="w-75 mb-3 pb-3 d-flex align-items-center border-bottom border-3 border-black">
                <h4>Redefinição de Senha:</h4>
        </div>
        <form action=""  method="POST" class="w-100 h-75 d-flex flex-column align-items-center mt-4">
            <?php if ($erro): ?>
                <?php echo $erro; ?>
            <?php endif; ?>
            <div class="w-75">
                <label for="cpf" class="form-label" style="cursor: text;">Digite seu CPF para redefinir sua senha:</label>
                <input type="text" class="form-control bg-transparent border-2" value="<?php echo $cpf ?? ''; ?>" name="cpf" id="cpf" maxlength="14" placeholder="XXX.XXX.XXX-XX" oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2')">
            </div>
            <div class="w-75 mt-3 gap-1 d-flex">
                <a href="index.php" class="btn btn-secondary w-25">Sair</a>
                <input type="submit" name="submit" value="Validar" class="btn btn-success w-75">
            </div>
        </form>
    </div>
</body>
</html>