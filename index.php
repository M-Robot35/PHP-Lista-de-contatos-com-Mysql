<?php

use sys4soft\Database;

require_once('libraries/Database.php');

require_once('header.php');

$resultado = null;
$total_contatos = 0;

//=========================================================================
// Faz a pesquisa se necessario /- Caso contrario só mostra todos usuarios
//=========================================================================
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $procurar= $_POST['text_search'];    
    $paramsSerach= [
        ":search" => "%" . $procurar. "%"    
    ];
    
    $query='SELECT * FROM contactos WHERE nome LIKE :search OR telefone LIKE :search ORDER BY id DESC';
    $result = $connect->execute_query($query, $paramsSerach);
    $resultado= $result->results;
    $total_contatos = count($resultado); 

}else{
    $query='SELECT * FROM contactos  ORDER BY id DESC';
    $result = $connect->execute_query($query);
    
    $resultado = $result->results;  
    $total_contatos = count($resultado);  
}
?>

<!-- search & add new -->
<div class="row align-items-center mb-3">
    <div class="col">
        
        <form action="index.php" method="post">
            <div class="row">
                <div class="col-auto"><input type="text" class="form-control" name="text_search" id="text_search" minlength="3" maxlength="20" required></div>
                <div class="col-auto"><input type="submit" class="btn btn-outline-dark" value="Procurar"></div>
                <div class="col-auto"><a href="index.php" class="btn btn-outline-dark">Ver tudo</a></div>
            </div>
        </form>
        
    </div>
    
    <div class="col text-end">
        <a href="adicionar_contacto.php" class="btn btn-outline-dark">Adicionar contacto</a>
    </div>
</div>

<!-- show contact's table -->
<div class="row">
    <div class="col">
        <?php if($total_contatos == 0):?>
            <!-- no results -->
                <p class="text-center opacity-75 mt-3">-- Não foram encontrados contactos registados. --</p>
        <?php else:?>
            <!-- widh results -->
                <table class="table table-sm table-striped table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th width="40%">Nome</th>
                            <th width="30%">Telefone</th>
                            <th width="15%"></th>
                            <th width="15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($resultado as $key => $contato):?>
                        <tr>
                            <td> <?= $contato->nome ?> </td>
                            <td> <?= $contato->telefone ?>  </td>
                            <td class="text-center"><a href="editar_contacto.php?id=<?= $contato->id ?>">Editar</a></td>
                            <td class="text-center"><a href="eliminar_contacto.php?id=<?= $contato->id ?>">Eliminar</a></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>                             
                </table>

                <!-- total results & delete all-->
                <div class="row">
                    <div class="col">
                        <p>Total: <strong> <?= $total_contatos?> </strong></p>
                    </div>
                </div>
        <?php endif?>
    </div>
</div>

<?php
require_once('footer.php');
?>