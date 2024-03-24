<html>

<head>
    <title>Bons Livraisons</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bons Livraisons</title>
    <link rel="stylesheet" href="../View/css/Livraison.css">
</head>

<body>
    <h1>Tableau des bons de livraison</h1>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th>ID</th>
                <th>Adresse</th>
                <th>Date de livraison</th>
                <th>Numéro de Livraison</th>
                <th>Supprimer</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody class="table__tbody">
            <?php foreach ($tests as $test) : ?>
                <tr>
                    <td><?php echo $test['id_Livraison']; ?></td>
                    <td><?php echo $test['Adresse']; ?></td>
                    <td><?php echo $test['Date_Livraison']; ?></td>
                    <td><?php echo $test['Numero_Livraison']; ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="supprimerLivraison" value="<?php echo $test['id_Livraison']; ?>">
                            <input class="button" type="submit" name="delete" value="Supprimer">
                        </form>
                    </td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="id_Livraison" value="<?php echo $test['id_Livraison']; ?>">
                            <label class="form__label" for="Adresse">Adresse :</label>
                            <input class="form__input" type="text" name="Adresse" value="<?php echo $test['Adresse']; ?>">
                            <label class="form__label" for="Date_Livraison">Date de livraison :</label>
                            <input class="form__input" type="text" name="Date_Livraison" value="<?php echo $test['Date_Livraison']; ?>">
                            <label class="form__label" for="Numero_Livraison">Numéro de Livraison :</label>
                            <input class="form__input" type="text" name="Numero_Livraison" value="<?php echo $test['Numero_Livraison']; ?>"><br>
                            <input class="button" type="submit" name="update" value="Modifier">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Ajouter un bon de livraison</h2>
    <form class="form-center" method="post" action="">
        <label class="form__label" for="Adresse">Adresse :</label>
        <input class="form__input" type="text" name="Adresse" required>
        <label class="form__label" for="Numero_Livraison">Numéro de livraison :</label>
        <input class="form__input" type="text" name="Numero_Livraison" required>
        <label class="form__label" for="Date_Livraison">Date de livraison :</label>
        <input class="form__input" type="date" name="Date_Livraison" required>
        <input class="button" type="submit" name="submit" value="Ajouter">
    </form>
</body>

</html>