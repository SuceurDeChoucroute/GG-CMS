<template>
    <div class="content-wrapper">
        <admin-content-header page_name="Dashboard" page_description="Control Panel"></admin-content-header>

        <section class="content">
            <div class="row">
                <admin-box-stat classes="bg-aqua" number="200" title="Joueurs" icon="fas fa-users" link="#"></admin-box-stat>
                <admin-box-stat classes="bg-yellow" number="25" title="Equipes" icon="fas fa-sitemap" link="#"></admin-box-stat>
                <admin-box-stat classes="bg-green" number="53" title="Places vendus" icon="fas fa-shopping-cart" link="#"></admin-box-stat>
                <admin-box-stat classes="bg-red" number="14" title="Articles" icon="fas fa-newspaper" link="#"></admin-box-stat>
            </div>
        </section>
    </div>
</template>

<script>
import AdminContentHeader from './layouts/AdminContentHeader'
import AdminBoxStat from './layouts/AdminBoxStat'

export default {
    components: {
        AdminContentHeader,
        AdminBoxStat
  }
}
</script>

<style>

</style>
