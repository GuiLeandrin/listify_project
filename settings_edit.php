<?php
    include 'funcoes.php';
    session_start();
    $id = @$_SESSION['id'];
    $log = @$_SESSION['log'];
    unset($_SESSION['log']);

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
        if($_POST['nome'] == $nome && $_POST['email'] == $email && $_POST['senha'] == $senha && $_POST['cpf'] == $cpf && $_POST['telefone'] == $telefone) {
            $log = "
                <div class='col-11 col-md-8 col-lg-6'>
                    <p class='m-0 d-flex justify-content-center align-items-center h-100 py-2 rounded text-center' style='background-color: #f8d7da; color: #721c24;'>Nenhuma modificação feita!</p>
                </div>
            ";
        } else {
            $nome = @$_POST['nome'];
            $email = @$_POST['email'];
            $senha = @$_POST['senha'];
            $cpf = @$_POST['cpf'];
            $telefone = @$_POST['telefone'];
            if(strlen($telefone) == 15 && strlen($cpf) == 14) {
                if(validaCPF($cpf)) {
                    $alteracao = "UPDATE usuarios SET nome = '$nome', email = '$email', senha = '$senha', cpf = '$cpf', telefone = '$telefone' WHERE id = '$id';";
                    $altera = $conexao->query($alteracao);
                    
                    if($altera) {
                        $log = "
                            <div class='col-11 col-md-8 col-lg-6'>
                                <p class='m-0 d-flex justify-content-center align-items-center h-100 py-2 rounded text-center' style='background-color: #d4edda; color: #155724;'>Alteração feita com sucesso!</p>
                            </div>
                        ";
                    } else {
                        $log = "
                            <div class='col-11 col-md-8 col-lg-6'>
                                <p class='m-0 d-flex justify-content-center align-items-center h-100 py-2 rounded text-center' style='background-color: #f8d7da; color: #721c24;'>Erro na alteração!</p>
                            </div>
                        ";
                    }
                } else {
                    $log = "
                        <div class='col-11 col-md-8 col-lg-6'>
                            <p class='m-0 d-flex justify-content-center align-items-center h-100 py-2 rounded text-center' style='background-color: #f8d7da; color: #721c24;'>CPF informado não é real!</p>
                        </div>
                    ";
                }
            } elseif (strlen($telefone) == 15) {
                $log = "
                    <div class='col-11 col-md-8 col-lg-6'>
                        <p class='m-0 d-flex justify-content-center align-items-center h-100 py-2 rounded text-center' style='background-color: #f8d7da; color: #721c24;'>CPF inválido!</p>
                    </div>
                ";
            } elseif (strlen($cpf) == 14) {
                $log = "
                    <div class='col-11 col-md-8 col-lg-6'>
                        <p class='m-0 d-flex justify-content-center align-items-center h-100 py-2 rounded text-center' style='background-color: #f8d7da; color: #721c24;'>Telefone inválido!</p>
                    </div>
                ";
            } else {
                $log = "
                    <div class='col-11 col-md-8 col-lg-6'>
                        <p class='m-0 d-flex justify-content-center align-items-center h-100 py-2 rounded text-center' style='background-color: #f8d7da; color: #721c24;'>CPF e Telefone inválidos!</p>
                    </div>
                ";
            }
        }
        $_SESSION['log'] = $log;
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
</head>
<body class="vh-100 overflow-hidden">
    <div class="w-100 d-flex justify-content-between" style="height: 13vh; background-color: #2c2c2e;">
        <div class="h-100 w-auto d-flex align-items-center ms-4">
            <span class="fs-2 fw-bold pb-2 text-white">Settings</span>
        </div>
        <div class="h-100 w-auto d-flex align-items-center me-4 gap-4">
            <a href="home.php" class="text-decoration-none border-0 text-white"><i class="fa-solid fa-share fa-flip-horizontal fs-5" title="Voltar"></i></a>
        </div>
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
                <h1 class="text-black"> > > Edit Profile</h1>
            </div>
            <div class="mt-4 ms-2 ms-md-4 ms-xxl-5">
                <form action="" method="POST" class="row d-flex flex-column gap-2">
                    <?php if ($log): ?>
                        <?php echo $log; ?>
                    <?php endif; ?>
                    <div class="col-11 col-md-8 col-lg-6 mt-2">
                        <div class="input-group rounded-3 border border-2 border-dark border-opacity-25">
                            <label for="nome" class="input-group-text bg-transparent border-0 text-decoration-none" style="cursor: text;"><i class="fa-solid fa-user"></i></label>
                            <input type="text" name="nome" id="nome" class="form-control bg-transparent border-0 shadow-none text-secondary" value="<?php echo"$nome"; ?>">
                        </div>
                    </div>
                    <div class="col-11 col-md-8 col-lg-6">
                        <div class="input-group rounded-3 border border-2 border-dark border-opacity-25">
                            <label for="cpf" class="input-group-text bg-transparent border-0 text-decoration-none" style="cursor: text;"><i class="fa-solid fa-address-card"></i></label>
                            <input type="text" name="cpf" id="cpf" class="form-control bg-transparent border-0 shadow-none text-secondary" value="<?php echo"$cpf"; ?>" maxlength="14" oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2')">
                        </div>
                    </div>
                    <div class="col-11 col-md-8 col-lg-6">
                        <div class="input-group rounded-3 border border-2 border-dark border-opacity-25">
                            <label for="telefone" class="input-group-text bg-transparent border-0 text-decoration-none" style="cursor: text;"><i class="fa-solid fa-phone"></i></label>
                            <input type="text" name="telefone" id="telefone" class="form-control bg-transparent border-0 shadow-none text-secondary" value="<?php echo"$telefone"; ?>" maxlength="15" oninput="this.value = this.value.replace(/\D/g, '').replace(/^(\d{2})(\d)/g, '($1) $2').replace(/(\d{5})(\d{4})$/, '$1-$2')">
                        </div>
                    </div>
                    <div class="col-11 col-md-8 col-lg-6">
                        <div class="input-group rounded-3 border border-2 border-dark border-opacity-25">
                            <label for="email" class="input-group-text bg-transparent border-0 text-decoration-none" style="cursor: text;"><i class="fa-solid fa-envelope"></i></label>
                            <input type="email" name="email" id="email" class="form-control bg-transparent border-0 shadow-none text-secondary" value="<?php echo"$email"; ?>">
                        </div>
                    </div>
                    <div class="col-11 col-md-8 col-lg-6 mb-1">
                        <div class="input-group rounded-3 border border-2 border-dark border-opacity-25">
                            <button class="input-group-text bg-transparent border-0 text-decoration-none" type="button" onclick="exibirSenha()"><i id="iconeSenha" class="fa-solid fa-lock"></i></button>
                            <input type="password" name="senha" id="senha" class="form-control bg-transparent border-0 shadow-none text-secondary" value="<?php echo"$senha"; ?>">
                        </div>
                    </div>
                    <div class="col-11 col-md-8 col-lg-6 mt-2">
                        <input type="submit" name="submit" class="w-100 rounded-3 btn btn-success" value="Alterar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function exibirSenha() {
            const botaoEye = document.getElementById("senha");
            const iconeEye = document.getElementById("iconeSenha");
            botaoEye.type = botaoEye.type === "password" ? "text" : "password";
            iconeEye.className = botaoEye.type === "password" ? "fa-solid fa-lock" : "fa-solid fa-lock-open";
        }
    </script>
</body>
</html>