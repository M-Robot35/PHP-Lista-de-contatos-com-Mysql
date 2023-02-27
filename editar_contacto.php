<?php
require_once('header.php');

$total_count = 0;
$erro= null;


// ======================================================
// Atualiza o usuario e redireciona ao index
// ======================================================
if($_SERVER['REQUEST_METHOD']== "POST"){
    $id = $_POST['id'];
    
    // selecionando o usuario 
    $parametros =[
        ":id" => $id
    ];
    
    $sql= "SELECT * FROM contactos WHERE id=:id";
    $usuario = $connect->execute_query($sql, $parametros);
    $total_count = $usuario->affected_rows;
    $oldUser= $usuario->results[0];

    $newUsuario = $_POST['text_nome'];
    $newTelefone = $_POST['text_telefone'];

    $params= [
        ":id" => $id,
        ":nome" => $newUsuario,
        ":telefone" => $newTelefone
    ];
    
    $query= "UPDATE contactos SET nome =:nome,  telefone= :telefone, updated_at= NOW() WHERE id= :id";
    $result= $connect->execute_non_query($query,$params);
    echo "sucess";
}


// ======================================================
// REDIRECIONA CASO ID ESTIVER VAZIO OU  NÃO HAVER KEY ID
// ======================================================
if(!key_exists('id', $_GET ) || empty($_GET['id']) ){
    header('Location: index.php');
}

// =======================================
// Capturar Parametros da Url
// ========================================
if(key_exists('id', $_GET ) || !empty($_GET['id'])){  

    $usuario_id = $_GET['id'];
    
    $parametros =[
        ":id" => $usuario_id
    ];
    
    $sql= "SELECT * FROM contactos WHERE id=:id";
    $usuario = $connect->execute_query($sql, $parametros);
    $total_count = $usuario->affected_rows;    
    $ver= $usuario->results[0];  
    
    // =======================================
    // Redireciona caso o usuario não exista
    // ========================================
    if(empty($total_count)){
        header('Location: index.php');
    }    
}
else{
    header('Location: index.php');
    die('Acesso Negado');
}

?>

<div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-10">

        <div class="card p-4">
            <!-- Para enviar o ID pela URL caso queira-->
            <!-- <form action="editar_contacto.php?id=<?= $id ?>" method="post"> -->

            <form action="editar_contacto.php" method="post">
                <p class="text-center"><strong>EDITAR CONTACTO</strong></p>
                <div class="mb-3">
                    <label for="text_nome" class="form-label">Nome</label>
                    <input type="text" name="text_nome" id="text_nome" class="form-control" minlength="3" maxlength="50" required value=" <?= $ver->nome?>">
                </div>
                <div class="mb-3">
                    <label for="text_telefone" class="form-label">Telefone</label>
                    <input type="text" name="text_telefone" id="text_telefone" class="form-control" minlength="3" maxlength="12" required value=" <?= $ver->telefone?> ">
                </div>
                <div style="display:none;">
                    <input type="text" name="id" id="id" value="<?= $ver->id?>">
                </div>
                <div class="text-center">
                    <a href="index.php" class="btn btn-outline-dark">Cancelar</a>
                    <input type="submit" value="Atualizar" class="btn btn-outline-dark">
                </div>
            </form>

        </div>

        <?php if(!empty($erro)): // se tiver erro, ira mostrar a mensagem?>
            <!-- error message -->
            <div class="mt-3 alert alert-danger p-2 text-center">
                <?= $erro?>
            </div>
        <?php endif ?>
    </div>
</div>

<?php
require_once('footer.php');
?>