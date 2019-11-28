
                    <div class="doc-content col-md-6 mx-auto col-12 order-2">
                        <div class="content-inner">
                            <section id="getting-started-section" class="doc-section">
                                <h2 class="section-title">Formulaire</h2>
                                <div class="section-block">

<form class="text-dark bg-white border border-success rounded" action="" method="POST">

<div class="col-12 col-md-10 mx-auto py-2 my-3">

  <h2 class="col-12 mx-auto text-center mt-3 mb-3 p-0">
    <?php if(!empty($h2Title)) : ?>
    <?= $h2Title; ?>
    <?php else : ?>
    <?= CFG_H2_TITLE; ?>
    <?php endif; ?>
  </h2>

  <p class="col-12 col-md-12 mx-auto text-center mb-2 p-0 text-danger">
    L'accès est réservé aux administrateurs, modérateurs et rédacteurs du site.<br>
    Si vous souhaitez obtenir un token pour l'utlisation de l'API, rendez-vous sur : <a href="/token" class="text-dark"><u>Obtenir un token</u></a>
  </p>

    <div class="form-group mb-2">
      <label for="username" class="font-weight-bold">Identifiant</label>
      <input type="text" class="form-control border border-success" id="username" placeholder="Idenfitiant" name="username"
      value="<?php if(!empty($_SESSION['username'])) : ?>
<?= $_SESSION['username']; ?>
<?php unset($_SESSION['username']); ?>
<?php endif; ?>">
      <small id="notaBene" class="form-text text-white">Ne communiquez jamais votre identifiant ou mot de passe à un tiers.</small>
    </div>

    <div class="form-group">
      <label for="password" class="font-weight-bold">Mot de passe</label>
      <input type="password" class="form-control border border-success" id="password" placeholder="Mot de passe" name="password">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-dark">Connexion</button>
    </div>

</div>

</form>

                                </div>
                            </section><!--//doc-section-->

                        </div><!--//content-inner-->
                    </div><!--//doc-content-->

        

    
