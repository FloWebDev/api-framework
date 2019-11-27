<div class="text-white bg-dark mb-3 col-12 mx-auto py-3">
<!-- Bouton ajout nouvelle entré -->
<div class="col-12 col-md-11 mx-auto px-0 py-2">
    <a class="btn btn-primary" href="/inscription" role="button"><i class="fas fa-user-plus"></i> Ajouter</a>
</div>

<?php if(!empty($users)) : ?>

            <table class="table table-striped text-dark bg-white col-12 col-md-11 mx-auto">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Identifiant</th>
                        <th scope="col">MDP</th>
                        <th scope="col">Rôle</th>
                        <th scope="col">Date de création</th>
                        <th scope="col">Dernière connexion</th>
                        <th scope="col">Actif</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach($users as $user) : ?>
                        <!-- Création d'un formulaire par user -->
                        <form action="/update/user" method="POST">
                            <tr>
                            <th scope="row">
                                #<?= $user->getId(); ?>
                                <input type="hidden" value="<?= $user->getId(); ?>" name="user">
                            </th>
                            <td><input type="text" value="<?= $user->getUsername(); ?>" name="username"></td>
                            <td><input type="password" placeholder="Nouveau MDP" name="password"></td>
                            <td>
                                <?php if(!empty($roles)) : ?>
                                    <select name="role" id="role">
                                    <?php foreach($roles as $id => $role) : ?>
                                        <option for="role" value="<?= $id ?>"
                                        <?php if($id == $user->getRoleId()) : ?>
                                            selected
                                        <?php endif; ?>
                                        ><?= $role?></option>
                                    <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </td>



                            <td><?= $user->getCreatedAt(); ?></td>
                            <td><?= $user->getConnectedAt(); ?></td>
                            <td class="text-center"><input type="checkbox" class="form-check-input" id="is_active" name="actif"
                            <?php if($user->getIsActive()) : ?>checked<?php endif; ?> value="1"></td>
                            <td><input type="submit" class="btn btn-dark mr-3" value="Valider">
                            <a href="/delete/user/<?= $user->getId(); ?>" class="text-danger deleteButton"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                        </form>
                    <?php endforeach; ?>

                    </tbody>

            </table>


<?php else : ?>
        <p class="card col-12 col-md-10 mx-auto text-dark">Aucun résultat à afficher.</p>
<?php endif; ?>
</div>