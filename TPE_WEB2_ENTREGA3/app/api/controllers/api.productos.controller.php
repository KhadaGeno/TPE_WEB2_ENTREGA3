<?php
require_once './app/api/views/api.view.php';
require_once './app/models/productos.model.php';
require_once './app/models/categoria.model.php';

class ProductosAPIController {

    private $view;
    private $productosModel;
    private $categoriaModel;
    private $data;
    
    function __construct () {
        $this->view = new ApiView();
        $this->productosModel = new ProductosModel();
        $this->categoriaModel = new CategoriaModel();
        $this->data = file_get_contents('php://input');
    }

    public function getdata () {
        return json_decode($this->data);
    }

    function getProductos($params = []) {

        if (empty($params)) {
            $sort = 'id_producto';
            $order = 'ASC';
            if (isset($_GET['order'])) {
                $order = $_GET['order'];
                if ($order !='ASC' && $order != 'DESC') {
                    $order = 'ASC';
                }
            }

            if (isset($_GET['sort'])) {
                $sort = $_GET['sort'];
                $columnas = array('nombre', 'descripcion', 'precio');
                if (!in_array($sort, $columnas)) {
                $sort = 'id_producto';
                }
            }

            $productos = $this->productosModel->getProductos($order, $sort);
            if ($productos) {
                $this->view->response($productos, 200);
            } else {
                $this->view->response("Page not found", 404);
            }
        }
    }

    function getProductosID ($params = []) {
        $idProducto = $params[':ID'];
        $producto = $this->productosModel->getProductosPorId($idProducto);
        if($producto) {
            $this->view->response($producto, 200);
        } else {
            $this->view->response("Bad request", 400);
        }
    }
    
    function addProducto ($params = []) {
        $addProducto = $this->getdata();
        $nombre = $addProducto->nombre;
        $descripcion = $addProducto->descripcion;
        $precio = $addProducto->precio;
        $id_genero = $addProducto->id_genero;
        if (empty($nombre) || empty($descripcion) || empty($precio) || empty($id_genero)) {
            $this->view->response('Bad request', 400);
            die();
        }
        $productos = $this->productosModel->checkProductos();
        foreach ($productos as $producto) {
            if ($nombre == $producto->nombre) {
                $this->view->response("Bad request", 400);
                die();
            }
        }
        
        $categoria = $this->categoriaModel->getCategoriaUnica($id_genero);
        if (!$categoria) {
            $this->view->response("Bad request", 400); 
            die();  
        }

        $id = $this->productosModel->addProducto($nombre, $descripcion, $precio, $id_genero);
        if ($id>0) {
            $this->view->response("se agrego el producto", 201);
        } else {
            $this->view->response("Bad request", 400);
        }
    }

    function updateProducto($params = []) {
        if (empty($params[':ID'])) {
            $this->view->response('Page not found', 404);
            die();
        }
        
        $updateProducto = $this->getdata();
        $nombre = $updateProducto->nombre;
        $descripcion = $updateProducto->descripcion;
        $precio = $updateProducto->precio;
        $id_genero = $updateProducto->id_genero;
        if (empty($nombre) || empty($descripcion) || empty($precio) || empty($id_genero)) {
            $this->view->response('Bad request', 400);
            die();
        }
        
        $id_producto = $params[':ID'];
        $producto = $this->productosModel->getProductoUnico($id_producto);
        if (!$producto) {
            $this->view->response("Bad request", 400);
            die();
        }

        $productos = $this->productosModel->getProductosMenosUno($id_producto);
        foreach ($productos as $producto) {
            if ($nombre == $producto->nombre) {
                $this->view->response("Bad request", 400);
                return;
            }
        }

        $categoria = $this->categoriaModel->getCategoriaUnica($id_genero);
        if (!$categoria) {
            $this->view->response("Bad request", 400);
            die();  
        }

        $updated = $this->productosModel->updateProducto($nombre, $descripcion, $precio, $id_genero, $id_producto);
        if ($updated) {
            $this->view->response('se actualizaron los datos correctamente', 201);
        } else {
            $this->view->response('Bad request', 400);
        }
    }
}

    
