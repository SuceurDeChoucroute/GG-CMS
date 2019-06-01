<template>
    <div class="col-lg-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Teams Filling</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-info" @click="getPercentage()">
                        <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <apexchart height="280" type="pie" :options="options" :series="series"></apexchart>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            options: {
                chart: {
                    id: 'teamsPercentage'
                },
                labels: ['Full', 'Incomplete'],
                legend: {
                    show: true,
                    labels: {
                        useSeriesColors: true
                    }
                }
            },
            series: [0,0],
        }
    },
    
    methods: {
        getPercentage() {
            this.loading = true
            axios.get('/api/teams/percentage')
            .then(response => {
                this.series = response.data

                this.loading = false
            })
            .catch(() => {
                this.loading = false
            })
        }
    },

    mounted() {
        this.getPercentage()
    }
}
</script>
