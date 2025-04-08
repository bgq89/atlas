<style>
    #div_centrar {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50vh;
        flex-direction: column;
        text-align: center;
    }

    body {
        font-family: Arial, sans-serif;
        display: flex;
        height: 100vh;
        background-color: #f4f4f4;
    }

    table {
        width: 50%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        margin: auto;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background: #00897b;
        color: white;
    }

    tr:nth-child(even) {
        background: #f9f9f9;
    }

</style>

<table>
    <thead>
        <tr>
            <th>País</th>
            <th>Capital</th>
        </tr>
    </thead>
    <tbody>
        <?php $paises = Modelo::sacarTodo(); 
            foreach ($paises as $pais) { ?>
        <tr> 
            <td><?= htmlspecialchars($pais['pais']) ; ?></td>
            <td><?= htmlspecialchars($pais['capital']) ; ?></td>
        </tr>
        <?php } ; ?>
    </tbody>
</table>