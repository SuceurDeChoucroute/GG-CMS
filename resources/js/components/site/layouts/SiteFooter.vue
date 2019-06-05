<template>
    <footer class="footer bg-dark mt-4 pl-4 pr-4"> 
        <div class="container-fluid text-center">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="text-center text-white">Our partners</h4>
                </div>

                <!-- <div class="col-lg-2 text-white" v-for="(partner, key) in partners" :key="key">
                    {{ partner.name }}
                </div> -->
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    data() {
        return {
            partners: [],
        }
    },

    methods: {
        getPartners() {
            this.partners = [
                {name: 'Brest Open Campus', url: '#', image:'#'},
                {name: 'Press2Play', url: '#', image:'#'},
                {name: "Epsup'lan", url: '#', image:'#'},
            ]
        }
    },

    mounted() {
        this.getPartners()
    }
}
</script>

<style scoped>
    html {
    position: relative;
    min-height: 100%;
    }
    body {
    /* Margin bottom by footer height */
    margin-bottom: 60px;
    }
    .footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 60px;
    line-height: 60px;
}
</style>
