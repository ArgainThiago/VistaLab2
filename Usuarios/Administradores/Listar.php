<?php
include("../Conexion.php");

$result = mysqli_query($conn, "SELECT * FROM administrador");

?>

<h2>Lista de Administradores </h2>
<Table border="1">
    <tr>
        <th>ID De Administrador</th>
        <th>Correo</th>
        <th>Tel</th>
        <th>Acciones</th>
    </tr>
    <?php while($row=mysqli_fetch_assoc($result)){
        ?>
        <tr>
            <td><?php echo $row['ID_Administrador'];?></td>
            <td><?php echo $row['Correo'];?></td>
            <td><?php echo $row['Tel'];?></td>
            <td><?php echo $row['Contraseña_A'];?></td>
            <td>
                <a href="Editar.php?ID_Administrador=<?php echo $row['ID_Administrador']; ?>">Editar</a>
                <a href="Eliminar.php?ID_Administrador=<?php echo $row['ID_Administrador']; ?>">Eliminar</a>
                <a href="Crear.php?ID_Administrador=<?php echo $row['ID_Administrador']; ?>">Crear</a>
            </td>

        </tr>
        
        
        <?php }?>
</table>
