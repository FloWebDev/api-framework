
                    <div class="doc-content col-12 order-2">
                        <div class="content-inner">
                            <section id="getting-started-section" class="doc-section">
                                <h2 class="section-title"><i class="fas fa-sign-in-alt"></i> Formulaire d'inscription</h2>
                                <div class="section-block">


                                


<div class="text-dark bg-white mb-3 col-12 mx-auto py-3">

<!-- Bouton ajout nouveau utilisateurs -->
<div class="col-12 px-0 py-2 ml-3">
    <a class="btn btn-success text-white" href="/users" role="button"><i class="fas fa-users"></i> Liste</a>
</div>

<form class="col-12" action="" method="POST">

  <div class="form-group">
    <label for="username"><b>Identifiant (*)</b></label>
    <input type="text" class="form-control border border-dark" id="username" placeholder="Idenfitiant" name="username"
    value="<?= !empty($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
    <!-- Suppression username en session -->
    <?php unset($_SESSION['username']); ?>
    <small id="username" class="form-text text-muted">Ne communiquez jamais votre identifiant ou mot de passe à un tiers.</small>
  </div>

  <div class="form-group">
    <label for="password"><b>Mot de passe (*)</b></label>
    <input type="password" class="form-control border border-dark" id="password" placeholder="Mot de passe" name="password">
  </div>

  <div class="form-group">
    <label for="confirmPassword"><b>Mot de passe (confirmation) (*)</b></label>
    <input type="password" class="form-control border border-dark" id="confirmPassword" placeholder="Mot de passe (confirmation)" name="confirmPassword">
  </div>

  <?php if(!empty($roles) && is_array($roles)) : ?>
      <div class="form-group">
        <label for="role"><b>Rôle utilisateur</b></label>
        <select class="form-control border border-dark" id="role" name="role">
            <option selected disabled>Choisir un rôle utilisateur</option>
          <?php foreach($roles as $role) : ?>
            <option value="<?= $role->getId() ?>"><?= $role->getName() ?> - [<?= $role->getCode() ?>]</option>
          <?php endforeach; ?>
        </select>
        <small id="notaBene" class="form-text text-muted">Le rôle <strong>Rédacteur</strong> sera attribué par défaut si aucun rôle n'est choisi.</small>
      </div>
  <?php endif; ?>

  <button type="submit" class="btn btn-dark">Valider</button>
</form>

</div>






                                </div>
                            </section><!--//doc-section-->

                        </div><!--//content-inner-->
                    </div><!--//doc-content-->

        

    
