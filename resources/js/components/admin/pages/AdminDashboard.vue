<template>
    <div>
        <admin-content-header page_name="Dashboard" page_description="Control Panel"></admin-content-header>

        <section class="content">
            <div class="row">
                <admin-box-stat classes="bg-aqua" :number="playersCount" title="Joueurs" icon="fas fa-user-check" link="#"></admin-box-stat>
                <admin-box-stat classes="bg-yellow" number="25" title="Equipes" icon="fas fa-users" link="#"></admin-box-stat>
                <admin-box-stat classes="bg-green" number="53" title="Places vendu" icon="fas fa-shopping-cart" link="#"></admin-box-stat>
                <admin-box-stat classes="bg-red" number="14" title="Articles" icon="fas fa-newspaper" link="#"></admin-box-stat>
            </div>
        </section>
    </div>
</template>

<script>
import AdminContentHeader from './../layouts/AdminContentHeader'
import AdminBoxStat from './../layouts/AdminBoxStat'

export default {
    components: {
        AdminContentHeader,
        AdminBoxStat
  },

  data() {
      return {
          playersCount: 0,
      }
  },

  methods: {
      getPlayersCount() {
            this.loading = true
            axios.get('/api/players')
            .then(response => {
                this.playersCount = response.data.length
                this.loading = false
            })
      },
  },

  mounted() {
      this.getPlayersCount()
  }
}
</script>

<style>

</style>
