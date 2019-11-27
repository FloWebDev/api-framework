<div class="col-12 col-md-10 mx-auto mt-3 mb-3 p-0 text-white bg-dark p-3">
<h2 class="col-12 mx-auto mt-3 mb-3 p-0">Modification d'une entrée</h2>

<!-- Bouton retour -->
<div class="col-12 col-md-10 mx-auto px-0 py-2">
    <a class="btn btn-danger" href="/dashboard" role="button">Retour</a>
</div>

<?php if($entity) : ?>
<form class="col-12 mx-auto px-0 py-2" method="POST">

    <!-- Contenu -->
    <div class="form-group">
        <label for="content">Contenu</label>
<!-- Affichage éventuel du contenu enregistré en $_SESSION afin de ne pas perdre le contenu suite erreur dans la valdation du formulaire-->
<textarea class="form-control" id="content" name="content" rows="5" placeholder="Vas-y ! Fais-nous rire ;-)">
<?php if(!empty($_SESSION['content'])) : ?>
<?= $_SESSION['content']; ?>
<?php unset($_SESSION['content']); ?>
<?php else : ?>
<?= $entity->getContent(); ?>
<?php endif; ?>
</textarea>
    </div>

    <!-- Catégorie -->
    <?php if(!empty($categories)) : ?>
    <div class="form-group">
        <label for="category">Catégorie</label>
        <select class="form-control" id="category" name="category">
                <option disabled>Sélectionnez une catégorie</option>
            <?php foreach($categories as $category) : ?>

            <option value="<?= $category->getId(); ?>" <?php if($category->getId() == $entity->getCategoryId()) : ?>selected<?php endif; ?>><?= $category->getName(); ?></option>

            <?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>

    <!-- Bouton de validation -->
    <input type="submit" class="btn btn-light" value="Modifier">
</form>
<?php else : ?>
    <p class="card col-12 mx-auto">Aucun résultat à afficher.</p>
<?php endif; ?>
</div>