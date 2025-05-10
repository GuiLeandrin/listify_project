<?php
    include 'funcoes.php';
    session_start();
    $id = @$_SESSION['id'];
    $idLista = '';
    $total = 0;
    $contadorListas = 0;
    $contadorItens = 0;

    if($id) {
        $conexao = new mysqli("localhost", "root", "", "listify");
        $sqlLista = "SELECT * FROM listas WHERE id_usuario = '$id';";
        $listas = $conexao->query($sqlLista);
        $contadorListas = ($listas->num_rows) + 1;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $recebeIdLista = @$_POST['id_lista'];
            $recebeIdItem = @$_POST['id_item'];

            if(isset($_POST['salvar_novo_nome'])) {
                $nomeListaNovo = @$_POST['novo_nome_lista'];
                $sqlNomeLista = "UPDATE listas SET nome = '$nomeListaNovo' WHERE id = '$recebeIdLista';";
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
                $sqlDelLista = "DELETE FROM listas WHERE id = '$recebeIdLista';";
                $delLista = $conexao->query($sqlDelLista);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }

            if(isset($_POST['adicionar_item'])) {
                $sqlContaItens = "SELECT * FROM itens WHERE id_lista = '$recebeIdLista';";
                $contaItens = $conexao->query($sqlContaItens);
                $contadorItens = ($contaItens->num_rows) + 1;

                $sqlAddItem = "INSERT INTO itens (nome, link, valor, id_lista) VALUES ('Novo Item #$contadorItens', NULL, 0, '$recebeIdLista');";
                $addItem = $conexao->query($sqlAddItem);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }

            if(isset($_POST['salvar_infos_item'])) {
                if($_POST['novo_nome_item']) {
                    $nomeItemNovo = @$_POST['novo_nome_item'];
                    $linkItemNovo = @$_POST['novo_link_item'];
                    $valorItemNovo = @$_POST['novo_valor_item'];
                    $sqlInfosItem = "UPDATE itens SET nome = '$nomeItemNovo', link = '$linkItemNovo', valor = '$valorItemNovo' WHERE id = '$recebeIdItem';";
                    $updateInfosItem = $conexao->query($sqlInfosItem);
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }
            }

            if(isset($_POST['confirma_excluir_item'])) {
                $sqlDelItem = "DELETE FROM itens WHERE id = '$recebeIdItem';";
                $delItem = $conexao->query($sqlDelItem);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }

            if(isset($_POST['check_item'])) {
                $sqlOnStatus = "UPDATE itens SET status = 1 WHERE id = '$recebeIdItem';";
                $onStatus = $conexao->query($sqlOnStatus);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }

            
            if(isset($_POST['uncheck_item'])) {
                $sqlOffStatus = "UPDATE itens SET status = 0 WHERE id = '$recebeIdItem';";
                $offStatus = $conexao->query($sqlOffStatus);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
            
            if(isset($_POST['voltar_home'])) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }
    } else {
        header("Location: login.php");
        exit;
    }

    if(isset($_POST['logout'])) {
        unset($_SESSION['id']);
        header("Location: login.php");
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
        html {
            scroll-behavior: smooth;
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
                    $totalItens = $itens->num_rows;
                    
                    $sqlCheckItens = "SELECT COUNT(*) FROM itens WHERE id_lista = '$idLista' AND status = 1";
                    $ItensCheck = $conexao->query($sqlCheckItens)->fetch_row()[0];
                ?>
                <div class="table-responsive shadow-lg rounded mb-5">
                    <table class="table table-striped table-hover mb-0">
                        <?php if(isset($_POST['excluir_lista']) && $_POST['id_lista'] == $idLista): ?>
                            <thead id="lista_<?php echo $idLista; ?>" class="table-danger">
                        <?php elseif (isset($_POST['editar_lista']) && $_POST['id_lista'] == $idLista): ?>
                            <thead id="lista_<?php echo $idLista; ?>" class="table-success">
                        <?php elseif ($totalItens > 0 && $totalItens == $ItensCheck): ?>
                            <thead id="lista_<?php echo $idLista; ?>" class="table-success">
                        <?php else: ?>
                            <thead id="lista_<?php echo $idLista; ?>" class="table-primary">
                        <?php endif; ?>
                                <form action="#lista_<?php echo $idLista; ?>" method="POST">
                                    <input type="hidden" name="id_lista" value="<?php echo $idLista; ?>">
                                    <tr>
                                        <?php if(isset($_POST['editar_lista']) && $_POST['id_lista'] == $idLista): ?>
                                            <th class="p-3 align-middle fs-5" colspan="2">
                                                <input type="text" class="fw-bold border-0 my-2 bg-transparent w-100" maxlength="20" style="max-width: 300px; outline: none;" placeholder="Digite o novo nome..." id="input_nome" name="novo_nome_lista">
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
                                <?php $idItem = $usuarioItem['id']; ?>
                                <?php $statusItem = (bool)$usuarioItem['status']; ?>
                                <form action="#item_<?php echo $idItem; ?>" method="POST">
                                    <input type="hidden" name="id_lista" value="<?php echo $idLista; ?>">
                                    <input type="hidden" name="id_item" value="<?php echo $idItem; ?>">
                                    <?php if ($statusItem): ?>
                                        <tr id="item_<?php echo $idItem; ?>">
                                            <td style="max-width: 80px;" class="text-truncate text-secondary align-middle text-decoration-line-through"><?php echo $usuarioItem['nome']; ?></td>
                                            <td style="max-width: 80px;" class="text-truncate text-secondary align-middle text-decoration-line-through"><?php echo $usuarioItem['link']; ?></td>
                                            <td class="align-middle text-secondary text-decoration-line-through"><?php echo "R$ " . $usuarioItem['valor']; ?></td>
                                            <td class="gap-1 align-middle">
                                                <button name="uncheck_item" class="px-2 text-decoration-none border-0 rounded shadow" title="Desmarcar"><i class="fa-solid fa-xmark"></i></button>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php if((isset($_POST['editar_item']) || isset($_POST['voltar_editar_item'])) && $_POST['id_item'] == $idItem): ?>
                                            <tr id="item_<?php echo $idItem; ?>">
                                                <td class="text-break align-middle" style="background-color: #d6ede4;">
                                                    <input value="<?php echo $usuarioItem['nome']; ?>" type="text" class="my-2 text-center fw-bold border-0 bg-transparent w-100" style="max-width: 150px; outline: none;" placeholder="Nome..." id="input_nome" name="novo_nome_item">
                                                </td>
                                                <td class="text-break align-middle" style="background-color: #d6ede4;">
                                                    <input value="<?php echo $usuarioItem['link']; ?>" type="text" class="text-center fw-bold border-0 bg-transparent w-100" style="max-width: 150px; outline: none;" placeholder="Link..." name="novo_link_item">
                                                <td class="align-middle" style="background-color: #d6ede4;">
                                                    <input value="<?php echo $usuarioItem['valor']; ?>" type="number" step="0.01" class="text-center fw-bold border-0 bg-transparent w-100" style="max-width: 150px; outline: none;" placeholder="Valor..." name="novo_valor_item">
                                                </td>
                                                <td class="gap-1 align-middle" style="background-color: #d6ede4;">
                                                    <button name="salvar_infos_item" class="text-decoration-none px-3 border-0 rounded bg-success text-white shadow" title="Salvar Alterações"><i class="fa-solid fa-check"></i></button>
                                                    <button name="voltar_home" class="mt-1 mt-md-0 px-3 text-decoration-none border-0 rounded bg-secondary text-white shadow" title="Voltar"><i class="fa-solid fa-share fa-flip-horizontal"></i></button>
                                                </td>
                                            </tr>
                                        <?php elseif(isset($_POST['salvar_infos_item']) && $_POST['id_item'] == $idItem): ?>
                                            <?php if(!$_POST['novo_nome_item']): ?>
                                                <tr id="item_<?php echo $idItem; ?>">
                                                    <td style="background-color: #f8d7da;" colspan="3">
                                                        <h4 class="m-0 my-1 ms-3 text-start text-danger">Nome do item não preenchido!</h4>
                                                    </td>
                                                    <td style="background-color: #f8d7da;" class="gap-1 align-middle">
                                                        <button name="voltar_editar_item" class="px-5 text-decoration-none border-0 rounded bg-secondary text-white shadow" title="Voltar"><i class="fa-solid fa-share fa-flip-horizontal"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php elseif(isset($_POST['excluir_item']) && $_POST['id_item'] == $idItem): ?>
                                            <tr id="item_<?php echo $idItem; ?>">
                                                <td style="background-color: #f8d7da;" colspan="3">
                                                    <h4 class="m-0 my-1 ms-3 text-start text-danger">Deseja mesmo excluir esse item?</h4>
                                                </td>
                                                <td style="background-color: #f8d7da;" class="gap-1 align-middle">
                                                    <button name="confirma_excluir_item" class="text-decoration-none px-3 border-0 rounded bg-danger text-white shadow" title="Confirmar Exclusão de Item"><i class="fa-solid fa-trash"></i></button>
                                                    <button name="voltar_home" class="mt-1 mt-md-0 px-3 text-decoration-none border-0 rounded bg-secondary text-white shadow" title="Voltar"><i class="fa-solid fa-share fa-flip-horizontal"></i></button>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <tr id="item_<?php echo $idItem; ?>">
                                                <td style="max-width: 80px;" title="<?php echo $usuarioItem['nome']; ?>" class="text-truncate align-middle"><?php echo $usuarioItem['nome']; ?></td>
                                                <td style="max-width: 80px" title="<?php echo $usuarioItem['link']; ?>" class="text-truncate align-middle">
                                                    <a href="<?php echo $usuarioItem['link']; ?>" target="_blank"><?php echo $usuarioItem['link']; ?></a>
                                                </td>
                                                <td class="align-middle"><?php echo "R$ " . $usuarioItem['valor']; ?></td>
                                                <td class="gap-1 align-middle">
                                                    <button name="check_item" class="px-2 p-1 text-decoration-none border-0 rounded shadow" title="Concluído"><i class="fa-solid fa-check"></i></button>
                                                    <button name="editar_item" class="text-dark p-1 px-2 text-decoration-none border-0 rounded shadow" title="Editar Item"><i class="fa-solid fa-pen"></i></button>
                                                    <button name="excluir_item" class="mt-1 mt-md-0 text-dark p-1 px-2 text-decoration-none border-0 rounded shadow" title="Excluir Item"><i class="fa-solid fa-minus"></i></button>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if(!$statusItem): ?>
                                        <?php $total = $total + $usuarioItem['valor']; ?>
                                    <?php else: ?>
                                        <?php $total = $total; ?>
                                    <?php endif; ?>
                                </form>
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
            <form action="#lista_<?php echo $idLista; ?>" method="POST">
                <div class="w-100 mb-5">
                    <button name="adicionar_lista" class="w-100 btn btn-success text-white p-2"><i class="fa-solid fa-plus pe-2"></i>Adicionar Nova Lista</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        window.onload = function () {
            const inputNome = document.getElementById("input_nome");
            if (inputNome) {
                inputNome.focus();
            }
        };
        setTimeout(() => {
            if (window.location.hash.startsWith("#lista_") || window.location.hash.startsWith("#item_")) {
                history.replaceState(null, null, window.location.pathname);
            }
        }, 100);
    </script>
</body>
</html>