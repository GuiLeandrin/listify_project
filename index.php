<?php
    session_start();
    $erro = @$_SESSION['erro'];
    unset($_SESSION['erro']);

    if(isset($_POST['submit'])) {
        $conexao = new mysqli("localhost", "root", "", "website");
        $email = @$_POST['email'];
        $senha = @$_POST['senha'];

        if($email && $senha) {
            $sql = "SELECT * FROM usuarios WHERE email = '$email';";
            $verifica = $conexao->query($sql);
            $usuario = $verifica->fetch_assoc();
            
            if ($usuario) {
                if($usuario['senha'] == $senha) {
                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['nome'] = $usuario['nome'];
                    header("Location: home.php");
                    exit;
                } else {
                    $erro = "
                        <div class='mt-2 rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                            <p class='m-0 d-flex justify-content-center align-items-center h-100'>Senha Incorreta</p>
                        </div>
                    ";
                }
            } else {
                $erro = "
                    <div class='mt-2 rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                        <p class='m-0 d-flex justify-content-center align-items-center h-100'>Este e-mail não possui uma conta!!</p>
                    </div>
                ";
            }
        } else {    
            $erro = "
                <div class='mt-2 rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                    <p class='m-0 d-flex justify-content-center align-items-center h-100'>Formulário não preenchido corretamente</p>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="favicon.png">
    <script src="https://kit.fontawesome.com/576a6b1350.js" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body class="vh-100 d-flex align-items-center justify-content-center p-2 row overflow-hidden" style="background: linear-gradient(45deg, #f0f0f0, #d6d6d6);">
    <div class="bg-white shadow-lg rounded-5 d-flex flex-column align-items-center col-md-4 col-sm-8 col-10" style="min-height: 400px; padding: 2rem 0;">
        <div class="w-75 mb-4 pb-4 d-flex align-items-center justify-content-center border-bottom border-5 border-black">
                <h1>Log in</h1>
        </div>
        <form action=""  method="POST" class="w-100 h-75 d-flex flex-column align-items-center">
            <div class="w-75 d-flex gap-1">
                <?php if ($erro): ?>
                        <?php echo $erro; ?>
                <?php endif; ?>
            </div>
            <div class="input-group rounded-1 border border-2 border-dark border-opacity-25 w-75 mt-3">
                <label for="email" class="input-group-text bg-transparent border-0 text-decoration-none"  style="cursor: text;"><i class="fa-solid fa-envelope"></i></label>
                <input type="email" class="form-control bg-transparent border-0 shadow-none" placeholder="Digite seu e-mail:" name="email" id="email">
            </div>
            <div class="input-group rounded-1 border border-2 border-dark border-opacity-25 w-75 mt-3 mb-2">
                <label for="senha" class="input-group-text bg-transparent border-0 text-decoration-none"  style="cursor: text;"><i class="fa-solid fa-lock"></i></label>
                <input type="password" class="form-control bg-transparent border-0 shadow-none" placeholder="Digite sua senha:" name="senha" id="senha">
            </div>
            <div class="w-75 mt-4 d-flex gap-1">
                <input type="submit" name="submit" class="btn btn-primary w-100" value="Entrar">
                <a href="cadastro.php" class="btn btn-primary w-100">Cadastro</a>
            </div>
            <div class="mt-5">
                <h6><a href="login_verifica_cpf.php">Esqueceu sua Senha?</a></h6>
            </div>
        </form>
    </div>
</body>
</html>