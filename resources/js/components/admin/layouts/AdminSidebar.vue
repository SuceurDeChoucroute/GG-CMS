<template>
    <aside class="main-sidebar">
        <section class="sidebar">

            <div class="user-panel">
                <div class="pull-left image">
                    <img src="https://gglan.fr/storage/avatars/pVZJ8PnP8ZkiapOtMiXtkzWrYVlxkGRuY1hQdgfQ.jpeg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p> User </p>
                </div>
            </div>

            <ul class="sidebar-menu" data-widget="tree">
                <li>
                    <router-link :to="{ name: 'index' }">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span> 
                    </router-link>
                </li>

                <li>
                    <router-link :to="{ name: 'players' }">
                        <i class="fa fa-users"></i>
                        <span>Players</span> 
                    </router-link>
                </li>

                <li>
                    <router-link :to="{ name: 'teams' }">
                        <i class="fas fa-user-friends"></i>
                        <span>Teams</span> 
                    </router-link>
                </li>
            </ul>
        </section>
    </aside>
</template>

<script>
export default {

}
</script>

<style>

</style>
