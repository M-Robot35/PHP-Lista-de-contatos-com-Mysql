<?php
require_once('header.php');


// ======================================================
// REDIRECIONA CASO ID ESTIVER VAZIO OU  NÃO HAVER KEY ID
// ======================================================
if(!key_exists('id', $_GET ) || empty($_GET['id'])){
    header('Location: index.php');
}

$id= $_GET['id'];
$total_count = 0;

$parametros= [
    ":id" => $id,
];

// ==============================================
// Deleta o contato após confirmação do usuario
// ==============================================
if(key_exists('delete', $_GET)){
    $sql= "DELETE FROM contactos WHERE id=:id";
    $connect->execute_non_query($sql, $parametros);
    header("Location: index.php", false);
}

// =============================================
// seleciona o possivel usuario a ser deletado
// =============================================
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
?>

<div class="row">
    <div class="col text-center">
        <h3>Deseja eliminar o seguinte contacto?</h3>

        <div class="my-4">
            <div>                
                <span class="me-5">Nome: <strong> <?= $ver->nome ?> </strong></span>
                <span>Telefone: <strong> <?= $ver->telefone?> </strong></span>
            </div>
        </div>

        <a href="index.php" class="btn btn-outline-dark yes-no-width">Não</a>
        <a href="eliminar_contacto.php?id=<?= $id?>&delete=yes" class="btn btn-outline-dark yes-no-width">Sim</a>
    </div>
</div>

<?php
require_once('footer.php');
?>