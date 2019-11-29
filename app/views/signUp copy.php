<div class="text-white bg-dark mb-3 col-12 mx-auto py-3">

<h1 class="col-12 col-md-12 mx-auto text-center mt-3 mb-3 p-0">Formulaire d'inscription</h1>

<form class="col-12 col-md-5 mx-auto" action="" method="POST">

  <div class="form-group">
    <label for="username">Identifiant (*)</label>
    <input type="text" class="form-control" id="username" placeholder="Idenfitiant" name="username"
    value="<?= !empty($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
    <!-- Suppression username en session -->
    <?php unset($_SESSION['username']); ?>
    <small id="username" class="form-text text-muted">Ne communiquez jamais votre identifiant ou mot de passe à un tiers.</small>
  </div>

  <div class="form-group">
    <label for="password">Mot de passe (*)</label>
    <input type="password" class="form-control" id="password" placeholder="Mot de passe" name="password">
  </div>

  <div class="form-group">
    <label for="confirmPassword">Mot de passe (confirmation) (*)</label>
    <input type="password" class="form-control" id="confirmPassword" placeholder="Mot de passe (confirmation)" name="confirmPassword">
  </div>

  <?php if(!empty($roles) && is_array($roles)) : ?>
      <div class="form-group">
        <label for="role">Rôle utilisateur</label>
        <select class="form-control" id="role" name="role">
            <option selected disabled>Choisir un rôle utilisateur</option>
          <?php foreach($roles as $role) : ?>
            <option value="<?= $role->getId() ?>"><?= $role->getName() ?> - [<?= $role->getCode() ?>]</option>
          <?php endforeach; ?>
        </select>
        <small id="notaBene" class="form-text text-muted">Le rôle <strong>Rédacteur</strong> sera attribué par défaut si aucun rôle n'est choisi.</small>
      </div>
  <?php endif; ?>

  <button type="submit" class="btn btn-light">Valider</button>
</form>

</div>