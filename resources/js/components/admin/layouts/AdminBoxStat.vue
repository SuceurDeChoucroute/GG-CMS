<template>
    <router-link :to="link">
        <div class="col-lg-3 col-xs-6">
                <div class="small-box" :class="classes">
                    <div class="inner">
                        <loader :color="'#337ab7'" v-show="loading"></loader>
                        <h3 v-show="!loading"> {{ number }} </h3>

                        <p> {{ title }} </p>
                    </div>

                    <div class="icon">
                        <i :class="icon"></i>
                    </div>

                    <span class="small-box-footer" @click.prevent="refresh()">
                        <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i> Rafraîchir
                    </span>
                </div>
        </div>
    </router-link>
</template>

<script>
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        Loader
    },

    props: [
        'loading',
        'classes',
        'number',
        'title',
        'icon',
        'link'
    ],

    methods: {
        refresh() {
            this.$parent.refresh();
        }
    },
}
</script>

<style>

</style>
