
                    <div class="doc-content col-md-10 mx-auto col-12 order-2">
                        <div class="content-inner">
                            <section id="getting-started-section" class="doc-section">
                                <h2 class="section-title">Formulaire</h2>
                                <div class="section-block">

<!-- Bouton retour -->
<div class="px-0 py-2">
    <a class="btn btn-success text-white" href="<?= $router->generate('dashboard'); ?>" role="button">Retour</a>
</div>

<form class="px-0 py-2" method="POST">

    <!-- Contenu -->
    <div class="form-group">
        <label for="content"><b>Contenu</b></label>
<!-- Affichage éventuel du contenu enregistré en $_SESSION afin de ne pas perdre le contenu suite erreur dans la valdation du formulaire-->
<textarea class="form-control border border-dark" id="content" name="content" rows="5" placeholder="Vas-y ! Fais-nous rire ;-)">
<?= !empty($_SESSION['content']) ? $_SESSION['content'] : ''; ?>
</textarea>
<!-- Suppression du contenu en session -->
<?php unset($_SESSION['content']); ?>

    </div>

    <!-- Catégorie -->
    <?php if(!empty($categories)) : ?>
    <div class="form-group">
        <label for="category"><b>Catégorie</b></label>
        <select class="form-control border border-dark" id="category" name="category">
                <option selected disabled>Sélectionnez une catégorie</option>
            <?php foreach($categories as $category) : ?>

                <option value="<?= $category->getId(); ?>"><?= $category->getName(); ?></option>

            <?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>

    <!-- Bouton de validation -->
    <input type="hidden" value="<?= $token; ?>" name="token">
    <input type="submit" class="btn btn-dark" value="Ajouter">
</form>

                                </div>
                            </section><!--//doc-section-->

                        </div><!--//content-inner-->
                    </div><!--//doc-content-->

        

    
