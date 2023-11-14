<?php

require_once "./config.php";

class CategoriaModel {

    private $db;

    function __construct () {
        $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    }
    
    function getCategorias () {
        $query = $this->db->prepare('SELECT * FROM categoria');
        $query->execute();
        $categorias = $query->fetchAll(PDO::FETCH_OBJ);
        return $categorias;
    }

    function getCategoriaUnica ($id) {
        $query = $this->db->prepare('SELECT * FROM categoria WHERE id_genero = ?');
        $query->execute([$id]);
        $categoria = $query->fetch(PDO::FETCH_OBJ);
        return $categoria;
    }

    function getCategoriasMenosUna ($id) {
        $query = $this->db->prepare('SELECT * FROM categoria WHERE id_genero != ?');
        $query->execute([$id]);
        $categorias = $query->fetchAll(PDO::FETCH_OBJ);
        return $categorias;
    }

    function addCategoria ($nombre) {
        $query = $this->db->prepare('INSERT INTO categoria (nombre_gen) VALUES (?)');
        $query->execute([$nombre]);
    }

    function updateCategoria ($nombre, $id) {
        $query = $this->db->prepare('UPDATE categoria SET nombre_gen = ? WHERE id_genero = ?');
        $query->execute([$nombre, $id]);
    }

    function deleteCategoria ($id) {
        $query = $this->db->prepare('DELETE FROM categoria WHERE id_genero = ?');
        $query->execute([$id]);
    }
}