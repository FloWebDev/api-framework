
                    <div class="doc-content col-12">
                        <div class="content-inner">
                            <section id="getting-started-section col-12 p-0" class="doc-section">
                                <h2 class="section-title"><i class="fas fa-clipboard-list"></i> Liste des utlisateurs</h2>
                                <div class="section-block">


<div class="text-dark bg-white mb-3 col-12 mx-auto py-3">
<!-- Bouton ajout nouveau utilisateurs -->
<div class="col-12 p-0 mb-2">
    <a class="btn btn-primary" href="/inscription" role="button"><i class="fas fa-user-plus"></i> Inscription</a>
</div>

<?php if(!empty($users)) : ?>

            <table class="table table-striped text-dark bg-white col-12 border border-success" style="border: 2px #28a745 solid!important;">
                    <thead>
                        <tr">
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

                    <?php foreach($users as $uUser) : ?>
                        <!-- Création d'un formulaire par user -->
                        <form action="/update/user" method="POST">
                            <tr>
                            <th scope="row">
                                #<?= $uUser->getId(); ?>
                                <input type="hidden" value="<?= $uUser->getId(); ?>" name="user">
                            </th>
                            <td><input class="form-control border border-dark" type="text" value="<?= $uUser->getUsername(); ?>" name="username"></td>
                            <td><input class="form-control border border-dark" type="password" placeholder="Nouveau MDP" name="password"></td>
                            <td>
                                <?php if(!empty($roles)) : ?>
                                    <select class="form-control border border-dark" name="role" id="role">
                                    <?php foreach($roles as $id => $role) : ?>
                                        <option for="role" value="<?= $id ?>"
                                        <?php if($id == $uUser->getRoleId()) : ?>
                                            selected
                                        <?php endif; ?>
                                        ><?= $role?></option>
                                    <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </td>



                            <td><?= $uUser->getCreatedAt(); ?></td>
                            <td><?= $uUser->getConnectedAt(); ?></td>
                            <td class="text-center"><input type="checkbox" class="form-check-input" id="is_active" name="actif"
                            <?php if($uUser->getIsActive()) : ?>checked<?php endif; ?> value="1"></td>
                            <td>
                            <input type="hidden" value="<?= $token; ?>" name="token">
                            <button type="submit" class="btn btn-dark mt-1"><i class="fas fa-save"></i></button>
                            <a href="/delete/user/<?= $uUser->getId(); ?>?token=<?= $token; ?>" class="btn btn-danger text-white deleteButton mt-1"><i class="fas fa-trash-alt"></i></a>
                            </td>
                            </tr>
                        </form>
                    <?php endforeach; ?>

                    </tbody>

            </table>


<?php else : ?>
        <p class="card col-12 text-dark">Aucun résultat à afficher.</p>
<?php endif; ?>
</div>






    
                                </div>
                            </section><!--//doc-section-->

                        </div><!--//content-inner-->
                    </div><!--//doc-content-->

        

    
