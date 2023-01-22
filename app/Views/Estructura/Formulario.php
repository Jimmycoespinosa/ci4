<div class="container">
    <?php
        echo form_open('/Home/guarda');
        if(isset($users)){
            $name=$users[0]['name'];
            $email=$users[0]['email'];
        }
        else{
            $name="";
            $email="";
        }
    ?>
    <div class="form-group"></div>
        <?php
            echo form_label('Nombre', 'name');
            echo form_input(array('name'=>'name', 'placeholder'=>'Nombre', 'class'=>'form-control', 'value'=>$name));
            echo "<br>";
            echo form_label('Email', 'email');
            echo form_input(array('name'=>'email', 'placeholder'=>'Email', 'class'=>'form-control', 'value'=>$email));    
            echo "<br>";
            echo form_submit('guarda', 'Guardar', 'class="btn btn-primary"');
        ?>
        <a href="http://localhost/ci4/" class="btn btn-warning" role="button">Cancelar</a>        
    </div>
    <?php
        echo "<br>";
        if(isset($users)){
            echo form_hidden('id',$users[0]['id']);
        }
        echo form_close();
    ?>
</div>