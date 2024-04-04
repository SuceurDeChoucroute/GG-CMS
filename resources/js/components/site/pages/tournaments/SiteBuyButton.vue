<template>
    <button class="btn btn-lg btn-success" title="Vous pouvez quand même payer votre entrée sur place avant la Lan" :disabled="alreadyPayed || loading" @click="payment()" v-if="tournament.stripe_key">
        <i class="fas fa-plus" v-show="!loading"></i>
        <i class="fas fa-sync-alt fa-spin" v-show="loading"></i>
        Acheter ma place !
    </button>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
        }
    },

    props: {
        user: Object,
        tournament: Object,
        alreadyPayed: Boolean,
    },

    methods: {
        payment() {
            if (!this.alreadyPayed) {
                this.loading = true

                let routeSuccess = process.env.MIX_APP_URL + "/api/payment/" + this.user.secret_key + "/" + this.tournament.id
                let routeFail = process.env.MIX_APP_URL + "/api/payment/fail"
                    
                var stripe = Stripe(process.env.MIX_STRIPE_KEY, {
                    betas: ['checkout_beta_3']
                });
    
                // When the customer clicks on the button, redirect
                // them to Checkout.
                stripe.redirectToCheckout({
                    items: [{ price: this.tournament.stripe_key, quantity: 1 }],
    
                    // Note that it is not guaranteed your customers will be redirected to this
                    // URL *100%* of the time, it's possible that they could e.g. close the
                    // tab between form submission and the redirect.
                    successUrl: routeSuccess,
                    cancelUrl: routeFail,
                })
                .then(function (result) {
                    this.loading = false
                    if (result.error) {
                        // If `redirectToCheckout` fails due to a browser or network
                        // error, display the localized error message to your customer.
                        var displayError = document.getElementById('error-message');
                        displayError.textContent = result.error.message;
                    }
                });
            }

        },
    },
    
}
</script>

<style>

</style>