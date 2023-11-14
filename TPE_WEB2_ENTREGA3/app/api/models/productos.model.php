<?php

require_once "./config.php";

class ProductosModel {

    private $db;

    function __construct() {
        $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    }

    function getProductos ($order, $sort) {
        $query = $this->db->prepare("SELECT * FROM productos ORDER BY $sort $order");
        $query->execute();
        $productos = $query->fetchAll(PDO::FETCH_OBJ);
        return $productos;
    }

    function checkProductos(){
        $query = $this->db->prepare('SELECT * FROM productos');
        $query->execute();
        $productos = $query->fetchAll(PDO::FETCH_OBJ);
        return $productos;
    }
    function getProductosMenosUno ($id) {
        $query = $this->db->prepare('SELECT * FROM productos WHERE id_producto != ?');
        $query->execute([$id]);
        $productos = $query->fetchAll(PDO::FETCH_OBJ);
        return $productos;
    }

    function getProductosPorId ($id) {
        $query = $this->db->prepare('SELECT * FROM productos WHERE id_producto = ?');
        $query->execute([$id]);
        $productos = $query->fetchAll(PDO::FETCH_OBJ);
        return $productos;
    }

    function getProductoUnico ($id) {
        $query = $this->db->prepare('SELECT * FROM productos WHERE id_producto = ?');
        $query->execute([$id]);
        $productos = $query->fetch(PDO::FETCH_OBJ);
        return $productos;
    }

    function getProductoCategoria ($id) {
        $query = $this->db->prepare('SELECT * FROM productos WHERE id_genero = ?');
        $query->execute([$id]);
        $productos = $query->fetchAll(PDO::FETCH_OBJ);
        return $productos;
    }

    function addProducto ($nombre, $descripcion, $precio, $id_genero) {
        $query = $this->db->prepare('INSERT INTO productos ( nombre, descripcion, precio, id_genero) VALUES (?, ?, ?, ?)');
        $query->execute([$nombre, $descripcion, $precio, $id_genero]);
        return $this->db->lastInsertId();
    }

    function putProducto ($nombre, $descripcion, $precio, $id_genero, $id_producto) {
        $query = $this->db->prepare('UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, id_genero = ? WHERE id_producto = ?');
        $query->execute([$nombre, $descripcion, $precio, $id_genero, $id_producto]);
        return true;
    }

    function deleteProducto ($id) {
        $query = $this->db->prepare('DELETE FROM productos WHERE id_producto = ?');
        $query->execute([$id]);
    }
}