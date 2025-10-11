<?php
include("../Conexion.php");

$result = mysqli_query($conn, "SELECT * FROM Consulta");

?>

<h2>Lista de Administradores </h2>
<Table border="1">
    <tr>
        <th>ID De Consulta</th>
        <th>Cedula Del Doctor</th>
        <th>Id De Especialidad</th>
        <th>Fecha De Consulta</th>
        <th>Horario</th>
        <th>Cedula Del Paciente</th>
        <th>Estado De La Consulta</th>
    </tr>
    <?php while($row=mysqli_fetch_assoc($result)){
        ?>
        <tr>
            <td><?php echo $row['ID_Consulta'];?></td>
            <td><?php echo $row['Cedula_D'];?></td>
            <td><?php echo $row['ID_Especialidad'];?></td>
            <td><?php echo $row['Fecha_Consulta'];?></td>
            <td><?php echo $row['Horario'];?></td>
            <td><?php echo $row['Cedula_P'];?></td>
            <td><?php echo $row['Estado'];?></td>
            <td>
                <a href="Editar.php?ID_Consulta=<?php echo $row['ID_Consulta']; ?>">Editar</a>
                <a href="Eliminar.php?ID_Consulta=<?php echo $row['ID_Consulta']; ?>">Eliminar</a>
                
            </td>

        </tr>
        
        
        <?php }?>
</table>
<a href="Crear.php?ID_Consulta">Crear</a>