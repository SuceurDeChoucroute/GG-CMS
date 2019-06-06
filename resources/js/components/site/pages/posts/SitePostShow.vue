<template>
    <div class="row">
        <div class="col-lg-12 text-center" v-show="loading">
            <b-spinner style="width: 3rem; height: 3rem;" variant="dark" label="Loading"></b-spinner>
        </div>
        
        <div class="col-lg-8 mx-auto" v-show="!loading">
            <h2> {{ post.title }} </h2>
            <p>Posted the {{ post.created_at }} </p>

            <hr>

            <span class="text-center">
                <img :src="post.image" alt="Cover" class="img-fluid rounded">
            </span>

            <hr>

            <span v-html="post.content"></span>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            post: {},
        }
    },

    methods: {
        getPost() {
            this.loading = true
            axios.get('/api/posts/' + this.$route.params.id)
            .then(response => {
                this.post = response.data
                this.loading = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try again")
                this.loading = false
            })
        },
    },

    mounted() {
        this.getPost()
    }
}
</script>

<style>

</style>
