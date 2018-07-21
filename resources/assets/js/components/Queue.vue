<template>
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="usuario in usuarios">
                <th scope="row">{{ usuario.id }}</th>
                <td>{{ usuario.name }}</td>
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
