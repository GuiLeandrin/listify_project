<?php
    session_start();
    $id = @$_SESSION['id'];
    $log = @$_SESSION['log'];
    $idLista = '';
    $total = 0;
    $contadorListas = 0;

    if($id) {
        $conexao = new mysqli("localhost", "root", "", "website");
        $sqlLista = "SELECT * FROM listas WHERE id_usuario = '$id';";
        $listas = $conexao->query($sqlLista);
        $contadorListas = ($listas->num_rows) + 1;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verificaIdLista = @$_POST['id_lista'];

            if(isset($_POST['salvar_novo_nome'])) {
                $nomeNovo = @$_POST['novo_nome_lista'];
                $sqlNomeLista = "UPDATE listas SET nome = '$nomeNovo' WHERE id = '$verificaIdLista';";
                $updateNovoNome = $conexao->query($sqlNomeLista);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }

            if(isset($_POST['adicionar_lista'])) {
                $sqlAddLista = "INSERT INTO listas (nome, id_usuario) VALUES ('Nova Lista #$contadorListas', '$id');";
                $addLista = $conexao->query($sqlAddLista);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }

            if(isset($_POST['confirma_excluir_lista'])) {
                $sqlDelLista = "DELETE FROM listas WHERE id = '$verificaIdLista';";
                $delLista = $conexao->query($sqlDelLista);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }

            if(isset($_POST['voltar_home'])) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }
    } else {
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
            <?php while ($usuarioLista = $listas->fetch_assoc()): ?>
                <?php 
                    $idLista = $usuarioLista['id']; 
                    $sqlItem = "SELECT * FROM itens WHERE id_lista = '$idLista';";
                    $itens = $conexao->query($sqlItem);
                ?>
                <div class="table-responsive shadow-lg rounded mb-5">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-primary">
                            <form action="" method="POST">
                                <input type="hidden" name="id_lista" value="<?php echo $idLista; ?>">
                                <tr>
                                    <?php if(isset($_POST['editar_lista']) && $_POST['id_lista'] == $idLista): ?>
                                        <th class="p-3 align-middle fs-5" colspan="2">
                                            <input type="text" class="border-0 bg-transparent w-100" value="<?php echo $usuarioLista['nome']; ?>" maxlength="20" style="max-width: 300px; outline: none;" placeholder="Digite o novo nome..." name="novo_nome_lista">
                                        </th>
                                        <th class="p-3 align-middle" colspan="2">
                                            <div class="d-flex justify-content-end gap-1">
                                                <button name="salvar_novo_nome" class="text-decoration-none px-4 border-0 rounded bg-success text-white shadow" title="Salvar Novo Nome"><i class="fa-solid fa-check"></i></button>
                                                <button name="voltar_home" class="px-4 text-decoration-none border-0 rounded bg-secondary text-white shadow" title="Voltar"><i class="fa-solid fa-share fa-flip-horizontal"></i></button>
                                            </div>
                                        </th>
                                    <?php elseif (isset($_POST['excluir_lista']) && $_POST['id_lista'] == $idLista): ?>
                                        <th class="text-danger p-3" colspan="2">
                                            <h3 class="my-2 m-0 fw-bold">Deseja mesmo excluir essa lista?</h3>
                                        </th>
                                        <th class="p-3 align-middle" colspan="2">
                                            <div class="d-flex justify-content-end gap-1">
                                                <button name="confirma_excluir_lista" class="text-decoration-none px-4 border-0 rounded bg-danger text-white shadow" title="Confirmar Exclusão de Lista"><i class="fa-solid fa-trash"></i></button>
                                                <button name="voltar_home" class="px-4 text-decoration-none border-0 rounded bg-secondary text-white shadow" title="Voltar"><i class="fa-solid fa-share fa-flip-horizontal"></i></button>
                                            </div>
                                        </th>
                                    <?php else: ?>
                                        <th class="p-3 align-middle fs-3" colspan="2">
                                            <?php echo $usuarioLista['nome']; ?>
                                        </th>
                                        <th class="p-3 align-middle" colspan="2">
                                            <div class="d-flex flex-column justify-content-end gap-1">
                                                <div class="d-flex justify-content-end gap-1">
                                                    <button name="editar_lista" class="px-4 text-decoration-none border-0 rounded bg-primary text-white shadow" title="Editar Nome da Lista"><i class="fa-solid fa-pencil"></i></button>
                                                    <button name="excluir_lista" class="px-4 text-decoration-none border-0 rounded bg-primary text-white shadow" title="Excluir Lista"><i class="fa-solid fa-trash"></i></button>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button name="adicionar_item" class="text-decoration-none border-0 rounded bg-secondary text-white shadow" title="Adicionar Novo Item" style="width: 130px;"><i class="fa-solid fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </th>
                                    <?php endif; ?>
                                </tr>
                            </form>
                        </thead>
                        <tbody class="table-group-divider text-center">
                            <tr class="fw-bold">
                                <td class="w-25 text-decoration-underline">Nome:</td>
                                <td class="w-25 text-decoration-underline">Link:</td>
                                <td class="w-25 text-decoration-underline">Valor:</td>
                                <td class="w-25 align-middle"><i class="fa-solid fa-gears"></i>:</td>
                            </tr>
                            <?php $total = 0; ?>
                            <?php while ($usuarioItem = $itens->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-break align-middle"><?php echo $usuarioItem['nome']; ?></td>
                                    <td class="text-break align-middle"><?php echo $usuarioItem['link']; ?></td>
                                    <td class="align-middle"><?php echo $usuarioItem['valor']; ?></td>
                                    <td class="gap-1 align-middle">
                                        <form method="POST" action="">
                                            <button name="check_item" class="px-2 text-decoration-none border-0 rounded shadow" title="Concluído"><i class="fa-solid fa-check"></i></button>
                                            <button name="editar_item" class="text-dark p-1 px-2 text-decoration-none border-0 rounded shadow" title="Editar Item"><i class="fa-solid fa-pen"></i></button>
                                            <button name="excluir_item" class="text-dark p-1 px-2 text-decoration-none border-0 rounded shadow" title="Excluir Item"><i class="fa-solid fa-minus"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                                    $total = $total + $usuarioItem['valor'];
                                ?>
                            <?php endwhile; ?>
                            <?php if ($itens->num_rows > 0): ?>
                                <tr class="fw-bold align-middle">
                                    <td class="text-decoration-underline text-secondary">Total:</td>
                                    <td></td>
                                    <td class="text-secondary"><?php echo "R$ " . number_format($total, 2, ',', '.'); ?></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endwhile; ?>
            <form action="" method="POST">
                <div class="w-100 mb-5">
                    <button name="adicionar_lista" class="w-100 btn btn-success text-white p-2"><i class="fa-solid fa-plus pe-2"></i>Adicionar Nova Lista</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>