<?php 
    function getContactos() {
        include 'db.php';

        try {
            return $con->query("SELECT id, nombre, empresa, telefono FROM contactos");
        } catch (Exception $e) {
            echo "Error" . $e->getMessage() . "<br>";
            return false;
        }
    }

    // Obtiene un contacto 

    function getContacto($id) {
        include 'db.php';

        try {
            return $con->query("SELECT id, nombre, empresa, telefono FROM contactos WHERE id = $id");
        } catch (Exception $e) {
            echo "Error" . $e->getMessage() . "<br>";
            return false;
        }
    }
?>