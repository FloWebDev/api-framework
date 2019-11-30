
                    <div class="doc-content col-12">
                        <div class="content-inner">
                            <section id="getting-started-section col-12 p-0" class="doc-section">
                                <h2 class="section-title"><i class="fas fa-clipboard-list"></i> Dashboard</h2>
                                <div class="section-block">


<div class="col-12 px-0 py-2">
    <a class="btn btn-success text-white" href="/new/entity" role="button"><i class="fas fa-plus-circle"></i> Ajouter</a>
    <?php if($user && $user->getRole()->getCode() === 'ROLE_ADMIN') : ?>
    <a class="btn btn-warning text-dark" href="/purge?token=<?= $token; ?>" role="button" id="deletePurge"><i class="fas fa-exclamation-triangle" style="color: red;"></i> Purge</a>
    <?php endif; ?>
</div>

<!-- Affichage de la pagination -->
<?php if(!empty($pages)) : ?>
    <?php include __DIR__ . '/layout/pagination.php'; ?>
<?php endif; ?>

<?php if(!empty($entities)) : ?>
    <?php foreach($entities as $entity) : ?>
        <div class="card col-12 text-dark bg-white mb-2 border border-secondary">
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
                <h6 class="card-subtitle mb-2 text-muted">Vote : <?= !empty($entity->getVote()) ? $entity->getVote() : '0'; ?></h6>
                <?php if($user && in_array($user->getRole()->getCode(), ['ROLE_ADMIN', 'ROLE_MODO'])) : ?>
                    <a href="/update/entity/<?= $entity->getId() ?>" class="card-link text-dark"><i class="fas fa-edit"></i> Modifier</a>
                    <a href="/delete/entity/<?= $entity->getId() ?>?token=<?= $token; ?>" class="card-link text-dark deleteButton"><i class="fas fa-trash-alt"></i> Suppprimer</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

<!-- Affichage de la pagination -->
<?php if(!empty($pages)) : ?>
    <?php include __DIR__ . '/layout/pagination.php'; ?>
<?php endif; ?>

<?php else : ?>
        <p class="card col-12 text-dark">Aucun résultat à afficher.</p>
<?php endif; ?>






    
                                </div>
                            </section><!--//doc-section-->

                        </div><!--//content-inner-->
                    </div><!--//doc-content-->

        

    
