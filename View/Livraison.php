<html>

<head>
    <title>Bons Livraisons</title>
</head>

<body>
    <h1>Tableau des bons de livraison</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Adresse</th>
                <th>Date de livraison</th>
                <th>Numéro de Livraison</th>
                <th>Supprimer</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tests as $test) : ?>
                <tr>
                    <td><?php echo $test['id_Livraison']; ?></td>
                    <td><?php echo $test['Adresse']; ?></td>
                    <td><?php echo $test['Date_Livraison']; ?></td>
                    <td><?php echo $test['Numero_Livraison']; ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="supprimerLivraison" value="<?php echo $test['id_Livraison']; ?>">
                            <input type="submit" name="delete" value="Supprimer">
                        </form>
                    </td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="id_Livraison" value="<?php echo $test['id_Livraison']; ?>">
                            <input type="text" name="Adresse" value="<?php echo $test['Adresse']; ?>">
                            <input type="text" name="Date_Livraison" value="<?php echo $test['Date_Livraison']; ?>">
                            <input type="text" name="Numero_Livraison" value="<?php echo $test['Numero_Livraison']; ?>">
                            <input type="submit" name="update" value="Modifier">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Ajouter un bon de livraison</h2>
    <form method="post" action="">
        <label for="Adresse">Adresse :</label>
        <input type="text" name="Adresse" required>
        <label for="Numero_Livraison">Numéro de livraison :</label>
        <input type="text" name="Numero_Livraison" required>
        <label for="Date_Livraison">Date de livraison :</label>
        <input type="date" name="Date_Livraison" required>
        <input type="submit" name="submit" value="Ajouter">
    </form>
</body>

</html>