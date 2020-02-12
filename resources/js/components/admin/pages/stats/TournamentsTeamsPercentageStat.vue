<template>
    <div class="col-lg-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Remplissage tournoi(s)</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-info" @click="getPercentage(1)">
                        <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <apexchart height="280" type="radialBar" :options="options" :series="series"></apexchart>
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
                    id: 'tournamentsTeamsPercentage'
                },
                labels: [],
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: function (w) {
                                    return Math.floor(w.globals.seriesTotals.reduce((a, b) => {
                                        return a + b
                                    }, 0) / w.globals.series.length) + '%'
                                }
                            }
                        }
                    }
                },
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
        getPercentage(isRefresh) {
            this.loading = true
            axios.get('/api/tournaments/teams/percentage')
            .then(response => {
                this.options = {
                    ...this.options.chart,
                    labels: response.data.labels
                }
                this.series = response.data.values

                if (isRefresh) {
                    this.flashMessage.success({
                        title: "Data updated",
                    })
                }

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
