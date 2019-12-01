
        <nav aria-label="pagination" class="card col-12 my-3 p-0 border-0 bg-white">
            <ul class="pagination my-0 mx-auto">
                <?php if($pages['previousPage']) : ?>
                    <li class="page-item mx-2"><a class="page-link text-success bg-white ml-0" href="<?= $router->generate('dashboard'); ?>?page=<?= $pages['previousPage'] ?>" title="Page précédente"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
                <?php endif; ?>
                    <li class="page-item mx-2"><a class="page-link text-success bg-white ml-0" href="<?= $router->generate('dashboard'); ?>" title="Retour au début de la liste"><i class="fas fa-list"></i></a></li>
                    <li class="page-item mx-2"><a class="page-link text-success bg-white ml-0" href="<?= $router->generate('dashboard'); ?>?page=<?= $pages['nextPage'] ?>"><i class="fas fa-arrow-alt-circle-right" title="Page suivante"></i></a></li>
            </ul>
        </nav>
