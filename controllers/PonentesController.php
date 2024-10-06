<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;


class PonentesController {
    public static function index(Router $router) {

      if(!is_admin()) header('Location: /login');

      $pagina_actual = $_GET['page'];
      $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

      if(!$pagina_actual || $pagina_actual < 1) header('Location: /admin/ponentes?page=1');

      $total = Ponente::total();
      
      $registros_por_pagina = 5;

      $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

      if($paginacion->total_paginas() < $pagina_actual) header('Location: /admin/ponentes?page=1');
    
      $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());

      $router->render('admin/ponentes/index', [
        'titulo' => 'Ponentes / Conferencistas',
        'ponentes' => $ponentes,
        'paginacion' => $paginacion->paginacion()
      ]);

    }

    public static function crear(Router $router) {

      if(!is_admin()) header('Location: /login');

      $alertas = [];
      $ponente = new Ponente;

      if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if(!empty($_FILES['imagen']['tmp_name'])){

          $carpeta_imagenes = '../public/img/speakers';

          // Crear la carpeta si no existe 
          if(!is_dir($carpeta_imagenes)){
            mkdir($carpeta_imagenes, 0777, true);
          }
            
          $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
          $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
          
          $nombre_imagen = md5(uniqid(rand(), true));
          $_POST['imagen'] = $nombre_imagen;
        }

        $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
        $ponente->sincronizar($_POST);

        // Validar 
        $alertas = $ponente->validar();

        // Guardar el registro
        if(empty($alertas)){
          // Guardar las imagenes 
          $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
          $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

          // Guardar en la base de datos 
          $resultado = $ponente->guardar();
          if($resultado){
            header('Location: /admin/ponentes');
          }
        }
      }

      $router->render('admin/ponentes/crear', [
        'titulo' => 'Registrar Ponente',
        'alertas' => $alertas,
        'ponente' => $ponente,
        'redes' => json_decode($ponente->redes)
      ]);

    }

    public static function editar(Router $router){

      if(!is_admin()) header('Location: /login');

      $alertas = [];
      $id_ponente = $_GET['id'];
      $id_ponente = filter_var($id_ponente, FILTER_VALIDATE_INT);

      if(!$id_ponente) header('Location: /admin/ponentes');

      $ponente = Ponente::find($id_ponente);

      if(!$ponente) header('Location: /admin/ponentes');

      $ponente->imagen_actual = $ponente->imagen;      

      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!empty($_FILES['imagen']['tmp_name'])){

          $carpeta_imagenes = '../public/img/speakers';

          // Crear la carpeta si no existe 
          if(!is_dir($carpeta_imagenes)) mkdir($carpeta_imagenes, 0777, true);
            
          $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
          $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
          
          $nombre_imagen = md5(uniqid(rand(), true));

          $_POST['imagen'] = $nombre_imagen;
        } else{
          $_POST['imagen'] = $ponente->imagen_actual;
        }

        $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

        $ponente->sincronizar($_POST);

        $alertas = $ponente->validar();

        if(empty($alertas)){
          if(isset($nombre_imagen)){
            $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
            $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
          }
          
          $resultado = $ponente->guardar();

          if($resultado) header('Location: /admin/ponentes');
        }
      }

      $router->render('admin/ponentes/editar', [
        'titulo' => 'Editar Ponente',
        'alertas' => $alertas,
        'ponente' => $ponente,
        'redes' => json_decode($ponente->redes)
      ]);
    }

    public static function eliminar(){

      if(!is_admin()) header('Location: /login');

      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $id = $_POST['id'];        
        $ponente = Ponente::find($id);

        if(!isset($ponente)) header('Location: /admin/ponentes');
        
        $resultado = $ponente->eliminar();

        if($resultado) header('Location: /admin/ponentes');
      }

    }
}
