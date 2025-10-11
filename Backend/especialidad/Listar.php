<?php
include("../Conexion.php");

$result = mysqli_query($conn, "SELECT * FROM especialidad");

?>

<h2>Lista de Especialidades </h2>
<Table border="1">
    <tr>
        <th>ID_Esecialidad</th>
        <th>Nom_Esecialidad</th>
        <th>Cedula_D</th>
        <th>Descripcion</th>
        <th>Fecha_Esp</th>
       
    </tr>
    <?php while($row=mysqli_fetch_assoc($result)){
        ?>
        <tr>
            <td><?php echo $row['ID_Especialidad'];?></td>
            <td><?php echo $row['Nom_Especialidad'];?></td>
            <td><?php echo $row['Cedula_D'];?></td>
            <td><?php echo $row['Descripcion'];?></td>
            <td><?php echo $row['Fecha_Esp'];?></td>
           
            <td>
                <a href="Editar.php?ID_Especialidad=<?php echo $row['ID_Especialidad']; ?>">Editar</a>
                <a href="Eliminar.php?ID_Especialidad=<?php echo $row['ID_Especialidad']; ?>">Eliminar</a>
               
            </td>

        </tr>
        
        
        <?php }?>
</table>
 <a href="Crear.php?ID_Especialidad">Crear</a>