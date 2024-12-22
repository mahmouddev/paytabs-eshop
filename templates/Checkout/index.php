<div id="app" class="container py-5">
    <div class="row">
        <!-- Left Section: Checkout Form -->
        <div v-if="!showIFrame"  class="col-md-8">
            <h3 class="mb-4">Checkout</h3>
            <form @submit.prevent="proceedToPayment">
                <!-- Delivery Option -->
                <div class="row g-2 mb-3">
                    <h5>Delivery Option</h5>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="deliveryOption" id="shipping" value="shipping" v-model="deliveryOption" required>
                            <label class="form-check-label" for="shipping">Ship to Address</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="deliveryOption" id="pickup" value="pickup" v-model="deliveryOption" required>
                            <label class="form-check-label" for="pickup">Pick Up</label>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="row g-2">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" v-model="customer.firstName" placeholder="John" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" v-model="customer.lastName" placeholder="Doe" required>
                    </div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" v-model="customer.email" placeholder="you@example.com" required>
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" v-model="customer.phone" placeholder="123-456-7890" required>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="mt-3">
                    <div class="row g-2">
                        <div class="col-md-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" v-model="customer.street1" placeholder="1234 Main St" required>
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-md-6">
                            <label for="country" class="form-label">Country</label>
                            <select v-model="customer.country" id="country" class="form-select">
                                <option value="" disabled>Select Country</option>
                                <option v-for="(countryName, countryCode) in countries" :key="countryCode" :value="countryCode">
                                    {{ countryName }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label">City</label>
                            <select v-model="customer.city" id="city" class="form-select">
                                <option value="" disabled>Select City</option>
                                <option v-for="city in filteredCities" :key="city" :value="city">
                                    {{ city }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" v-model="customer.state" placeholder="State" required>
                        </div>
                        <div class="col-md-6">
                            <label for="zip" class="form-label">ZIP</label>
                            <input type="text" class="form-control" id="zip" v-model="customer.zip" placeholder="ZIP Code" required>
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3" :disabled="!isFormValid()">Proceed to Payment</button>
            </form>
        </div>

        <div v-else class="col-md-8">
            <h3 class="mb-4">Complete Your Payment</h3>
            <iframe
                :src="paymentUrl"
                width="100%"
                height="600"
                frameborder="0"
                allow="payment"
            ></iframe>
        </div>
        <!-- Right Section: Cart Details -->
        <div class="col-md-4">
            <div id="offcanvasCart">
                <div class="offcanvas-body">
                    <div class="order-md-last">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary">Your cart</span>
                            <span class="badge bg-primary rounded-pill">{{ cart.length }}</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <li v-for="cartItem in cart" :key="cartItem.id" class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">{{ cartItem.name }}  ({{ cartItem.quantity }})</h6>
                                    <small class="text-body-secondary">{{ cartItem.description }}</small>
                                </div>
                                <span class="text-body-secondary">E£ {{ (cartItem.price * cartItem.quantity).toFixed(2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (EGP)</span>
                                <strong>E£ {{ getCartTotal() }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
