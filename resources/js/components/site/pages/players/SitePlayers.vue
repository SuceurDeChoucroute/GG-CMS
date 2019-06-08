<template>
    <div>
        <div class="row" v-show="loading">
            <div class="col-lg-12 text-center" >
                <b-spinner style="width: 3rem; height: 3rem;" variant="dark" label="Loading"></b-spinner>
            </div>
        </div>

        <div class="row" v-show="!loading">
            <div class="col-lg-4 mb-4">
                <form>
                    <div class="form-inline">
                        <input type="text" class="form-control col-sm-12 mb-2" placeholder="Search a player..." autofocus v-model="search">

                        <!-- <label for="showPlayers">Show </label>
                        <select name="showPlayers" id="showPlayers" class="form-control" v-model="countShowPlayers">
                            <option :value="number" v-for="(number, key) in howMuchPlayersCanShow" :key="key"> {{ number }} </option>
                        </select>
                        <label for="showPlayers"> Players</label> -->
                    </div>
                    <label v-show="search"> {{ filteredPlayers.length }} player(s) filtered</label>
                </form>
            </div>
        </div>

        <div class="row" v-show="!loading">
            <div class="col-lg-3 col-md-4 col-sm-4 col-6 mb-4" v-for="(player, key) in filteredPlayers" :key="key" v-show="(key + 1) <= countShowPlayers">
                <div class="card">
                    <router-link :to="{name: 'player.show', params: {id: player.id}}">
                        <img class="card-img-top" :src="player.avatar" alt="Player avatar">
                    </router-link>
                    <div class="card-body">
                        <h4 class="card-title"> 
                            {{ player.pseudo }}
                        </h4>
                    </div>
                </div>
            </div> 
        </div>
        
        <div class="row" v-show="!loading && isMoreShowable">
            <div class="col-lg-6 mb-4 mx-auto text-center">
                <button class="btn btn-lg btn-primary" @click="showMore()">
                    Show more ...
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            countShowPlayers: 8,
            search: "",
            players: [],
        }
    },

    methods: {
        getPlayers() {
            this.loading = true
            axios.get('/api/players')
            .then(response => {
                this.players = response.data
                this.loading = false
            })
            .then(() => {

                this.loading = false
            })
        },

        showMore() {
            this.countShowPlayers += 8
        },
    },

    mounted() {
        this.getPlayers()
    },

    computed: {
        isMoreShowable() {
            if (this.countShowPlayers < this.filteredPlayers.length) {
                return true
            }
            return false
        },

        howMuchPlayersCanShow() {
            let count = this.players.length
            let numbers = []

            for (let index = 8; index < count; index += 8) {
                numbers.push(index)
            }
            numbers.push(count)

            return numbers;
        },

        filteredPlayers() {
            if (this.players && this.search != "") {
               return this.players.filter((player) => {
                    return player.pseudo.toLowerCase().trim().replace(/\s+/g, '').match(this.search.trim().replace(/\s+/g, ''))
                })
            }
            return this.players
        }
    }
}
</script>

<style>

</style>
