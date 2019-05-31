<template>
    <div class="col-lg-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Players / Games</h3>
            </div>

            <div class="box-body">
                <apexchart height="280" type="donut" :options="options" :series="series"></apexchart>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            options: {
                chart: {
                    id: 'playersPerGames'
                },
                labels: []
            },
            series: [0,0],
        }
    },
    
    methods: {
        getPercentage() {
            axios.get('/api/games/players/percentage')
            .then(response => {
                this.options = {
                    ...this.options.chart,
                    labels: response.data.labels
                }
                this.series = response.data.values
            })
        }
    },

    mounted() {
        this.getPercentage()
    }
}
</script>
