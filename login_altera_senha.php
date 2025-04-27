<?php
    session_start();
    $cpf = $_SESSION['cpf'] ?? '';
    $email = $_SESSION['email'] ?? '';
    $log = @$_SESSION['log'];
    unset($_SESSION['log']);

    if (!$cpf && !$email) {
        header("Location: login_verifica_cpf.php");
        exit;
    }

    if(isset($_POST['submit']) && $_POST['submit'] === 'Alterar') {
        $conexao = new mysqli("localhost", "root", "", "website");
        $senha = @$_POST['senha'];
        $confirma = @$_POST['confirma'];

        if($senha && $confirma) {
            if($senha == $confirma) {
                $sql = "SELECT * FROM usuarios WHERE email = '$email';";
                $verifica = $conexao->query($sql);
                $usuario = $verifica->fetch_assoc();

                if($senha != $usuario['senha']) {
                    $sql = "UPDATE usuarios SET senha = '$senha' WHERE email = '$email';";
                    $altera = $conexao->query($sql);
                    
                    if($altera) {
                        $log = "<div class='rounded text-center w-75 p-2' style='background-color: #d4edda; color: #155724;'>
                                <p class='m-0 d-flex justify-content-center align-items-center h-100'>Senha alterada com sucesso!!</p>
                            </div>
                        ";
                    } else {
                        $log = "<div class='rounded text-center w-75 p-2' style='background-color: #f8d7da; color: #721c24;'>
                                <p class='m-0 d-flex justify-content-center align-items-center h-100'>Erro na alteração de senha</p>
                            </div>
                        ";
                    }
                } else {
                    $log = "<div class='rounded text-center w-75 p-2' style='background-color: #f8d7da; color: #721c24;'>
                            <p class='m-0 d-flex justify-content-center align-items-center h-100'>A nova senha é igual a atual</p>
                        </div>
                    ";
                }
            } else {
                $log = "<div class='rounded text-center w-75 p-2' style='background-color: #f8d7da; color: #721c24;'>
                        <p class='m-0 d-flex justify-content-center align-items-center h-100'>Senhas informadas não coincidem</p>
                    </div>
                ";
            }
        } else {
            $log = "<div class='rounded text-center w-75 p-2' style='background-color: #f8d7da; color: #721c24;'>
                    <p class='m-0 d-flex justify-content-center align-items-center h-100'>Formulário não preenchido corretamente</p>
                </div>
            ";
        }
        $_SESSION['log'] = $log;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif(isset($_POST['submit']) && $_POST['submit'] === 'Sair') {
        unset($_SESSION['cpf'], $_SESSION['email']);
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
    <title>Redefinir Senha</title>
</head>
<body class="vh-100 d-flex align-items-center justify-content-center p-1 row overflow-hidden" style="background: linear-gradient(45deg, #f0f0f0, #d6d6d6);">
    <div class="bg-white shadow-lg rounded-5 d-flex flex-column align-items-center col-md-4 col-sm-8 col-10" style="min-height: 350px; padding: 2rem 0;">
        <div class="w-75 mb-4 pb-3 d-flex align-items-center border-bottom border-3 border-black">
                <h4>Alteração de Senha:</h4>
        </div>
        <?php if ($log): ?>
            <?php echo $log; ?>
        <?php endif; ?>
        <form action=""  method="POST" class="w-100 h-75 d-flex flex-column align-items-center mt-1">
            <div class="w-75">
                <label for="senha" class="mb-0 form-label" style="cursor: text;">Nova Senha:</label>
                <div class="input-group rounded-1 border border-2 border-dark border-opacity-25">
                    <input type="password" class="form-control bg-transparent border-0 shadow-none" placeholder="Digite sua nova senha:" name="senha" id="senha">
                    <button class="input-group-text bg-transparent border-0 text-decoration-none" type="button" onclick="exibirSenha('senha', 'iconeSenha')"><i id="iconeSenha" class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <div class="w-75 mt-2 mb-3">
                <label for="confirma" class="mb-0 form-label" style="cursor: text;">Confirma sua nova Senha:</label>
                <div class="input-group rounded-1 border border-2 border-dark border-opacity-25">
                    <input type="password" class="form-control bg-transparent border-0 shadow-none" placeholder="Confirme sua nova senha:" name="confirma" id="confirma">
                    <button class="input-group-text bg-transparent border-0 text-decoration-none" type="button" onclick="exibirSenha('confirma', 'iconeConfirma')"><i id="iconeConfirma" class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <div class="w-75 mt-4 gap-1 d-flex">
                <input type="submit" name="submit" value="Alterar" class="btn btn-success w-75">
                <input type="submit" name="submit" value="Sair" class="btn btn-secondary w-25">
            </div>
        </form>
    </div>
    <script>
        function exibirSenha(IdBotao, IdIcone) {
            const botaoEye = document.getElementById(IdBotao);
            const iconeEye = document.getElementById(IdIcone);
            botaoEye.type = botaoEye.type === "password" ? "text" : "password";
            iconeEye.className = botaoEye.type === "password" ? "fa-solid fa-eye" : "fa-solid fa-eye-slash";
        }
    </script>
</body>
</html>