<template>
    <div class="card-body">
        <h1 class="text-center">
            {{ usuarios.length }}
        </h1>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Rank</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="usuario in usuarios">
                <td>{{ usuario.name }}</td>
                <td>{{ usuario.rank }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        mounted() {
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
        data () {
            return {
                usuarios : [],
            }
        },
    }
</script>
