<template>
    <div>
        <!-- <admin-content-header page_name="Add player" ></admin-content-header> -->
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <button @click="goToTournamentList()" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i>
                Return to tournament list
            </button>

            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create tournament</h3>
                        </div>
                        <div class="box-body">
                            <form @submit.prevent="createTournament()" class="form-horizontal">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" placeholder="Name" v-model="tournament.name" required>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Description</label>

                                    <div class="col-sm-10">
                                        <textarea id="description" cols="30" rows="5" class="form-control" style="resize: none;" v-model="tournament.description" required></textarea>
                                    </div>
                                </div>

                                <!-- Game -->
                                <div class="form-group">
                                    <label for="game" class="col-sm-2 control-label">Game</label>

                                    <div class="col-sm-10">
                                        <loader :color="'#337ab7'" v-show="loading"></loader>
                                        <select name="game" id="game" class="form-control" v-show="!loading" required>
                                            <option disabled selected>-- Please choose the game --</option>
                                            <option :value="game.id" v-for="(game, key) in games" :key="key"> {{ game.name }} </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Start & End Date -->
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Start & End Date</label>

                                    <div class="col-sm-5">
                                        <input type="date" class="form-control" id="startDate" v-model="tournament.startDate" required>
                                    </div>
                                    
                                    <div class="col-sm-5">
                                        <input type="date" class="form-control" id="endDate" v-model="tournament.endDate" required>
                                    </div>
                                </div>

                                <!-- Place -->
                                <div class="form-group">
                                    <label for="place" class="col-sm-2 control-label">Place</label>

                                    <div class="col-sm-10">
                                        <input type="number" min="0" step="1" class="form-control" id="place" placeholder="Place" v-model="tournament.place" required>
                                    </div>
                                </div>

                                <!-- Cashprize -->
                                <div class="form-group">
                                    <label for="cashprize" class="col-sm-2 control-label">Cashprize</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="cashprize" placeholder="Cashprize" v-model="tournament.cashprize" required>
                                    </div>
                                </div>

                                <!-- Image -->
                                <div class="form-group">
                                    <label for="image" class="col-sm-2 control-label">Image</label>

                                    <div class="col-sm-10">
                                        <input type="url" class="form-control" id="image" placeholder="https://..." v-model="tournament.image" required>
                                    </div>
                                </div>
                                
                                <!-- Create -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-sync fa-spin" v-show="loading"></i>
                                            <i class="fas fa-check" v-show="!loading"></i>
                                            Create
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        Loader
    },

    data() {
        return {
            loading: false,
            tournament: {
                id: 99,
                name: '',
                description: "",
                game: '',
                startDate: '',
                endDate: '',
                place: '',
                cashprize: '',
                status: '',
                image: '',
            },
            games: [
                { id: 1, name: "CS:GO", description: "An amazing FPS shooter", place: 5 },
                { id: 2, name: "ForHonor", description: "Now you are an ultimate warrior", place: 4 },
            ],
        }
    },

    methods: {
        goToTournamentList() {
            this.$router.push({name: 'tournaments'});
        },

        createTournament() {
            this.$router.push({ name: 'tournament.show', params: {id: this.tournament.id} })
            this.flashMessage.success({
                title: "Tournament added !",
                message: "The tournament has been successfully added"
            })
        },
    },
}
</script>

<style>

</style>
