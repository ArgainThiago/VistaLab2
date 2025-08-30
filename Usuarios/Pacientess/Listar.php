<?php
include("../Conexion.php");

$result = mysqli_query($conn, "SELECT * FROM paciente");

?>

<h2>Lista de Administradores </h2> 
<a href="Crear.php">Crear Paciente</a>
<Table border="1">
    <tr>
        <th>Nombre Del Paciente</th>
        <th>Contraseña</th>
        <th>Cedula</th>
        <th>Historial medico</th>
        <th>Sexo</th>
        <th>Fecha de nacimiento</th>
        <th>Correo</th>
        <th>Tel</th>

        <th>Acciones</th>
    </tr>
    <?php while($row=mysqli_fetch_assoc($result)){
        ?>
       
        <tr>
            <td><?php echo $row['Nombre_P'];?></td>
            <td><?php echo $row['Contraseña_P'];?></td>
            <td><?php echo $row['Cedula_P'];?></td>
            <td><?php echo $row['His_med'];?></td>
            <td><?php echo $row['Sexo'];?></td>
            <td><?php echo $row['Fecha_Nac'];?></td>
            <td><?php echo $row['Correo'];?></td>
            <td><?php echo $row['Tel'];?></td>
            <td>
                <a href="Editar.php?Cedula_P=<?php echo $row['Cedula_P']; ?>">Editar</a>
                <a href="Eliminar.php?Cedula_P=<?php echo $row['Cedula_P']; ?>">Eliminar</a>
            </td>
            
        </tr>
        
        
        <?php }?>
</table>
