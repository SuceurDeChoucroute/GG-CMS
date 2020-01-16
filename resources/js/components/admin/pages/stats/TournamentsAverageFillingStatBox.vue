<template>
    <admin-box-stat classes="bg-green" :loading="loading" :number="count" title="Tournaments Filling" icon="fas fa-info" link="tournaments"></admin-box-stat>
</template>

<script>
import AdminBoxStat from './../../layouts/AdminBoxStat'

export default {
    components: {
        AdminBoxStat
  },

  data() {
      return {
            loading: false,
            count: 0,
      }
  },

  methods: {
      getPercentage() {
            this.loading = true
            axios.get('/api/tournaments/players/average')
            .then(response => {
                this.count = Math.round(response.data) + ' %'
                this.loading = false
            })
      },
      
      refresh() {
          this.getPercentage();
      },
  },

  mounted() {
        this.getPercentage()
  },
}
</script>

<style>

</style>
