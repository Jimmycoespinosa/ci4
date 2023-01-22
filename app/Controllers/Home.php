<?php

namespace App\Controllers;

use CodeIgniter\Controllers;
use App\Models\UserModel;

class Home extends BaseController
{
    //JE- MANEJO DE SESIONES
    public $session=null;//Es mejor práctica definirlo en BaseController.

    //El llamado del form se hace en el constructor para que pueda heredar a las demás funciones.
    //Para que herede a todo el proyecto se pone en el BaseController.
    public function __construct(){
        helper('form');
        //JE- MANEJO DE SESIONES
        $this->session=\Config\Services::session();//Es mejor práctica definirlo en BaseController.
    }

    //Link: http://localhost/ci4/index.php/Home/formulario
    public function formulario(){
        $estructura=view('Estructura/Header').view('Estructura/Formulario');
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home
    public function index()
    {
        $userModel=new UserModel();
        //$users=$userModel->find([1,2]);
        //$users=$userModel->findAll();
        //$users=$userModel->where('name', 'maria')->findAll();
        //$users=$userModel->findAll(1,2);//Dame 1, a partir de 2 ...
        //$users=$userModel->withDeleted()->findAll();
        //$users=$userModel->onlyDeleted()->findAll();
        
        //VISTAS ANIDADAS
        //$datos=$userModel->findAll();
        //$datos=array('users'=>$datos, 'cabecera'=>view('Estructura/Header'));
        //$estructura=view('Estructura/Body',$datos);

        //VISTA PAGINACIÓN
        $users=$userModel->paginate(10);
        $paginador=$userModel->pager;
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $paginador->setPath('ci4/');
        $estructura=view('Estructura/Header').view('Estructura/Body',$users);

        //VISTA TRADICIONAL
        //$users=$userModel->findAll();
        //$users=array('users'=>$users);
        //$estructura=view('Estructura/Header').view('Estructura/Body',$users);
        return $estructura;
    }

    //JE- MANEJO DE SESIONES
    //Crea una bariable en el servidor.
    public function ponerDatos(){
        //$session=\Config\Services::session();//Se inicializa mejor en constructor.
        $newdata=[
            'name'=>'novato',
            'email'=>'info@programador.com',
            'login'=>true,
        ];
        $this->session->set($newdata);
        echo $this->session->get('email');
    }

    //Leee la variable del servidor.
    public function leerDatos(){
        if($this->session->has('name')){
            echo "name: ".$this->session->get('name')."<br>";
            echo "email: ".$this->session->get('email')."<br>";
            echo "login: ".$this->session->get('login')."<br>";
        }
        else{
            echo "No hay datos..".$this->session->get('email');
        }   
    }

    //Elimina la variable nombre del servidor.
    public function quitarNombre(){
        $this->session->remove('name');
        echo "Nombre eliminado exitosamente..";
    }

    //Elimina todos los datos de sesión del servidor.
    public function eliminarDatos(){
        $this->session->destroy();
        echo "Datos destruidos exitosamente..";
    }
    //JE- MANEJO DE SESIONES

    public function images(){
        $info=\Config\Services::image()->withFile('CodeIgniter.png')
        ->getFile()
        ->getProperties(true);
        $ancho=$info['width'];
        $alto=$info['height'];

        $images=\Config\Services::image()
        ->withFile('CodeIgniter.png')
        ->reorient()
        //->fit(250,250, 'botton-center')//Ajustar
        //->rotate(180)//Rotar
        //->resize($ancho/2,$alto/2)//Redimensionar
        ->crop(300,300,50,50)//Recortar
        ->save('Codeigniter2.png');
        return view('Estructura/Image.php');
    }

    //Link: http://localhost/ci4/index.php/Home/guarda
    public function guarda(){
        $userModel=new UserModel();
        $request= \Config\Services::request();
        $data=array(
            'name'=>$request->getPostGet('name'),
            'email'=>$request->getPostGet('email'),
        );      
        if($request->getPostGet('id')){
            $data['id']=$request->getPostGet('id');
        }
        if($userModel->save($data)===false){
            var_dump($userModel->errors());
        }
        if($request->getPostGet('id')){
            $users=$userModel->find([$request->getPostGet('id')]);
            $paginador=$userModel->pager;//Paginador
            $users=array('users'=>$users, 'paginador'=>$paginador);
            $estructura=view('Estructura/Header').view('Estructura/Formulario',$users);
        }
        else{
            $users=$userModel->findAll();
            $paginador=$userModel->pager;//Paginador
            $users=array('users'=>$users, 'paginador'=>$paginador);
            $estructura=view('Estructura/Header').view('Estructura/Body',$users);            
        }        
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/Editar
    public function editar(){
        $userModel=new UserModel();
        $request= \Config\Services::request();
        if($request->getPostGet('id')){
            $id=$request->getPostGet('id');
        }else{
            $id=$request->uri->getSegment(3);//Para uso de segmentos de URLs.
        }        
        
        $users=$userModel->find([$id]);
        $paginador=$userModel->pager;//Paginador
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $estructura=view('Estructura/Header').view('Estructura/Formulario',$users);
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/Borrar
    public function borrar(){
        $userModel=new UserModel();
        $request= \Config\Services::request();
        $id=$request->getPostGet('id');
        
        $users=$userModel->delete($id);
        $users=$userModel->findAll();
        $paginador=$userModel->pager;//Paginador
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $estructura=view('Estructura/Header').view('Estructura/Body',$users);
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/insert
    public function insert()
    {
        $userModel=new UserModel();        
        $data=[
            'name'=>"Programador1",
            'email'=>"Programador1@gmail.com"
        ];
        $userModel->insert($data);

        $users=$userModel->findAll();
        $paginador=$userModel->pager;//Paginador
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $estructura=view('Estructura/Header').view('Estructura/Body',$users);
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/update
    public function update()
    {
        $userModel=new UserModel();        
        $data=[
            'name'=>"Programador2",
            'email'=>"Programador2@gmail.com"
        ];
        $userModel->update(4, $data);

        $users=$userModel->findAll();
        $paginador=$userModel->pager;//Paginador
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $estructura=view('Estructura/Header').view('Estructura/Body',$users);
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/multiUpdate
    public function multiUpdate()
    {
        $userModel=new UserModel();        
        $data=[
            'email'=>"Programador3@hotmail.com"
        ];
        $userModel->update([4,2], $data);

        $users=$userModel->findAll();
        $paginador=$userModel->pager;//Paginador
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $estructura=view('Estructura/Header').view('Estructura/Body',$users);
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/multiUpdateWhere
    public function multiUpdateWhere()
    {
        $userModel=new UserModel();    
        $userModel->whereIn('id',[2,4])
        ->set(['name'=>'Programador4'])
        ->update();

        $users=$userModel->findAll();
        $paginador=$userModel->pager;//Paginador
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $estructura=view('Estructura/Header').view('Estructura/Body',$users);
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/save
    // Actualiza o inserta dependiendo del resultado de la búsqueda (Si existe).
    public function save()
    {
        $userModel=new UserModel();        
        $data=[
            'id'=>"4",
            'name'=>"Programador5",
            'email'=>"Programador5@gmail.com"
        ];
        $userModel->save($data);

        $users=$userModel->findAll();
        $paginador=$userModel->pager;//Paginador
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $estructura=view('Estructura/Header').view('Estructura/Body',$users);
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/delete
    public function delete()
    {
        $userModel=new UserModel();        
        $userModel->delete(4);
        //$userModel->delete([1,2]);//Varios registros.

        $users=$userModel->findAll();
        $paginador=$userModel->pager;//Paginador
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $estructura=view('Estructura/Header').view('Estructura/Body',$users);
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/deleteWhere
    public function deleteWhere()
    {
        $userModel=new UserModel();        
        $userModel->where('name', 'Juan')->delete();

        $users=$userModel->findAll();
        $paginador=$userModel->pager;//Paginador
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $estructura=view('Estructura/Header').view('Estructura/Body',$users);
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/purge
    //Elimina registros que fueron eliminados soft.
    public function purge()
    {
        $userModel=new UserModel();        
        $userModel->purgeDeleted();

        $users=$userModel->findAll();
        $paginador=$userModel->pager;//Paginador
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $estructura=view('Estructura/Header').view('Estructura/Body',$users);
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/insertValidate
    public function insertValidate()
    {
        $userModel=new UserModel();        
        $data=[
            'name'=>"Programador_Valid",//Error caracteres
            'email'=>"Programador"//Error formato email
        ];
        //Al intentar un correo duplicado muestra la personalización del mensaje como UserModel.
        // $data=[
        //     'name'=>"Programador6",//Error caracteres
        //     'email'=>"jimmycoespinosa@gmail.com"//Error formato email
        // ];
        if($userModel->save($data)===false){
            var_dump($userModel->errors());
        }

        $users=$userModel->findAll();
        $paginador=$userModel->pager;//Paginador
        $users=array('users'=>$users, 'paginador'=>$paginador);
        $estructura=view('Estructura/Header').view('Estructura/Body',$users);
        return $estructura;
    }

    //Link: http://localhost/ci4/index.php/Home/queryType
    public function queryType()
    {
        $userModel=new UserModel();        
        $users=$userModel->asObject()->where('name','Jimmy')
        ->orderBy('id','asc')
        ->findAll();
        var_dump($users);
        return "";
    }
}
