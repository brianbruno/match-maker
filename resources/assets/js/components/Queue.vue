<template>
    <div>
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
</template>
<script>
    export default {
        mounted() {
            Echo.join('queue.'+this.match_id)
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
        props: ['match_id'],
        data () {
            return {
                usuarios : [],
            }
        },
    }
</script>
