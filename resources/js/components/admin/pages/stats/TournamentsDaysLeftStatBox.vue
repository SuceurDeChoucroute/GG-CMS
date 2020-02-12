<template>
    <admin-box-stat classes="bg-red" :loading="loading" :number="count" title="Days left since tournament" icon="fas fa-trophy" link="tournaments"></admin-box-stat>
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
            axios.get('/api/tournaments/daysleft')
            .then(response => {
                this.count = response.data.values[0];
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
