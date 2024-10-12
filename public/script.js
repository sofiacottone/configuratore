// VARIABLES

// init cart to empty array or get data from localStorage (if any)
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// init shopping cart total price to 0
let totalPrice = 0;

// product info 
let productName, productPrice, productId;

// product configuration
let sites_number = document.getElementById('sites_number');
let users_number = document.getElementById('users_number');
let annual_waste = document.getElementById('annual_waste');
let subscription_type;


// FUNCTIONS

// close element 
function closeElement(el) {
    el.classList.add('hidden');
}

// calculate the price of each product based on the configuration
function calculateProductPrice(basePrice, config) {
    let finalPrice = parseFloat(basePrice);

    // check the values of the config selection
    // sites number
    if (config.sites_number.value === '2') {
        finalPrice *= 1.1;
    } else if (config.sites_number.value === '3') {
        finalPrice *= 1.2
    }

    // users number
    if (config.users_number.value === '2') {
        finalPrice *= 1.1;
    } else if (config.users_number.value === '3') {
        finalPrice *= 1.2
    }

    // annual waste
    if (config.annual_waste.value === '2') {
        finalPrice *= 1.1;
    } else if (config.annual_waste.value === '3') {
        finalPrice *= 1.2
    }

    // check the subscription type
    if (config.subscription_type === 'annually') {
        finalPrice *= 12;
        // 20% discount
        finalPrice *= 0.8;
    }

    return finalPrice.toFixed(2);

}

// calculate the total price of the order
function calculateTotalPrice(cart) {
    totalPrice = 0;
    cart.forEach((product) => {
        // calculate single product price
        const productPrice = calculateProductPrice(product.basePrice, product.config);

        // sum product price to total price
        totalPrice += parseFloat(productPrice);
    });

    // save to ls
    localStorage.setItem('totalPrice', totalPrice.toFixed(2));

    return totalPrice.toFixed(2);
}


window.addEventListener('DOMContentLoaded', (event) => {

    // functions to call only in the products page (index)
    const productsElement = document.getElementById('products-page');
    if (productsElement) {

        // MODAL
        // trigger to open -> .js-open-modal
        // modal id -> product-modal
        // dataset -> productName, productPrice
        // html elements to print data into -> name: .modal-title; price: .modal-price
        // submit button (to add items to cart) -> .modal-submit
        // close button (x) -> .modal-close

        // get the btn that opens the modal
        const allOpenButtons = document.querySelectorAll('.js-open-modal');

        // get the modal
        const productModal = document.getElementById('product-modal');

        // update price
        function updatePrice() {
            // get product config values
            const subscription_type = document.querySelector('input[name="subscription_type"]:checked').value;
            const sites_number_value = sites_number.value;
            const users_number_value = users_number.value;
            const annual_waste_value = annual_waste.value;

            // create a temporary obj with the current configuration
            const currentConfig = {
                sites_number: { value: sites_number_value },
                users_number: { value: users_number_value },
                annual_waste: { value: annual_waste_value },
                subscription_type
            };

            // calculate the new price based on the current product config
            const newPrice = calculateProductPrice(productPrice, currentConfig);

            // update price displayed in the modal
            productModal.querySelector('.modal-price').textContent = `${newPrice}€`;
        }

        // reset form
        function resetForm() {
            // reset input values 
            sites_number.value = '1';
            users_number.value = '1';
            annual_waste.value = '1';

            // reset input radios to 'monthly' value
            const subscriptionRadios = document.querySelectorAll('input[name="subscription_type"][value="monthly"]');
            subscriptionRadios.forEach(radio => {
                radio.checked = true;
            });

            // update price
            updatePrice();
        }

        allOpenButtons.forEach((openButton) => {
            openButton.addEventListener('click', function () {
                resetForm();
                // open the modal
                productModal.classList.remove('hidden');

                // close the modal (x)
                const close = productModal.querySelector('.modal-close');
                close.onclick = function () {
                    closeElement(productModal);
                }

                // get product info from dataset
                productName = this.dataset.productName;
                productPrice = Number(this.dataset.productPrice);
                productId = this.dataset.productId;

                // add event listener to inputs and selects to update product price on change
                sites_number.addEventListener('change', updatePrice);
                users_number.addEventListener('change', updatePrice);
                annual_waste.addEventListener('change', updatePrice);
                const subscriptionRadios = document.querySelectorAll('input[name="subscription_type"]');
                subscriptionRadios.forEach(radio => {
                    radio.addEventListener('change', updatePrice);
                });

                // call updatePrice to set initial price
                updatePrice();

                // print html inside the modal
                productModal.querySelector('.modal-title').textContent = productName;

                // get the btn that submits the modal
                const modalSubmit = document.querySelector('.modal-submit');

                // submit the form
                modalSubmit.addEventListener('click', function (e) {
                    e.preventDefault();

                    // get product config options values
                    subscription_type = document.querySelector('input[name="subscription_type"]:checked').value;

                    // get the selected options text
                    const sites_number_text = sites_number.options[sites_number.selectedIndex].text;
                    const users_number_text = users_number.options[users_number.selectedIndex].text;
                    const annual_waste_text = annual_waste.options[annual_waste.selectedIndex].text;


                    // create a new product to be added to the cart
                    let product = {
                        id: Date.now(),
                        productId: productId,
                        productName: productName,
                        basePrice: productPrice,
                        updatedPrice: 0,
                        config: {
                            sites_number: { text: sites_number_text, value: sites_number.value },
                            users_number: { text: users_number_text, value: users_number.value },
                            annual_waste: { text: annual_waste_text, value: annual_waste.value },
                            subscription_type
                        }
                    };

                    // call function to add product to cart
                    addToCart(product);

                    // close modal
                    closeElement(productModal);
                }, { once: true });

            })
        });
        // END MODAL


        // SHOPPING CART
        // trigger to open -> #open-cart
        // cart id -> shopping-cart
        // html elements to print data into -> 
        //      name: .product-title; 
        //      price: .product-price; 
        //      options: .product-options; 
        //      total price: .cart-total-price;
        // remove button (remove items from cart) -> .cart-remove
        // submit button (purchase items) -> .cart-submit
        // close button (x) -> .cart-close

        // get the btn to open cart
        const openCartButton = document.getElementById('open-cart');

        // get the cart element
        const shoppingCart = document.getElementById('shopping-cart');

        openCartButton.addEventListener('click', function () {
            // update cart
            updateShoppingCart(cart);

            // open the cart 
            shoppingCart.classList.remove('hidden');

            // set total price
            document.querySelector('.cart-total-price').textContent = `${totalPrice}€`;

            // close the cart
            const close = document.querySelector('.cart-close');
            close.onclick = function () {
                closeElement(shoppingCart);
            }


        });

        // update shopping cart
        function updateShoppingCart() {
            cart = JSON.parse(localStorage.getItem('cart')) || [];

            // get the items container (ul)
            const cartItemsContainer = document.getElementById('cart-items');
            // empty the container
            cartItemsContainer.innerHTML = '';

            // get checkout button
            const checkoutBtn = document.getElementById('checkout-btn');

            // if the shopping cart is empty display a message
            if (cart.length === 0) {
                const emptyMessage = document.createElement('li');
                emptyMessage.className = "text-center text-gray-500";
                emptyMessage.textContent = 'Il carrello è vuoto';
                cartItemsContainer.appendChild(emptyMessage);

                // hide checkout btn if the cart is empty
                checkoutBtn.classList.add('hidden');
            } else {
                // show checkout btn 
                checkoutBtn.classList.remove('hidden');

                // loop every product in the cart
                cart.forEach((product, index) => {
                    let finalPrice = calculateProductPrice(product.basePrice, product.config);

                    // update product to store final price
                    const updatedProduct = {
                        ...product,
                        updatedPrice: finalPrice
                    };

                    // update cart with the updated product
                    cart[index] = updatedProduct;

                    const { id, productName, config } = updatedProduct;
                    const { text: sitesNumber } = config.sites_number;
                    let { text: usersNumber } = config.users_number;
                    const { text: annualWaste } = config.annual_waste;
                    const subscriptionType = config.subscription_type === 'monthly' ? 'Abbonamento mensile' : 'Abbonamento annuale';

                    if (config.users_number.value === '1') {
                        usersNumber = '1 utente'
                    } else {
                        usersNumber = `${usersNumber} utenti`
                    }

                    // create a new <li> for each item in the cart
                    let newLi = document.createElement('li');
                    newLi.className = "flex py-6";
                    newLi.setAttribute('data-id', id);

                    // populate the <li> with the product data
                    newLi.innerHTML = `
                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                    <img src="https://striano.io/wp-content/uploads/2023/10/e9697ba81c24857d041035de729cd174c4b04b4f-2800x1200-1.png" alt="Green software placeholder" class="h-full w-full object-cover object-center">
                </div>
    
                <div class="ml-4 flex flex-1 flex-col">
                    <div>
                        <div class="flex justify-between text-base font-medium text-gray-900">
                            <h3 class="product-title">${productName}</h3>
                            <p class="product-price ml-4">${finalPrice}€</p>
                        </div>
                        <ul class="product-options mt-1 text-sm text-gray-500">
                            <li>${sitesNumber}</li>
                            <li>${usersNumber}</li>
                            <li>${annualWaste}</li>
                            <li>${subscriptionType}</li>
                        </ul>
                    </div>
                    <div class="flex flex-1 items-end justify-end text-sm">
                        <button type="button" class="cart-remove font-medium text-indigo-600 hover:text-indigo-500">Rimuovi</button>
                    </div>
                </div>
            `;

                    // add the item to the container
                    cartItemsContainer.appendChild(newLi);


                    // calculate cart total price
                    totalPrice = calculateTotalPrice(cart);
                    // update total price in the DOM
                    document.querySelector('.cart-total-price').textContent = `${totalPrice}€`;
                    // update ls
                    localStorage.setItem('totalPrice', totalPrice);

                    // remove item from cart
                    const removeButton = newLi.querySelector('.cart-remove');
                    removeButton.addEventListener('click', function () {
                        removeFromCart(id);
                        // update total price
                        totalPrice = calculateTotalPrice(cart);
                        // update total price in the DOM
                        document.querySelector('.cart-total-price').textContent = `${totalPrice}€`;
                    });

                    // update localstorage
                    localStorage.setItem('cart', JSON.stringify(cart));
                })
            }

        }

        // add products to cart
        function addToCart(product) {
            cart = JSON.parse(localStorage.getItem('cart')) || [];

            calculateProductPrice(product.price, product.config);

            // add new product
            cart.push(product);

            // update localstorage
            localStorage.setItem('cart', JSON.stringify(cart));

            updateShoppingCart(cart);

        }

        // remove products from cart
        function removeFromCart(uniqueId) {
            // filter cart to remove the product with the selected id
            cart = cart.filter((product) => product.id !== uniqueId);

            // update localstorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // update the shopping cart
            updateShoppingCart(cart);

        }

        // EMPTY CART
        const emptyCartButton = document.getElementById('empty-cart');

        emptyCartButton.addEventListener('click', function () {
            // empty cart
            cart = [];

            // update localstorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // update shopping cart
            updateShoppingCart()

            // update cart total price
            totalPrice = calculateTotalPrice(cart);
            document.querySelector('.cart-total-price').textContent = `${totalPrice}€`;
        });
        // END EMPTY CART


        // END SHOPPING CART
    }


    // functions to call only in the checkout page
    const checkoutElement = document.getElementById('checkout-page');
    if (checkoutElement) {
        // call the function to display the order summary
        displayOrderSummary();

        // on click to the purchase button send the cart data to the server
        const purchaseBtn = document.getElementById('purchase-btn');
        purchaseBtn.addEventListener('click', sendDataToServer());
    }

});


// SUMMARY SECTION

// display order summary before purchase
function displayOrderSummary() {

    // get cart and order total price from localStorage
    let storedCart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalPrice = localStorage.getItem('totalPrice') || 0;


    // get summary list container
    const summaryList = document.getElementById('summary-list');
    summaryList.innerHTML = '';

    storedCart.forEach((product) => {
        // get product data
        const { productName, updatedPrice, config } = product;
        const { text: sitesNumber } = config.sites_number;
        let { text: usersNumber } = config.users_number;
        const { text: annualWaste } = config.annual_waste;
        const subscriptionType = config.subscription_type === 'monthly' ? 'Abbonamento mensile' : 'Abbonamento annuale';

        if (config.users_number.value === '1') {
            usersNumber = '1 utente'
        } else {
            usersNumber = `${usersNumber} utenti`
        }

        // create a new <li> for each item in the ls cart
        let newLi = document.createElement('li');
        newLi.className = "p-2 shadow shadow-white/20";

        // populate the <li> with the product data
        newLi.innerHTML = `
            <div class="flex gap-6">
                <h3 class="summary-product-name">${productName}</h3>
                <p class="summary-product-price">${updatedPrice}€</p>
            </div>
            <ul class="summary-product-options mt-1 ml-3 text-sm text-gray-500">
                <li>${sitesNumber}</li>
                <li>${usersNumber}</li>
                <li>${annualWaste}</li>
                <li>${subscriptionType}</li>
            </ul>
        `;

        // add the item to the container
        summaryList.appendChild(newLi);

    });

    // display the total price of the order
    document.querySelector('.summary-total-price').textContent = `${totalPrice}€`;
}

// send cart and form data to the server
function sendDataToServer() {
    // get the cart and the order total price from localStorage
    let cart = JSON.parse(localStorage.getItem('cart'));
    let totalPrice = localStorage.getItem('totalPrice') || 0;

    // check if the cart exists and is not empty
    if (!cart || cart.length === 0) {
        console.error('Il carrello è vuoto');
        return;
    }

    // get form data
    const form = document.getElementById('checkout-form');

    // create an empty obj for form data
    let formData = {};

    // select all inputs
    let inputs = form.querySelectorAll('input');

    // submit
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // loop through inputs to add values to the formData object
        inputs.forEach((input) => {
            // use the input name as key
            formData[input.name] = input.value;
        });

        // create a single obj to send
        let dataToSend = {
            cart,
            totalPrice,
            customer: formData
        };

        // send data to server
        fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataToSend),
        })
            // convert the server response into json
            .then((response) => response.json())
            .then((data) => {
                // clear previous errors
                document.querySelectorAll('.error-message').forEach(el => el.remove());

                if (data.status === 'success') {
                    // open container to display success message
                    const successContainer = document.getElementById('success-container');
                    if (successContainer) {
                        successContainer.classList.remove('hidden');
                    }
                    // clear previous messages 
                    const messageContainer = document.getElementById('message-container');
                    if (messageContainer) {
                        messageContainer.innerHTML = '';
                        // display success message
                        const successMessage = document.createElement('p');
                        successMessage.textContent = data.message;
                        messageContainer.appendChild(successMessage);
                    }

                    // clear the cart
                    cart = []
                    // update localstorage
                    localStorage.setItem('cart', JSON.stringify(cart));

                }
                else if (data.status === 'error') {

                    // show errors next to the corresponding inputs
                    for (let field in data.errors) {
                        const errorMessage = document.createElement('p');
                        errorMessage.classList.add('text-red-500', 'text-xs', 'error-message');
                        errorMessage.textContent = data.errors[field];

                        // find the corresponding input field and append the error
                        const inputField = document.querySelector(`[name="${field}"]`);
                        if (inputField) {
                            inputField.insertAdjacentElement('afterend', errorMessage);
                        }
                    }
                } else {
                    // print server data
                    console.log('Successo:', data);
                }
            })
            // handle errors if any
            .catch((error) => {
                console.error('Errore:', error);
            });
    })

}

// END SUMMARY SECTION