<template>
    <button type="button" v-bind:onclick="novaPartida" class="btn btn-secondary btn-lg">Criar nova partida</button>
</template>
<script>
    export default {
        mounted() {
            console.log("mounted");
        },
        methods: {
            novaPartida: function () {
                console.log("Nova partida");
            }
        }
    }
</script>
