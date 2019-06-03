<template>
    <div class="row">
        <div class="col-lg-8 mx-auto" v-html="rules">
            <!-- {{ rules }} -->
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            rules: "",
        }
    },

    methods: {
        getRules() {
            this.loading = true
            axios.get('/api/rules')
            .then(response => {
                this.rules = response.data.content
                this.loading = false
            })
            .catch(() => {
                alert('Something went wrong')
                this.loading = false
            })
        }
    },

    mounted() {
        this.getRules()
    }
}
</script>

<style>

</style>
