<template>
    <admin-box-stat classes="bg-red" :loading="loading" :number="count" title="Articles" icon="fas fa-newspaper" link="posts"></admin-box-stat>
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
            axios.get('/api/posts')
            .then(response => {
                this.count = response.data.length
                this.loading = false
            })
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
