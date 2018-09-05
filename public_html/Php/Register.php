<?php
require_once "../DB/ClassConexion.php";


$action = $_POST['action'];

function register_user($name, $lastname, $address, $phone, $document)
{
    $con = new Conexion();
    $conexion = $con->getConexion();
    $msg = '';
    $sql = "INSERT
    INTO users(name, lastname, address, phone, document)
    VALUES(:name, :lastname, :address, :phone, :document)";

    $query = $conexion->prepare($sql);

    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':phone', $phone, PDO::PARAM_STR);
    $query->bindParam(':document', $document, PDO::PARAM_INT);

    if (!$query) {
        $msg = "Error en el registro";
    } else {
        try {
            $query->execute();
            $msg = "Registro realizado con exito";
        } catch (PDOExeption $e) {
            $msg = $e->getMessage();
        }
    }

    return $msg;

}

function show_user()
{
    $con = new Conexion();
    $conexion = $con->getConexion();
    $data = null;
    $name = null;
    $lastname = null;
    $address = null;
    $phone = null;
    $document = null;
    $id = null;

    $sql = 'SELECT
                name,
                lastname,
                address,
                phone,
                document,
                id
            FROM users';

    $query = $conexion->prepare($sql);
    
    
    
    $query->execute();

    while ($result = $query->fetch()) {
        $rows[] = $result;
        
    }

    if ($rows ) {
        

        foreach ($rows as $row) {
            $name = $row['name'];
            $lastname = $row['lastname'];
            $address = $row['address'];
            $phone = $row['phone'];
            $document = $row['document'];
            $id = $row['id'];


            $array[] = array(
                'name' => $name,
                'lastname' => $lastname,
                'address' => $address,
                'phone' => $phone,
                'document' => $document,
                'id' => $id
            );
            

        }
        $data = json_encode($array);
        

    } else {
        $msg = 'No hay usuarios registrados';
        $msg_array = array('msg'=>$msg);

        $data = json_encode( $array);
    }
    
    return $data;

}


function delete_user($id){
    $con = new Conexion();
    $conexion = $con->getConexion();
    $msg = '';

    $sql = 'DELETE 
            FROM users
            WHERE id = :id';

    $query = $conexion->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);

    if (!$query) {
        $msg = "Error al eliminar registro";
    } else {
        try {
            $query->execute();
            $msg = "Registro eliminado con exito";
        } catch (PDOExeption $e) {
            $msg = $e->getMessage();
        }
    }
    return $msg;

}



switch ($action) {
    case 'register':

        echo register_user(
            $_POST['name'],
            $_POST['lastname'],
            $_POST['address'],
            $_POST['phone'],
            $_POST['document']
        );
        break;
    case 'show':
        echo show_user();
    break;
    case 'delete':
        echo delete_user($_POST['id']);
    break;

    default:
        
        # code...
        break;
}

//echo "<br>Hola Mundo<br>";
