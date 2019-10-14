<template>
    <div>
        <admin-content-header page_name="Partners" page_description="Manage your partners"></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Partners
                            </h3>
                            <div class="box-tools pull-right">
                                <router-link :to="{ name: 'partner.create'}" class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                    Add
                                </router-link>
                                <button class="btn btn-info" @click="getPartners()">
                                    <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <AdminDataTable :data="partners" :columns="columns"  :actions="actions" :index="false" :loading="loading"></AdminDataTable>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import AdminContentHeader from './../../layouts/AdminContentHeader'
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        AdminContentHeader,
        Loader
    },

    data() {
        return {
            loading: false,
            columns: [
                {name: 'name', th: 'Name'},
                {name: 'site', th: 'Site'},
            ],
            actions: [
                {text: "", icon: "fas fa-edit", color: "success", action: (row, index) => {
                    this.$router.push({ name: 'partner.edit', params: {id: row.id} })
                }},
                {text: "", icon: "fas fa-trash", color: "danger", action: (row, index) => {
                    this.deletePartner(row.id)
                }},
            ],
            partners: [],
        }
    },

    methods: {
        getPartners() {
            this.loading = true
            axios.get('/api/partners')
            .then(response => {
                this.partners = response.data
                this.loading = false
            })
        },

        deletePartner(id) {
            if (confirm("Are you sure you want to delete this partner ? It's definitive")) {
                this.loading = true
    
                axios.delete('/api/partners/' + id)
                .then(response => {
                    this.getPartners()
                    this.flashMessage.success({
                        title: "Partner deleted !",
                        message: "The partner has been successfully deleted"
                    })
                    this.loading = false
                })
                .catch(e => {
                    this.flashMessage.error({
                        title: "Something went wrong",
                        message: "Please try again"
                    })
                    this.loading = false
                })
            }
        },
    },

    mounted() {
        this.getPartners();
    }
}
</script>

<style>

</style>
