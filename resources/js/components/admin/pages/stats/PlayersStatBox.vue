<template>
    <admin-box-stat classes="bg-aqua" :loading="loading" :number="count" title="Players" icon="fas fa-user-check" link="players"></admin-box-stat>
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
            axios.get('/api/players')
            .then(response => {
                this.count = response.data.length
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
