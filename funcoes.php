<?php
    //INÍCIO FUNÇÃO VERIFICAÇÃO CPF REAL
    function validaCPF($cpf) {
        // Extrai somente os números
        $calculoCpf = preg_replace( '/[^0-9]/is', '', $cpf );
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $calculoCpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($i = 9; $i < 11; $i++) {
            for ($resultadoCpf = 0, $n = 0; $n < $i; $n++) {
                $resultadoCpf += $calculoCpf[$n] * (($i + 1) - $n);
            }
            $resultadoCpf = ((10 * $resultadoCpf) % 11) % 10;
            if ($calculoCpf[$n] != $resultadoCpf) {
                return false;
            }
        }
        return true;
    }
    //FIM FUNÇÃO VERIFICAÇÃO CPF REAL

    //INÍCIO FUNÇÃO CRIAÇÃO DE VARIÁVEIS DE (FRASE), (TEXTO DO DELETE) E (VERIFICAÇÃO DO DELETE)
    function verificaDelete($email) {
        // Cria a frase de verificações com os padrões
        $inicioFrase = substr(explode('@', $email)[0], 0, 10);
        $_SESSION['frase'] = "$inicioFrase/confirmExclusion";
        // Cria a variável do texto da Confirmação
        $txtConfirmaExcluir = "
            <div class='h-auto w-auto mt-3 ms-2 ms-md-4 ms-xxl-5 gap-3'>
                <div class='h-auto w-75 mt-3 ms-2 ms-md-4 ms-xxl-5'>
                    <div class='h-auto w-100'>
                        <p style='text-align: justify;'>Para prosseguir com a exclusão da sua conta, por favor digite a frase de confirmação padrão mostrada abaixo no campo de texto designado:  (" . $_SESSION['frase'] . ")</p>
                    </div>
                </div>
            </div>
        ";
        // Cria a variável da Confirmação
        $confirmaExcluir = "                
            <form action='' method='POST' class='h-auto w-auto mt-2 ms-2 ms-md-4 ms-xxl-5 gap-3'>
                <div class='h-auto w-75 mt-2 ms-2 ms-md-4 ms-xxl-5'> 
                    <div class='h-auto w-100 d-flex flex-column align-items-center justify-content-center gap-3'>
                        <input type='text' name='fraseConfirm' class='form-control bg-white border-2' placeholder='xxxxxxxx/confirmExclusion'>
                        <input type='submit' name='confirmDelete' class='w-100 btn btn-danger mb-3' value='Confirm Delete'>
                    </div>
                </div>
            </form>
        ";
        // Retorna variaveis dividas em blocos
        return ['bloco_texto' => $txtConfirmaExcluir, 'formulario_verifica' => $confirmaExcluir];
    }
    //FIM FUNÇÃO CRIAÇÃO DE VARIÁVEIS DE (FRASE), (TEXTO DO DELETE) E (VERIFICAÇÃO DO DELETE)

    //INÍCIO FUNÇÃO QUE VERIFICA SE OS ITENS SÃO CHECKADOS
    function checkItens($conexao, $idLista, $itens) {
        $sqlCheckItens = "SELECT COUNT(*) FROM itens WHERE id_lista = '$idLista' AND status = 1";
        $resultadoCheck = $conexao->query($sqlCheckItens);
        $totalItens = $itens->num_rows;

        if($resultadoCheck == $totalItens){
            return true;
        } else {
            return false;
        }
    }
    //FIM FUNÇÃO QUE VERIFICA SE OS ITENS SÃO CHECKADOS
?>