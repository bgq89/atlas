<style>
    #div_centrar {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50vh;
        flex-direction: column;
        text-align: center;
    }

    input.login {
        display: block;
        margin: 10px auto;
        padding: 8px;
    }

    input.boton {
        margin-top: 10px;
        margin: 5px;
        padding: 8px 15px;
    }

    form {
        text-align: center;
    }

</style>

<form action="" method="POST">
<label for="pais">País:</label>
        <select name="pais" id="pais" required>
            <?php
            // Obtener lista de países desde el modelo
            $paises = Modelo::sacarPaises();
            foreach ($paises as $pais) {
                echo "<option value='{$pais['pais']}'>{$pais['pais']}</option>";
            }
            ?>
        </select>
        
        <br><br>
        
        <label for="nuevaCapital">Nueva Capital:</label>
        <input type="text" name="nuevaCapital" id="nueva_capital" required>
        
        <br><br>
        
        <input type="submit" name="accion[atlas_modificar]" value="Modificar Capital">
</form>