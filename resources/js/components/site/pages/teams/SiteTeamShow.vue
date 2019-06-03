<template>
    <div>
        <div class="row" v-show="loading">
            <div class="col-lg-12 text-center" >
                <b-spinner style="width: 3rem; height: 3rem;" variant="dark" label="Loading"></b-spinner>
            </div>
        </div>

        <div class="row" v-show="!loading" v-if="team.team">
            <div class="col-lg-5">
                <div class="card card-small mb-4">
                    <div class="card-header border-bottom text-center">
                        <div class="mb-3 mx-auto">
                            <img class="rounded-circle" :src="team.team.avatar" alt="User Avatar" width="110">
                        </div>
                        <h4 class="mb-0">{{ team.team.name }}</h4>
                        <span class="text-muted d-block mb-2"> {{ team.team.description }} </span>
                        <button type="button" class="btn btn-success">
                            <i class="fas fa-plus"></i> Join
                        </button>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-4">
                            <strong class="text-muted d-block mb-2">Our participation(s):</strong>
                            <ul>
                                <li v-for="(participation, key) in team.participations" :key="key"> {{ participation.name }} </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card card-small mb-4">
                    <div class="card-header border-bottom">
                        <h6 class="m-0">Team players</h6>
                    </div>
                    <div class="card-body p-0 text-center">
                        <table class="table mb-0 table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">Player</th>
                                    <!-- <th scope="col" class="border-0">Grade</th>
                                    <th scope="col" class="border-0"></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(player, key) in team.players" :key="key">
                                    <td>
                                        <i class="fas fa-star text-warning" v-if="player.pivot.captain"></i> 
                                        {{ player.pseudo }} 
                                    </td>
                                    <!-- <td></td> -->
                                    <!-- <td></td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            team: {},
        }
    },

    methods: {
        getTeam() {
            this.loading = true
            axios.get('/api/teams/' + this.$route.params.id)
            .then(response => {
                this.team = response.data
                this.loading = false
            })
            .then(() => {

                this.loading = false
            })
        },
    },

    mounted() {
        this.getTeam()
    }
}
</script>

<style>

</style>
