<template>
    <admin-box-stat classes="bg-green" :loading="loading" :number="count" title="Nouveaux joueurs (mois)" icon="fas fa-user-plus" link="players"></admin-box-stat>
</template>

<script>
import AdminBoxStat from './../../layouts/AdminBoxStat'

export default {
    components: {
        AdminBoxStat
  },

  props: [
      'timer',
  ],

  data() {
      return {
            loading: false,
            count: 0,
            interval: setInterval(() => {
                    this.getCount()
            }, this.timer),
      }
  },

  methods: {
      getCount() {
            this.loading = true
            axios.get('/api/players/count/new/players/month')
            .then(response => {
                this.count = response.data
                this.loading = false
            })
      },
      
      refresh() {
          this.getCount();
      },
  },

  mounted() {
        this.getCount()
  },

  beforeDestroy() {
      clearInterval(this.interval)
  }
}
</script>

<style>

</style>
