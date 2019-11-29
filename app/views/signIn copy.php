

<form class="col-12 mx-auto text-white bg-dark" action="" method="POST">

  <div class="bg-secondary col-12 col-md-10 mx-auto py-2 my-3">

    <h2 class="col-12 mx-auto text-center mt-3 mb-3 p-0">
      <?php if(!empty($h2Title)) : ?>
      <?= $h2Title; ?>
      <?php else : ?>
      <?= CFG_H2_TITLE; ?>
      <?php endif; ?>
    </h2>

    <p class="col-12 col-md-12 mx-auto text-center mb-2 p-0 text-dark">
      L'accès est réservé aux administrateurs, modérateurs et rédacteurs du site.<br>
      Si vous souhaitez obtenir un token pour l'utlisation de l'API, rendez-vous sur : <a href="/token" class="text-dark"><u>Obtenir un token</u></a>
    </p>

      <div class="form-group col-12 col-md-5 mx-auto mb-2">
        <label for="username">Identifiant</label>
        <input type="text" class="form-control" id="username" placeholder="Idenfitiant" name="username"
        value="<?php if(!empty($_SESSION['username'])) : ?>
<?= $_SESSION['username']; ?>
<?php unset($_SESSION['username']); ?>
<?php endif; ?>">
        <small id="notaBene" class="form-text text-white">Ne communiquez jamais votre identifiant ou mot de passe à un tiers.</small>
      </div>

      <div class="form-group col-12 col-md-5 mx-auto">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" id="password" placeholder="Mot de passe" name="password">
      </div>
      <div class="form-group col-12 col-md-5 mx-auto">
        <button type="submit" class="btn btn-light">Connexion</button>
      </div>

  </div>

</form>