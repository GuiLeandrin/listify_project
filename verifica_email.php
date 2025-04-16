<?php
    session_start();
    $cpf = $_SESSION['cpf'] ?? '';
    $erro = @$_SESSION['erro'];
    unset($_SESSION['erro']);

    if (!$cpf) {
        header("Location: verifica_cpf.php");
        exit;
    }

    if(isset($_POST['submit']) && $_POST['submit'] === 'Validar') {
        $conexao = new mysqli("localhost", "root", "", "website");
        $email = @$_POST['email'];

        if($email) {
            $sql = "SELECT * FROM usuarios WHERE email = '$email' AND cpf = '$cpf';";
            $verifica = $conexao->query($sql);
            $usuario = $verifica->fetch_assoc();

            if($usuario) {
                $_SESSION['email'] = $usuario['email'];
                header("Location: redefine_senha.php");
                exit;
            } else {
                $erro = "
                    <div class='rounded text-center w-75 p-2 mb-2' style='background-color: #f8d7da; color: #721c24;'>
                        <p class='m-0 d-flex justify-content-center align-items-center h-100'>E-mail incorreto</p>
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
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif(isset($_POST['submit']) && $_POST['submit'] === 'Sair') {
        unset($_SESSION['cpf']);
        header("Location: index.php");
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
    <title>Redefinir Senha - Email</title>
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
                <label for="email" class="form-label" style="cursor: text;">Digite seu E-mail para redefinir sua senha:</label>
                <input type="email" class="form-control bg-transparent border-2" placeholder="exemplo@dominio.com" name="email" id="email">
            </div>
            <div class="w-75 mt-3 gap-1 d-flex">
                <input type="submit" name="submit" value="Validar" class="btn btn-success w-75">
                <input type="submit" name="submit" value="Sair" class="btn btn-secondary w-25">
            </div>
        </form>
    </div>
</body>
</html>