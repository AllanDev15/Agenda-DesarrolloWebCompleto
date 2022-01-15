<?php 

    if($_POST['accion'] == 'crear') {
        //Creara un nuevo registro en la BD
        require_once('../funciones/db.php');

        //Validar la entrada de los datos
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        $empresa = filter_var($_POST['empresa'], FILTER_SANITIZE_STRING);
        $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);

        try {
            $statement = $con->prepare("INSERT INTO contactos (nombre, empresa, telefono) VALUES(?, ? ,?)");
            $statement->bind_param('sss', $nombre, $empresa, $telefono);
            $statement->execute();
            if($statement->affected_rows == 1) {   //Si alguna fila fue afectada
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'datos' => array (
                        'id_insertado' => $statement->insert_id,    //Regresa el id insertado
                        'nombre' => $nombre,
                        'empresa' => $empresa, 
                        'telefono' => $telefono
                    )
                );
            }
            $statement->close();
            $con->close();
        }catch(Exception $e) {
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }

        echo json_encode($respuesta);
    }
    

    if($_GET['accion'] == 'borrar') {
        require_once('../funciones/db.php');

        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        try {
            $stmt = $con->prepare("DELETE FROM contactos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            if($stmt->affected_rows == 1) {
                $respuesta = array(
                    'respuesta' => 'correcto'
                );
            }

            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }

        echo json_encode($respuesta);
    }

    if($_POST['accion'] == 'editar') {
        require_once('../funciones/db.php');

        //Validar la entrada de los datos
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        $empresa = filter_var($_POST['empresa'], FILTER_SANITIZE_STRING);
        $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

        try{
            $stmt = $con->prepare("UPDATE contactos SET nombre = ?, telefono = ?, empresa = ? WHERE id = ?");
            $stmt->bind_param("sssi", $nombre, $telefono, $empresa, $id);
            $stmt->execute();

            if($stmt->affected_rows == 1) {
                $respuesta = array(
                    'respuesta' => 'correcto'
                );
            }
            else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }

            $stmt->close();
            $con->close();
        }catch(Exception $e) {
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }

        echo json_encode($respuesta);
    }
