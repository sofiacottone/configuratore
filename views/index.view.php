<?php require 'partials/head.php'; ?>
<?php require 'partials/nav.php'; ?>
<?php require 'partials/banner.php'; ?>

<main class="dark:text-white">

    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">


        <div class="bg-white dark:bg-gray-700">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">

                <!-- products -->
                <ul class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    <?php foreach ($products as $product) : ?>
                        <li class="group relative cursor-pointer">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 dark:bg-gray-800 lg:aspect-none group-hover:opacity-75 lg:h-80">
                                <img src="https://striano.io/wp-content/uploads/2023/10/e9697ba81c24857d041035de729cd174c4b04b4f-2800x1200-1.png" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-xl text-gray-700 dark:text-gray-100">
                                        <?= $product['name'] ?>
                                    </h3>
                                </div>
                                <div class="flex justify-end items-center gap-2">
                                    <span class="text-sm">A partire da</span>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                        <?= $product['price'] . '€' ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>
    </div>
</main>

<?php require 'partials/footer.php'; ?>