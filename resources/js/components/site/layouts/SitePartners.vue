<template>
    <div class="row mb-4">
        <div class="col-lg-2 col-md-2 col-12 pb-2" v-for="(partner, key) in partners" :key="key">
            <a :href="partner.site" target="_blank">
                <img :src="partner.logo" :alt="partner.name" class="img-fluid rounded" style="max-width: 85px;">
            </a>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            partners: []
        }
    },

    methods: {
        getPartners() {
            this.loadingPage = true
            axios.get('/api/partners')
            .then(response => {
                this.partners = response.data
                this.loadingPage = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try again")
                this.loadingPage = false
            })
        }
    },

    mounted() {
        this.getPartners()
    }
}
</script>

<style>

</style>