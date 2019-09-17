<?php
require('logger.php');

$p = isset($_GET['p']) ? $_GET['p'] : 1;
$p = ($p <= 1) ? 1 : $p;
$limit = 25;
$log = getResponseReport($p, $limit);
$count = getResponseLogCount();
$low = ($p * $limit) - $limit + 1;
$high = $p * $limit;
?>

<div class="container">
    <p class="lead text-center mt-3">Integrations Response Analyzer and Logger - QA Tools</p>
    <?php if ($low <= $count) :?>
    <p class="text-center font-weight-lighter text-primary">Displaying results <?= $low ?> - <?= $high < $count ? $high : $count ?> of about <?= $count ?>.</p>
    <?php else : ?>
    <p class="text-center font-weight-lighter text-danger">Oops, there's nothing to show in here.</p>
    <?php endif ?>

    <?php include('nav.php') ?>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Type</th>
                <th scope="col">Parsed Response</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($log as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['date'] ?></td>
                <td><?= $row['type'] ?></td>
                <td><?= $row['response'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php include('nav.php') ?>
</div>