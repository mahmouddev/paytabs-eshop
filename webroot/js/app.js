document.addEventListener('DOMContentLoaded', function () {



    const Cart = {
        props: ['initialCart'],
        data() {
            return {
                // Create a local copy of the cart data to allow reactivity
                cart: this.initialCart,
            };
        },
        template: `
            <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
                <div class="offcanvas-header justify-content-center">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Your cart</span>
                        <span class="badge bg-primary rounded-pill">{{ cart.length }}</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li v-for="cartItem in cart" :key="cartItem.id" class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">{{ cartItem.name }}</h6>
                            <small class="text-body-secondary">{{ cartItem.description }}</small>
                            <div class="d-flex align-items-center mt-2">
                                <button @click="decreaseQuantity(cartItem.id)" class="btn btn-sm btn-danger me-2">-</button>
                                <span>{{ cartItem.quantity }}</span>
                                <button @click="increaseQuantity(cartItem.id)" class="btn btn-sm btn-success ms-2">+</button>
                            </div>
                        </div>
                        <span class="text-body-secondary">E£ {{ (cartItem.price *  cartItem.quantity).toFixed(2) }}</span>
                        <a href="#" @click="removeItem(cartItem.id)" class=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                        <span>Total (EGP)</span>
                        <strong>E£ {{ getCartTotal() }}</strong>
                        </li>
                    </ul>
                    <button @click="checkoutRedirect" class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
                    </div>
                </div>
            </div>
        `,
        methods: {
            getCartTotal() {
                return (this.cart.reduce((acc, item) => acc + item.quantity * item.price, 0)).toFixed(2);
            },
            increaseQuantity(itemId) {
                const item = this.cart.find(cartItem => cartItem.id === itemId);
                if (item) {
                    item.quantity += 1;
                    this.$emit('update-cart', this.cart);
                }
            },
            decreaseQuantity(itemId) {
                const item = this.cart.find(cartItem => cartItem.id === itemId);
                if (item && item.quantity > 1) {
                    item.quantity -= 1;
                    this.$emit('update-cart', this.cart);
                }
            },
            removeItem(itemId) {
                this.cart = this.cart.filter(cartItem => cartItem.id !== itemId);
                this.$emit('update-cart', this.cart);
            },
            checkoutRedirect(){
                window.location.href = '/checkout';
            }
        },
        watch: {
            // Update the local cart whenever the parent updates it
            initialCart: {
                handler(newCart) {
                    this.cart = newCart;
                },
                deep: true
            }
        }
    };

    const app = Vue.createApp({
        data() {
            return {
                snackbar: {
                    show: false,
                    message: '',
                },
                paymentUrl: "",
                showIFrame: false,
                countries: {
                    EG: 'Egypt',
                    SA: 'Saudi Arabia',
                    AE: 'United Arab Emirates'
                },
                cities: {
                    EG: ['Cairo', 'Alexandria', 'Giza'],
                    SA: ['Riyadh', 'Jeddah', 'Dammam'],
                    AE: ['Dubai', 'Abu Dhabi', 'Sharjah']
                },
                cart: [], // Initialize the cart
                customer: {
                    firstName: '',
                    lastName: '',
                    email: '',
                    phone: '',
                    street1: '',
                    country:'',
                    city: '',
                    state: '',
                    zip: '',
                },
                cart_id : '',
                deliveryOption: 'shipping',

            };
        },
        computed: {
            filteredCities() {
                return this.cities[this.customer.country] || [];
            }
        },
        mounted() {
            // Load cart from localStorage
            const savedCart = localStorage.getItem('cart');
            this.cart = savedCart ? JSON.parse(savedCart) : [];

            let cartId = localStorage.getItem('cart_id');

            if(!cartId){
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                cartId = '';
                for (let i = 0; i < 24; i++) {
                    cartId += chars.charAt(Math.floor(Math.random() * chars.length));
                }

                localStorage.setItem('cart_id', cartId);
            }

            this.cart_id = cartId;

        },
        methods: {
            addToCart(product) {
                const existingItem = this.cart.find(item => item.id === product.id);
                if (existingItem) {
                    existingItem.quantity += 1;

                } else {
                    this.cart.push({ ...product, quantity: 1 });
                }
                this.saveCart();
                this.showSnackbar('Product added to cart successfully!');

            },
            updateCart(updatedCart) {
                this.cart = updatedCart;
                this.saveCart();
            },
            saveCart() {

                localStorage.setItem('cart' , JSON.stringify(this.cart));

                const cartId = localStorage.getItem('cart_id');

                if(!cartId){

                    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    let cartId = '';
                    for (let i = 0; i < length; i++) {
                        cartId += chars.charAt(Math.floor(Math.random() * chars.length));
                    }

                    this.cartId = cartId;

                    localStorage.setItem('cart_id', cartId);
                }

            },
            getCartTotal() {
                return (this.cart.reduce((acc, item) => acc + item.quantity * item.price, 0)).toFixed(2);
            },
            isFormValid() {
                if (!this.customer.firstName || !this.customer.lastName || !this.customer.email || !this.customer.phone) {
                    return false;
                }

                if (this.deliveryOption === 'shipping') {
                    return this.customer.street1 && this.customer.city && this.customer.state && this.customer.zip;
                }

                return true;
            },
            proceedToPayment() {

                // Validate inputs
                if (!this.customer.firstName || !this.customer.email || !this.customer.phone) {
                    alert('Please fill in all customer information.');
                    return;
                }

                if (this.deliveryOption === 'shipping' && (!this.customer.street1 || !this.customer.city || !this.customer.country || !this.customer.state || !this.customer.zip)) {
                    alert('Please fill in all shipping details.');
                    return;
                }

                // Process the order (e.g., send data to server or payment gateway)
                const orderData = {
                    customer: this.customer,
                    deliveryOption: this.deliveryOption,
                    cart: this.cart,
                    cart_id : this.cart_id,
                    total: this.getCartTotal()
                };

                fetch('/payments/initializeHostedPaymentPage', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        //'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(orderData)
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success && data.paymentUrl) {
                        this.paymentUrl = data.paymentUrl; // Set the iFrame URL
                        this.showIFrame = true; // Show the iFrame
                        } else {
                        alert("Payment initialization failed.");
                    }
                })
                .catch(error => {
                    console.error("Error preparing payment session:", error);
                    alert("An error occurred. Please try again.");
                });
            },
            showSnackbar(message) {
                this.snackbar.message = message;
                this.snackbar.show = true;
                setTimeout(() => {
                    this.snackbar.show = false;
                }, 3000); // Snackbar disappears after 3 seconds
            },
        }
    });

    // Register the Cart component
    app.component('cart', Cart);

    // Mount the Vue app
    app.mount('#app');
});
