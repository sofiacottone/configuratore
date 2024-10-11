<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/nav.php'); ?>
<?php require base_path('views/partials/banner.php'); ?>

<main class="dark:text-white">

    <div id="products-page" class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">


        <div class="bg-white dark:bg-gray-700">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">

                <!-- products -->
                <ul class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    <?php foreach ($products as $product) : ?>
                        <li class="group relative cursor-pointer js-open-modal" data-product-id="<?= $product['id'] ?>" data-product-name="<?= $product['name'] ?>" data-product-price="<?= $product['price'] ?>">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 dark:bg-gray-800 lg:aspect-none group-hover:opacity-75 lg:h-80">
                                <img src="https://striano.io/wp-content/uploads/2023/10/e9697ba81c24857d041035de729cd174c4b04b4f-2800x1200-1.png" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-700 dark:text-indigo-500">
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

        <!-- modal  -->
        <div id="product-modal" class="hidden relative z-50" role="dialog" aria-modal="true">

            <div class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 transition-opacity md:block" aria-hidden="true"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">

                    <div class="flex w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl">
                        <div class="relative flex w-full items-center overflow-hidden bg-white dark:bg-gray-700 px-4 pb-8 pt-14 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                            <button type="button" class="modal-close absolute right-4 top-4 text-gray-400 hover:text-gray-500 sm:right-6 sm:top-8 md:right-6 md:top-6 lg:right-8 lg:top-8">
                                <span class="sr-only">Chiudi</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <div class="grid w-full grid-cols-1 items-start gap-x-6 gap-y-8 sm:grid-cols-12 lg:gap-x-8">
                                <div class="aspect-h-3 aspect-w-2 overflow-hidden rounded-lg bg-gray-100 sm:col-span-4 lg:col-span-5">
                                    <img src="https://striano.io/wp-content/uploads/2023/10/e9697ba81c24857d041035de729cd174c4b04b4f-2800x1200-1.png" alt="Green software placeholder." class="object-cover object-center">
                                </div>
                                <div class="sm:col-span-8 lg:col-span-7">
                                    <!-- product name  -->
                                    <h2 class="modal-title text-2xl font-bold text-gray-900 dark:text-white sm:pr-12"></h2>

                                    <section aria-labelledby="information-heading" class="mt-2">
                                        <h3 id="information-heading" class="sr-only">Informazioni</h3>

                                        <!-- // product price  -->
                                        <p class="modal-price text-2xl text-gray-900 dark:text-white"></p>
                                    </section>

                                    <!-- product options  -->
                                    <section aria-labelledby="options-heading" class="mt-10">
                                        <h3 id="options-heading" class="sr-only">Opzioni dei prodotti</h3>

                                        <form class="flex flex-col gap-4">
                                            <div>
                                                <label for="sites_number" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Numero sedi</label>
                                                <div class="mt-2">
                                                    <select id="sites_number" name="sites_number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                                        <option value="1">1 sede</option>
                                                        <option value="2">2-5 sedi</option>
                                                        <option value="3">6+ sedi</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="users_number" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Numero utenti</label>
                                                <div class="mt-2">
                                                    <select id="users_number" name="users_number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                                        <option value="1">1</option>
                                                        <option value="2">Fino a 10</option>
                                                        <option value="3">Oltre 10</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="annual_waste" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Volume annuale di rifiuti gestiti</label>
                                                <div class="mt-2">
                                                    <select id="annual_waste" name="annual_waste" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                                        <option value="1">Fino a 100 tonnellate</option>
                                                        <option value="2">Fino a 1.000 tonnellate</option>
                                                        <option value="3">Oltre 1.000 tonnellate</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Tipo di abbonamento</p>
                                                <div class="mt-2 flex items-center gap-3">
                                                    <div class="flex items-center gap-x-3">
                                                        <input checked id="monthly" name="subscription_type" value="monthly" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                        <label for="monthly" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Mensile</label>
                                                    </div>
                                                    <div class="flex items-center gap-x-3">
                                                        <input id="annually" name="subscription_type" value="annually" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                        <label for="annually" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Annuale (20% di sconto)</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="modal-submit mt-4 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Aggiungi al carrello</button>
                                        </form>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal  -->

    </div>
    <?php require base_path('views/partials/shopping-cart.php'); ?>
</main>

<?php require base_path('views/partials/footer.php'); ?>