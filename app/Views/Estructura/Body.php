<?php
    //echo $cabecera;//VISTAS ANIDADAS
    //echo view('Estructura/Header');
?>
<?= "";//$cabecera; ?> <!-- SINTAXIS ALTERNATIVA -->
<body>
    <div class="container">
        <div class="row">
            <a href="<?php echo base_url(); ?>/Home/" class="btn btn-success" 'role="button" ><i class="bi bi-house"></i></a>
            <a href="<?php echo base_url(); ?>/Home/Formulario" class="btn btn-primary" role="button" >Nuevo</a>
        </div>
        <div class="row">
            <!-- USO DE HELPERS -->
            <!-- <br><br> Hola <?php //echo $email; echo " ".suma(1, 2); echo resta(3, 2); ?> -->
            <table class="table">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">deleted_at</th>
                    <th scope="col">acciones</th>
                </tr>
            <?php
                /* SINTAXIS ORIGINAL
                foreach($users as $user){
                    echo "<tr scope='row'>";
                    echo "<td>".$user['id']."</td>";
                    echo "<td>".$user['name']."</td>";
                    echo "<td>".$user['email']."</td>";
                    echo "<td>".$user['deleted_at']."</td>";
                    echo "<td>";
                    SINTAXIS ORIGINAL*/
            ?>
                <!-- SINTAXIS ALTERNATIVA -->
                <? if($users): ?>
                    <?php foreach($users as $user): ?><!-- Es necesaria la etiqueta php para abrir y cerrar -->
                        <?= "<tr scope='row' >"; ?>
                        <?= "<td>".$user['id']."</td>";?>
                        <?= "<td>".$user['name']."</td>";?>
                        <?= "<td>".$user['email']."</td>";?>
                        <?= "<td>".$user['deleted_at']."</td>";?>
                        <td>
                            <!-- Envío de datos por segmento (No incluye id: http://localhost/ci4/Home/Editar/7)   -->
                            <a href="<?php echo base_url(); ?>/Home/Editar/<?php echo $user['id']; ?>" class="btn btn-warning" 'role="button" ><i class="bi bi-pencil-square"></i></a>
                            <a href="<?php echo base_url(); ?>/Home/Borrar?id=<?php echo $user['id']; ?>" class="btn btn-danger" 'role="button" ><i class="bi bi-trash"></i></a>            
                        </td>
                    <?php endforeach; ?>
                <? endif;?>
                <!-- SINTAXIS ALTERNATIVA -->

                <!-- SINTAXIS ORIGINAL -->
                <!-- Envío de datos por segmento (No incluye id: http://localhost/ci4/Home/Editar/7)  
                <a href="<?php echo base_url(); ?>/Home/Editar/<?php echo $user['id']; ?>" class="btn btn-warning" 'role="button" ><i class="bi bi-pencil-square"></i></a>
                <a href="<?php echo base_url(); ?>/Home/Borrar?id=<?php echo $user['id']; ?>" class="btn btn-danger" 'role="button" ><i class="bi bi-trash"></i></a> -->
            <?php
                   //echo "</td>";
                   //echo "</tr>";
                   //} SINTAXIS ORIGINAL
            ?>
            </table>
            <?php 
                if($paginador){
                    echo $paginador->links(); 
                }
            ?>
        </div>
    </div>
</body>
</html>