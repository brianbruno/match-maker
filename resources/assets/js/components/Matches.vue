<template>
    <div class="container">
        <div class="card-deck">
            <div class="row">
                <div class="col-sm-6" v-for="match in matches">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div v-if="match.images.length >= 4" class="d-flex flex-row justify-content-center card-img-top">
                                        <div class="d-flex flex-column">
                                            <img :src="match.images[0]" class="img-fluid">
                                            <img :src="match.images[1]" class="img-fluid">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <img :src="match.images[2]" class="img-fluid">
                                            <img :src="match.images[3]" class="img-fluid">
                                        </div>
                                    </div>
                                    <div v-if="match.images.length < 4" class="justify-content-center">
                                        <img style="max-width: 100%; max-height: 100%" class="card-img-top" :src="match.images[0]" alt="Card image cap">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="justify-content-center">
                                        <h5 class="card-title">{{ match.name }} Match <span  v-bind:class="{ 'badge-success': match.users < 5, 'badge-warning': match.users >= 5 }" class="badge badge-pill text-right">{{ match.users }}</span></h5>
                                    </div>
                                    <div class="justify-content-left">
                                        <p class="card-text">{{ match.desc }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a :href="match.link" ><button type="button" class="btn btn-outline-success btn-lg btn-block btn-sm">Join</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="status === 50" class="col-sm-12 d-flex justify-content-center">
            <h1>Loading...</h1>
        </div>
        <div v-if="status === 100" class="col-sm-12 d-flex justify-content-center">
            <h1>Looks like there's no match...</h1>
        </div>
        <div v-if="status === 0" class="col-sm-12 d-flex justify-content-center">
            <h1>Oops! ... I Dit It Again</h1>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.retrieveChannels();
        },
        data () {
            return {
                matches : [],
                status: 50
            }
        },
        methods: {
            click: function () {
                console.log("Nova partida");
            },
            retrieveChannels: function () {
                self = this;
                self.matches = [];
                axios.get('/getchannels')
                    .then(function (response) {
                        self.status = response.data.status;
                        if (response.data.status === 200) {
                            response.data.canais.forEach(function(item) {
                                self.matches.push(item);
                            });
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    }).finally(function () {
                        // console.log(self.matches);
                    });
            }
        }
    }
</script>
