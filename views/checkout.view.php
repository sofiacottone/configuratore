<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/nav.php'); ?>
<?php require base_path('views/partials/banner.php'); ?>

<main class="dark:text-white">
    <div id="checkout-page" class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">

        <!-- success message container  -->
        <div id="success-container" class="hidden relative z-50" role="dialog" aria-modal="true">

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto bg-white dark:bg-gray-600/95">
                <div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">

                    <div class="flex flex-col gap-20 justify-center align-center w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl">

                        <div id="message-container" class="w-full text-center text-lg text-green-600">

                        </div>

                        <button type="button" id="close-success-message" class="modal-submit mx-auto rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <a href="/">Torna alla home</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end success message container  -->

        <!-- order summary -->
        <div class="mb-6 py-2 border-b border-gray-900/10">
            <h2 class="text-lg font-semibold">Riepilogo ordine</h2>
            <a href="/" class="font-medium text-sm text-indigo-600 hover:text-indigo-500 cursor-pointer">Modifica</a>

            <ul id="summary-list" class="my-4 flex flex-wrap gap-4"></ul>

            <div class="flex gap-3">
                <p class="font-semibold">Totale:</p>
                <p class="summary-total-price"></p>
            </div>

        </div>

        <!-- customer data  -->
        <form method="POST" action="/checkout" id="checkout-form">
            <div class="space-y-12">
                <div class="error-message"></div>

                <div class="border-b border-gray-900/10 pb-12 text-gray-900 dark:text-white">
                    <h2 class="text-lg font-semibold leading-7">Inserisci le tue informazioni personali per procedere</h2>

                    <div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="full_name" class="block text-sm font-medium leading-6">Nome e cognome</label>
                            <div class="mt-2">
                                <input type="text" name="full_name" id="full_name" required class="block w-full rounded-md border-0 bg-transparent bg-transparent py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium leading-6">Email</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" required class="block w-full rounded-md border-0 bg-transparent py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>


                        <div class="col-span-full">
                            <label for="address" class="block text-sm font-medium leading-6">Indirizzo</label>
                            <div class="mt-2">
                                <input type="text" name="address" id="address" required class="block w-full rounded-md border-0 bg-transparent py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="tax_code" class="block text-sm font-medium leading-6">Codice Fiscale</label>
                            <div class="mt-2">
                                <input type="text" name="tax_code" id="tax_code" required class="block w-full rounded-md border-0 bg-transparent py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="vat_number" class="block text-sm font-medium leading-6">Partita IVA</label>
                            <div class="mt-2">
                                <input type="text" name="vat_number" id="vat_number" required class="block w-full rounded-md border-0 bg-transparent py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="submit" id="purchase-btn" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Acquista</button>
            </div>
        </form>


    </div>
</main>

<?php require base_path('views/partials/footer.php'); ?>