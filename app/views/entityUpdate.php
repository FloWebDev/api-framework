
                    <div class="doc-content col-md-10 mx-auto col-12 order-2">
                        <div class="content-inner">
                            <section id="getting-started-section" class="doc-section">
                                <h2 class="section-title">Formulaire</h2>
                                <div class="section-block">

    <!-- Bouton retour -->
    <div class="px-0 py-2">
        <a class="btn btn-success text-white" href="/dashboard" role="button">Retour</a>
    </div>

<?php if($entity) : ?>
<form class="col-12 mx-auto px-0 py-2" method="POST">

    <!-- Contenu -->
    <div class="form-group">
        <label for="content"><b>Contenu</b></label>
<!-- Affichage éventuel du contenu enregistré en $_SESSION afin de ne pas perdre le contenu suite erreur dans la valdation du formulaire-->
<textarea class="form-control border border-dark" id="content" name="content" rows="5" placeholder="Vas-y ! Fais-nous rire ;-)">
<?= !empty($_SESSION['content']) ? $_SESSION['content'] : $entity->getContent(); ?>
</textarea>
<!-- Suppression du contenu en session -->
<?php unset($_SESSION['content']); ?>
    </div>

    <!-- Vote -->
  <div class="form-group">
    <label for="vote"><b>Vote</b></label>
    <input type="number" step="1" min ="0" max="99999" class="form-control border border-dark col-md-3 col-6" id="vote" name="vote" value="<?= !empty($_SESSION['vote']) ? $_SESSION['vote'] : $entity->getVote(); ?>">
    <!-- Suppression du contenu en session -->
    <?php unset($_SESSION['vote']); ?>
  </div>

    <!-- Catégorie -->
    <?php if(!empty($categories)) : ?>
    <div class="form-group">
        <label for="category"><b>Catégorie</b></label>
        <select class="form-control border border-dark" id="category" name="category">
                <option disabled>Sélectionnez une catégorie</option>
            <?php foreach($categories as $category) : ?>

            <option value="<?= $category->getId(); ?>" <?= ($category->getId() == $entity->getCategoryId()) ? 'selected' : ''; ?>><?= $category->getName(); ?></option>

            <?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>

    <!-- Bouton de validation -->
    <input type="hidden" value="<?= $token; ?>" name="token">
    <input type="submit" class="btn btn-dark" value="Modifier">
</form>
<?php else : ?>
    <p class="card col-12 mx-auto">Aucun résultat à afficher.</p>
<?php endif; ?>

                                </div>
                            </section><!--//doc-section-->

                        </div><!--//content-inner-->
                    </div><!--//doc-content-->

        

    
