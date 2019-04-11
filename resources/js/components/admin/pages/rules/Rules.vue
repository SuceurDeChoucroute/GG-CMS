<template>
    <div>
        <admin-content-header page_name="Posts" page_description="Manage your posts"></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                    Rules
                            </h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-info" @click="getRules()">
                                    <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <loader :color="'#337ab7'" v-show="loading"></loader>
                            <form @submit.prevent="updateRules()" class="form-horizontal" v-show="!loading">

                                <!-- Content -->
                                <div class="form-group">
                                    <label for="content" class="col-sm-2 control-label">Content</label>
                                    <div class="col-sm-8">
                                        <ckeditor :editor="editor" v-model="rules.content"></ckeditor>
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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        Loader
    },

    data() {
        return {
            loading: false,
            editor: ClassicEditor,
            rules: {},
        }
    },

    methods: {
        getRules() {
            this.loading = true

            axios.get('/api/rules')
            .then(response => {
                this.rules = response.data
                this.loading = false
            })
            .catch(e => {
                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please try again"
                })
                this.loading = false
            })
        },

        updateRules() {
            this.loading = true

            axios.put('/api/rules', this.rules)
            .then(response => {
                this.rules = response.data

                this.flashMessage.success({
                    title: "Rules updated !",
                    message: "The rules has been successfully updated"
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
        },
    },


    mounted() {
        this.getRules()
    }
}
</script>

<style>

</style>
