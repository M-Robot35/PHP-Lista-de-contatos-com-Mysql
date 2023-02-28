<?php

require_once('header.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome= $_POST['text_nome'];
    $telefone= $_POST['text_telefone'];
    
    //====================================================
    // verificar se o usuario já existe na base de dados    
    //====================================================
   $parametros = [
    ":nome" => $nome 
   ];

   $sql= "SELECT id FROM contactos WHERE nome= :nome";
   $result= $connect->execute_query($sql, $parametros);

    if($result->affected_rows != 0){
        $erro = 'O Ùsuario já existe, Tente Novamente.';
        echo "<h1>Error encontrado</h1>"; 

    }else{
        $params= [
            ":nome" => $nome,
            ":telefone" => $telefone,
        ];
    
        $sql= "INSERT INTO contactos VALUES(0, :nome, :telefone, NOW(), NOW())";
        $connect->execute_non_query($sql, $params);
        header('Location: index.php');
    }      
}
?>

<div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-10">

        <div class="card p-4">

            <form action="adicionar_contacto.php" method="post">
                <p class="text-center"><strong>NOVO CONTACTO</strong></p>
                <div class="mb-3">
                    <label for="text_nome" class="form-label">Nome</label>
                    <input type="text" name="text_nome" id="text_nome" class="form-control" minlength="3" maxlength="50" required>
                </div>
                <div class="mb-3">
                    <label for="text_telefone" class="form-label">Telefone</label>
                    <input type="text" name="text_telefone" id="text_telefone" class="form-control" minlength="3" maxlength="12" required>
                </div>
                <div class="text-center">
                    <a href="index.php" class="btn btn-outline-dark">Cancelar</a>
                    <input type="submit" value="Guardar" class="btn btn-outline-dark">
                </div>
            </form>

        </div>
        <?php if(!empty($erro)): ?>
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