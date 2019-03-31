<template>
    <div>
        <admin-content-header page_name="Players" page_description="Manage your players"></admin-content-header>
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <player-list :players="players"></player-list>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import AdminContentHeader from './../layouts/AdminContentHeader'

export default {
    components: {
        AdminContentHeader,
  },
  data() {
      return {
          players: [
              {id: 1, name: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
              {id: 2, name: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
              {id: 6, name: 'Gotaga'  , email: 'gotaga@example.com', description: "The french monster !"},
              {id: 3, name: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
              {id: 4, name: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
              {id: 5, name: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
          ],
      }
  },
}
</script>

<style>

</style>
