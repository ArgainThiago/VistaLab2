<?php
include("../Conexion.php");

$result = mysqli_query($conn, "SELECT * FROM doctor");

?>

<h2>Lista de Doctores </h2>
<Table border="1">
    <tr>
        <th>Cedula_D</th>
        <th>Nombre_D</th>
        <th>Correo</th>
        <th>His_med</th>
        <th>Tel</th>
        <th>Contraseña_D</th>
        <th>ID De Administrador</th>
        <th>Usuario_D</th>
        <th>Acciones</th>
    </tr>
    <?php while($row=mysqli_fetch_assoc($result)){
        ?>
        <tr>
            <td><?php echo $row['Cedula_D'];?></td>
            <td><?php echo $row['Nombre_D'];?></td>
            <td><?php echo $row['Correo'];?></td>
            <td><?php echo $row['His_med'];?></td>
            <td><?php echo $row['Tel'];?></td>
            <td><?php echo $row['Contraseña_D'];?></td>
            <td><?php echo $row['ID_Administrador'];?></td>
            <td><?php echo $row['Usuario_D'];?></td>
            <td>
                <a href="Editar.php?Cedula_D=<?php echo $row['Cedula_D']; ?>">Editar</a>
                <a href="Eliminar.php?Cedula_D=<?php echo $row['Cedula_D']; ?>">Eliminar</a>
              
            </td>

        </tr>
        
        
        <?php }?>
</table>
  <a href="Crear.php?Cedula_D">Crear</a>