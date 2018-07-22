<template>
    <div class="container">
        <div class="card-deck">
            <div class="card" v-for="match in matches">
                <div v-if="match.imgPreview === 'multiple'" class="d-flex flex-row justify-content-center card-img-top">
                    <div class="d-flex flex-column">
                        <img :src="match.images[0]" class="img-fluid">
                        <img :src="match.images[1]" class="img-fluid">
                    </div>
                    <div class="d-flex flex-column">
                        <img :src="match.images[2]" class="img-fluid">
                        <img :src="match.images[3]" class="img-fluid">
                    </div>
                </div>
                <div v-if="match.imgPreview === 'single'" class="justify-content-center">
                    <img style="max-width: 65%; max-height: 65%" class="card-img-top" :src="match.images[0]" alt="Card image cap">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ match.name }} Match <span  v-bind:class="{ 'badge-success': match.users < 5, 'badge-warning': match.users >= 5 }" class="badge badge-pill text-right">{{ match.users }}</span></h5>
                    <p class="card-text">{{ match.desc }}</p>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-success btn-lg btn-block btn-sm">Join</button>
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data () {
            return {
                matches : [
                    {
                        name: 'Brucer',
                        imgPreview: 'multiple',
                        users: 5,
                        desc: 'Partida de treinamento da equipe Team One.',
                        images: [
                            'http://ddragon.leagueoflegends.com/cdn/8.14.1/img/profileicon/1.png',
                            'http://ddragon.leagueoflegends.com/cdn/8.14.1/img/profileicon/2074.png',
                            'http://ddragon.leagueoflegends.com/cdn/8.14.1/img/profileicon/2077.png',
                            'http://ddragon.leagueoflegends.com/cdn/8.14.1/img/profileicon/2076.png',
                        ]
                    },
                    {
                        name: 'Jovirone',
                        imgPreview: 'single',
                        users: 3,
                        desc: 'Fila para jogar com o streamer Jovirone na live do dia 25/07/2018.',
                        images: [
                            'http://ddragon.leagueoflegends.com/cdn/8.14.1/img/profileicon/1633.png',
                        ]
                    },
                    {
                        name: 'Jovirone',
                        imgPreview: 'single',
                        users: 3,
                        desc: 'Fila para jogar com o streamer Jovirone na live do dia 25/07/2018.',
                        images: [
                            'http://ddragon.leagueoflegends.com/cdn/8.14.1/img/profileicon/1633.png',
                        ]
                    },
                    {
                        name: 'Jovirone',
                        imgPreview: 'single',
                        users: 3,
                        desc: 'Fila para jogar com o streamer Jovirone na live do dia 25/07/2018.',
                        images: [
                            'http://ddragon.leagueoflegends.com/cdn/8.14.1/img/profileicon/1633.png',
                        ]
                    },
                    {
                        name: 'Jovirone',
                        imgPreview: 'single',
                        users: 3,
                        desc: 'Fila para jogar com o streamer Jovirone na live do dia 25/07/2018.',
                        images: [
                            'http://ddragon.leagueoflegends.com/cdn/8.14.1/img/profileicon/1633.png',
                        ]
                    },
                ],
            }
        },
        methods: {
            click: function () {
                console.log("Nova partida");
            },
        }
    }
</script>
