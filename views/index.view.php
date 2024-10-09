<?php require 'partials/head.php'; ?>
<?php require 'partials/nav.php'; ?>
<?php require 'partials/banner.php'; ?>

<main class="dark:text-white">
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <h2 class="font-bold">Prodotti</h2>

        <ul>
            <?php foreach ($products as $product): ?>
                <li><?= $product['name'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</main>

<?php require 'partials/footer.php'; ?>