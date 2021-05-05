    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="tools/integrator/getresponse/index.php/view?p=<?= intval($p) - 1?>" aria-label="Previous" title="Go to the previous page">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <li class="page-item disabled">
                <a class="page-link" title="Current page"><?= $p ?></a>
            </li>

            <li class="page-item">
                <a class="page-link" href="tools/integrator/getresponse/index.php/view?p=<?= intval($p) + 1?>" aria-label="Next" title="Go to the next page">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>