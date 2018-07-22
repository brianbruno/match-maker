<template>
    <div>
        <div>
            <button v-on:click="novaPartida" class="btn btn-secondary btn-lg">Create match</button>
        </div>
        <hr>
        <div v-show="newMatch">
            <div class="row">
                <div class="col-md-10">
                    <h1>Brian Bruno Match</h1>
                </div>
                <div class="col-md-2">
                    <h1><span class="badge badge-pill badge-info text-right text-light">{{ usuarios.length }}</span></h1>
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="co1"></th>
                    <th scope="co2">Name</th>
                    <th scope="co3">Rank</th>
                    <th scope="co3">Win/Losses</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="usuario in usuarios">
                    <td class="align-middle"><img :src="usuario.icone" style="width: auto; height: 25px;"class="rounded img-fluid" :alt="usuario.name"></td>
                    <td class="align-middle"><h4>{{ usuario.name }}</h4></td>
                    <td class="align-middle"><h4>{{ usuario.rank }}</h4></td>
                    <td class="align-middle"><span class="text-success font-weight-bold">{{ usuario.wins }}W</span> / <span class="text-danger font-weight-bold">{{ usuario.losses }}L</span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                newMatch : false,
                joinMatch : false,
                usuarios : [],
            }
        },
        methods: {
            entrarPartida: function () {
                if (this.newMatch)
                    Echo.leave('queue.1');
                this.newMatch = false;
                this.joinMatch = true;
                this.usuarios = [];

                Echo.channel('matchs')
                    .listen('MatchCreated', (e) => {
                        console.log("Nova Partida");
                    });
            },
            novaPartida: function () {
                if (this.joinMatch)
                    Echo.leave('matchs');

                this.joinMatch = false;
                this.newMatch = true;

                Echo.join('matchs')
                    .here((users) => {
                        //
                    })
                    .joining((user) => {
                        //
                    })
                    .leaving((user) => {
                        //
                    });

                Echo.join('queue.1')
                    .here((users) => {
                        console.log(users);
                        this.usuarios = users;
                    })
                    .joining((user) => {
                        this.usuarios.push(user);
                    })
                    .leaving((user) => {
                        this.usuarios = _.reject(this.usuarios, usuario => usuario.id === user.id);
                    });
            },
        }
    }
</script>
