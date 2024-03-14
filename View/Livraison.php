<html>

<head>
    <title>Bons Livraisons</title>
</head>

<body>
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
                        <!--
                        <form method="post" action="">
                            <input type="hidden" name="update_id" value="<?php echo $test['id']; ?>">
                            <input type="text" name="update_test" value="<?php echo $test['test']; ?>">
                            <input type="submit" name="update" value="Modifier">
                        </form>
                        -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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