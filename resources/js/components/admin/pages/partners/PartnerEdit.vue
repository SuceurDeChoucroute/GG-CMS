<template>
    <div>
        <admin-content-header page_name="Edit partner" ></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <button @click="goToPartnersList()" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i>
                Return to partner list
            </button>

            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit partner</h3>
                        </div>
                        <div class="box-body">
                            <loader :color="'#337ab7'" v-show="loading"></loader>
                            <form @submit.prevent="updatePartner()" class="form-horizontal" v-show="!loading">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" placeholder="Name" v-model="partner.name" required>
                                    </div>
                                </div>

                                <!-- Site -->
                                <div class="form-group">
                                    <label for="site" class="col-sm-2 control-label">Site</label>

                                    <div class="col-sm-8">
                                        <input type="url" class="form-control" id="site" placeholder="https://..." v-model="partner.site">
                                    </div>
                                </div>

                                <!-- Logo -->
                                <div class="form-group">
                                    <label for="logo" class="col-sm-2 control-label">Logo</label>

                                    <div class="col-sm-8">
                                        <input type="url" class="form-control" id="logo" placeholder="https://..." v-model="partner.logo">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-sync fa-spin" v-show="loading"></i>
                                            <i class="fas fa-check" v-show="!loading"></i>
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        Loader
    },

    data() {
        return {
            loading: false,
            partner: {},
        }
    },

    methods: {
        goToPartnersList() {
            this.$router.push({name: 'partners'});
        },

        getPartner() {
            this.loading = true

            axios.get('/api/partners/' + this.$route.params.id)
            .then(response => {
                this.partner = response.data

                this.loading = false
            })
        },

        updatePartner() {
            this.loading = true

            axios.put('/api/partners/' + this.$route.params.id, this.partner)
            .then(response => {
                this.loading = false

                this.flashMessage.success({
                    title: "Partner updated !",
                    message: "The partner has been successfully added"
                })

                this.$router.push({ name: 'partners' })
            })
            .catch(e => {
                this.loading = false
                console.log(e)

                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please try again"
                })
            })
        },
    },

    mounted() {
        this.getPartner()
    }
}
</script>

<style>

</style>
