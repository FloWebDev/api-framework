
        <nav aria-label="pagination" class="card col-12 col-md-10 mx-auto my-3 p-0 border-0 bg-secondary">
            <ul class="pagination my-0 mx-auto">
                <?php if($pages['previousPage']) : ?>
                    <li class="page-item"><a class="page-link text-white bg-dark" href="/dashboard?page=<?= $pages['previousPage'] ?>" title="Page précédente"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
                <?php endif; ?>
                    <li class="page-item"><a class="page-link text-white bg-dark" href="/dashboard" title="Retour au début de la liste"><i class="fas fa-dot-circle"></i></a></li>
                    <li class="page-item"><a class="page-link text-white bg-dark" href="/dashboard?page=<?= $pages['nextPage'] ?>"><i class="fas fa-arrow-alt-circle-right" title="Page suivante"></i></a></li>
            </ul>
        </nav>
