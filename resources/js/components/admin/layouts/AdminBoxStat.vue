<template>
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

            <router-link :to="link" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </router-link>
        </div>
    </div>
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
    ]
}
</script>

<style>

</style>
