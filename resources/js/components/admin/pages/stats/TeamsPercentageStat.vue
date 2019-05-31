<template>
    <div class="col-lg-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Teams Filling</h3>
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
                    id: 'teamsPercentage'
                },
                labels: ['Full', 'Incomplete']
            },
            series: [0,0],
        }
    },
    
    methods: {
        getPercentage() {
            axios.get('/api/teams/percentage')
            .then(response => {
                this.series = response.data
            })
        }
    },

    mounted() {
        this.getPercentage()
    }
}
</script>
