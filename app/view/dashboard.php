<div class="text-white bg-dark mb-3 col-12 mx-auto py-3">
<!-- Bouton ajout nouvelle entré -->
<div class="col-12 col-md-10 mx-auto px-0 py-2">
    <a class="btn btn-success" href="/new/entity" role="button"><i class="fas fa-plus-circle"></i> Ajouter</a>
    <?php if($user && $user->getRole()->getCode() === 'ROLE_ADMIN') : ?>
    <a class="btn btn-warning" href="/purge/entities" role="button" id="deletePurge"><i class="fas fa-exclamation-triangle" style="color: red;"></i> Purge</a>
    <?php endif; ?>
</div>

<!-- Affichage de la pagination -->
<?php if(!empty($pages)) : ?>
    <?php include __DIR__ . '/layout/pagination.php'; ?>
<?php endif; ?>

<?php if(!empty($entities)) : ?>
    <?php foreach($entities as $entity) : ?>
        <div class="card col-12 col-md-10 mx-auto text-white bg-secondary mb-2">
            <div class="card-body">
                <h5 class="card-title">Blague #<?= $entity->getId(); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    <?php if($entity->getCategory()) : ?>
                        <?= $entity->getCategory()->getName(); ?>
                    <?php else : ?>
                        <!-- Si la catégorie n'existe pas ou plus -->
                        <?= 'NC'; ?>
                    <?php endif; ?>
                </h6>
                <p class="card-text"><?= nl2br($entity->getContent()); ?></p>
                <?php if($user && in_array($user->getRole()->getCode(), ['ROLE_ADMIN', 'ROLE_MODO'])) : ?>
                    <a href="/update/entity/<?= $entity->getId() ?>" class="card-link text-dark"><i class="fas fa-edit"></i> Modifier</a>
                    <a href="/delete/entity/<?= $entity->getId() ?>" class="card-link text-dark deleteButton"><i class="fas fa-trash-alt"></i> Suppprimer</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

<!-- Affichage de la pagination -->
<?php if(!empty($pages)) : ?>
    <?php include __DIR__ . '/layout/pagination.php'; ?>
<?php endif; ?>

<?php else : ?>
        <p class="card col-12 col-md-10 mx-auto text-dark">Aucun résultat à afficher.</p>
<?php endif; ?>
</div>