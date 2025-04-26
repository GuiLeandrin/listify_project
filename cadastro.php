<?php
    include 'funcoes.php';
    session_start();
    $log = @$_SESSION['log'];
    unset($_SESSION['log']);

    if(isset($_POST['submit'])) {
        $conexao = new mysqli("localhost", "root", "", "website");
        $nome = $_POST['nome_desktop'] ?? $_POST['nome_mobile'] ?? '';
        $telefone = $_POST['telefone_desktop'] ?? $_POST['telefone_mobile'] ?? '';
        $cpf = $_POST['cpf_desktop'] ?? $_POST['cpf_mobile'] ?? '';
        $email = $_POST['email_desktop'] ?? $_POST['email_mobile'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $confirma = $_POST['confirma'] ?? '';  

        if($nome && $telefone && $cpf && $email && $senha && $confirma) {
            if(strlen($telefone) == 15 && strlen($cpf) == 14) {
                if(validaCPF($cpf)) {
                    if($senha == $confirma) {
                        $sql = "SELECT * FROM usuarios WHERE email = '$email' OR cpf = '$cpf';";
                        $verifica = $conexao->query($sql);
                        $usuario = $verifica->fetch_assoc();
    
                        if($usuario['cpf'] != $cpf && $usuario['email'] != $email) {
                            $inserir = "INSERT INTO usuarios (nome, email, senha, cpf, telefone) VALUES ('$nome', '$email', '$senha', '$cpf', '$telefone');";
                            $inserirCadastro = $conexao->query($inserir);
    
                            if($inserirCadastro == true) {
                                $log = "
                                    <div class='rounded text-center w-100 p-2' style='background-color: #d4edda; color: #155724;'>
                                        <p class='m-0 d-flex justify-content-center align-items-center h-100'>Usuário Cadastrado com sucesso!!</p>
                                    </div>
                                ";
                            } else {    
                                $log = "
                                    <div class='rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                                        <p class='m-0 d-flex justify-content-center align-items-center h-100'>Erro no Cadastro</p>
                                    </div>
                                ";
                            }
                        } elseif ($usuario['cpf'] != $cpf) {
                            $log = "
                                <div class='rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                                    <p class='m-0 d-flex justify-content-center align-items-center h-100'>E-mail já cadastrado</p>
                                </div>
                            ";
                        } elseif ($usuario['email'] != $email) {
                            $log = "
                                <div class='rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                                    <p class='m-0 d-flex justify-content-center align-items-center h-100'>CPF já cadastrado</p>
                                </div>
                            ";
                        } else {
                            $log = "
                                <div class='rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                                    <p class='m-0 d-flex justify-content-center align-items-center h-100'>CPF e E-mail já cadastrados</p>
                                </div>
                            ";
                        }
                    } else {
                        $log = "
                            <div class='rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                                <p class='m-0 d-flex justify-content-center align-items-center h-100'>Senhas informadas divergentes</p>
                            </div>
                        ";
                    }
                } else {
                    $log = "
                        <div class='rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                            <p class='m-0 d-flex justify-content-center align-items-center h-100'>CPF informado não é real</p>
                        </div>
                    ";
                }
            } elseif (strlen($telefone) == 15) {
                $log = "
                    <div class='rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                        <p class='m-0 d-flex justify-content-center align-items-center h-100'>CPF inválido</p>
                    </div>
                ";
            } elseif (strlen($cpf) == 14) {
                $log = "
                    <div class='rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                        <p class='m-0 d-flex justify-content-center align-items-center h-100'>Telefone inválido</p>
                    </div>
                ";
            } else {
                $log = "
                    <div class='rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                        <p class='m-0 d-flex justify-content-center align-items-center h-100'>Telefone e CPF inválidos</p>
                    </div>
                ";
            }
        } else {
            $log = "
                <div class='rounded text-center w-100 p-2' style='background-color: #f8d7da; color: #721c24;'>
                    <p class='m-0 d-flex justify-content-center align-items-center h-100'>Formulário não preenchido corretamente</p>
                </div>
            ";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="favicon.png">
    <script src="https://kit.fontawesome.com/576a6b1350.js" crossorigin="anonymous"></script>
    <title>Cadastro</title>

</head>
<body class="vh-100 d-flex align-items-center justify-content-center p-2 row overflow-hidden" style="background: linear-gradient(45deg, #f0f0f0, #d6d6d6);">
    <div class="bg-white shadow-lg rounded-5 d-flex flex-column align-items-center col-md-5 col-sm-7 col-9 p-5" style="min-height: 400px; padding: 2rem 0;">
        <div class="w-100 pb-4 d-flex align-items-center justify-content-center border-bottom border-5 border-black mb-4">
                <h1>Cadastro</h1>
        </div>
        <?php if ($log): ?>
            <?php echo $log; ?>
        <?php endif; ?>
        <form action=""  method="POST" class="mt-3">
            <div class="row g-2">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="input-group rounded-1 border border-2 border-dark border-opacity-25">
                        <label for="nome_desktop" class="input-group-text bg-transparent border-0 text-decoration-none d-none d-sm-block" style="cursor: text;"><i class="fa-solid fa-user"></i></label>
                        <label for="nome_mobile" class="input-group-text bg-transparent border-0 text-decoration-none d-block d-sm-none" style="cursor: text;"><i class="fa-solid fa-user"></i></label>
                        <input type="text" class="form-control bg-transparent border-0 shadow-none d-none d-sm-block" placeholder="Digite seu Nome:" name="nome_desktop" id="nome_desktop">
                        <input type="text" class="form-control bg-transparent border-0 shadow-none d-block d-sm-none" placeholder="Nome:" name="nome_mobile" id="nome_mobile">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="input-group rounded-1 border border-2 border-dark border-opacity-25">
                        <label for="telefone_desktop" class="input-group-text bg-transparent border-0 text-decoration-none d-none d-sm-block" style="cursor: text;"><i class="fa-solid fa-phone"></i></label>
                        <label for="telefone_mobile" class="input-group-text bg-transparent border-0 text-decoration-none d-block d-sm-none" style="cursor: text;"><i class="fa-solid fa-phone"></i></label>
                        <input type="text" class="form-control bg-transparent border-0 shadow-none d-none d-sm-block" name="telefone_desktop" id="telefone_desktop" maxlength="15" placeholder="Digite seu Telefone:" oninput="this.value = this.value.replace(/\D/g, '').replace(/^(\d{2})(\d)/g, '($1) $2').replace(/(\d{5})(\d{4})$/, '$1-$2')">
                        <input type="text" class="form-control bg-transparent border-0 shadow-none d-block d-sm-none" name="telefone_mobile" id="telefone_mobile" maxlength="15" placeholder="Telefone:" oninput="this.value = this.value.replace(/\D/g, '').replace(/^(\d{2})(\d)/g, '($1) $2').replace(/(\d{5})(\d{4})$/, '$1-$2')">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="input-group rounded-1 border border-2 border-dark border-opacity-25">
                        <label for="cpf_desktop" class="input-group-text bg-transparent border-0 text-decoration-none d-none d-sm-block" style="cursor: text;"><i class="fa-solid fa-address-card"></i></label>
                        <label for="cpf_mobile" class="input-group-text bg-transparent border-0 text-decoration-none d-block d-sm-none" style="cursor: text;"><i class="fa-solid fa-address-card"></i></label>
                        <input type="text" class="form-control bg-transparent border-0 shadow-none d-none d-sm-block" name="cpf_desktop" id="cpf_desktop" maxlength="14" placeholder="Digite seu CPF:" oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2')">
                        <input type="text" class="form-control bg-transparent border-0 shadow-none d-block d-sm-none" name="cpf_mobile" id="cpf_mobile" maxlength="14" placeholder="CPF:" oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2')">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                <div class="input-group rounded-1 border border-2 border-dark border-opacity-25">
                        <label for="email_desktop" class="input-group-text bg-transparent border-0 text-decoration-none d-none d-sm-block" style="cursor: text;"><i class="fa-solid fa-envelope"></i></label>
                        <label for="email_mobile" class="input-group-text bg-transparent border-0 text-decoration-none d-block d-sm-none" style="cursor: text;"><i class="fa-solid fa-envelope"></i></label>
                        <input type="email" class="form-control bg-transparent border-0 shadow-none d-none d-sm-block" placeholder="Digite seu E-mail:" name="email_desktop" id="email_desktop">
                        <input type="email" class="form-control bg-transparent border-0 shadow-none d-block d-sm-none" placeholder="E-mail:" name="email_mobile" id="email_mobile">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="input-group rounded-1 border border-2 border-dark border-opacity-25">
                        <label for="senha" class="input-group-text bg-transparent border-0 text-decoration-none" style="cursor: text;"><i class="fa-solid fa-lock"></i></label>
                        <input type="password" class="form-control bg-transparent border-0 shadow-none" placeholder="Senha:" name="senha" id="senha">
                        <button class="input-group-text bg-transparent border-0 text-decoration-none" type="button" onclick="exibirSenha('senha', 'iconeSenha')"><i id="iconeSenha" class="fa-solid fa-eye"></i></button>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12 mb-3">
                    <div class="input-group rounded-1 border border-2 border-dark border-opacity-25">
                        <label for="confirma" class="input-group-text bg-transparent border-0 text-decoration-none" style="cursor: text;"><i class="fa-solid fa-lock"></i></label>
                        <input type="password" class="form-control bg-transparent border-0 shadow-none" placeholder="Confirmar:" name="confirma" id="confirma">
                        <button class="input-group-text bg-transparent border-0 text-decoration-none" type="button" onclick="exibirSenha('confirma', 'iconeConfirma')"><i id="iconeConfirma" class="fa-solid fa-eye"></i></button>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center justify-content-center mt-3 mb-3">
                <div class="w-100 d-flex gap-2">
                    <a href="index.php" class="btn btn-primary w-100">Login</a>
                    <input type="submit" name="submit" class="btn btn-primary w-100" value="Cadastrar">
                </div>
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