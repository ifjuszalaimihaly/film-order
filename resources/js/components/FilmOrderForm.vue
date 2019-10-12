<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Film order</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="imdb">IMDb ID</label>
                                <input type="text"
                                       class="form-control"
                                       id="imdb"
                                       aria-describedby="imdbHelp"
                                       name="imdb"
                                       v-model="imdb_id"
                                       @focus="imdbFocus"
                                       placeholder="Enter IMDb ID">
                                <small id="imdbHelp" class="form-text text-muted">
                                    Enter IMDb ID
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="originalTitle">Original title</label>
                                <input type="text"
                                       class="form-control"
                                       id="originalTitle"
                                       aria-describedby="originalTitleHelp"
                                       name="originalTitle"
                                       v-model="originalTitle"
                                       @focus="originalTitleFocus"
                                       placeholder="Enter the original title of the Film">
                                <small id="originalTitleHelp" class="form-text text-muted">
                                    Enter the original title of the Film
                                </small>
                            </div>
                            <div class="card" v-bind:class="{'d-none': !showCard}">
                                <img v-bind:src="imgScr" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{translatedTitle}}
                                        <star-rating v-bind:increment="0.1"
                                                     v-bind:max-rating="10"
                                                     v-bind:rating=this.rating
                                                     v-bind:inline=true
                                                     inactive-color="#000"
                                                     active-color="#f5c518"
                                                     v-bind:read-only=true
                                                     v-bind:star-size="15">
                                        </star-rating>
                                    </h5>
                                    <h6 class="card-title">{{year}}</h6>
                                    <p class="card-text">{{overview}}</p>
                                </div>
                            </div>
                            <button type="button" id="dataCheck" class="btn btn-success" @click="dataCheck">
                                Check Data
                            </button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import StarRating from 'vue-star-rating';
    export default {
        components: {
            StarRating
        },
        data() {
            return {
                imdb_id: null,
                originalTitle: null,
                translatedTitle: null,
                overview: null,
                imgScr: null,
                year: null,
                rating: null,
                showCard: false
            }
        },
        methods: {
            dataCheck() {
                if (this.originalTitle !== null) {
                    this.omdbRequest("title")
                }
                if (this.imdb_id !== null) {
                    this.omdbRequest("imdb_id");
                    this.theMovieDbRequest("");
                }
            },
            omdbRequest(mode) {
                let url = window.location.origin + "/omdbapi";
                console.log(mode);
                if (mode === "title") {
                    url += "?title=" + this.originalTitle;
                }
                if(mode === "imdb_id"){
                    url += "?imdb_id=" + this.imdb_id;
                }
                axios.get(url)
                    .then(response => {
                        if(mode === "title") {
                            this.imdb_id = response.data.imdb_id;
                            this.theMovieDbRequest(response.data.imdb_id);
                        }
                        if(mode === "imdb_id") {
                            this.originalTitle = response.data.title;
                        }
                        this.imgScr = response.data.img;
                        this.year = response.data.year;
                        this.rating = parseFloat(response.data.rating);
                        this.showCard = true;
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            theMovieDbRequest(imdbId) {
                if(imdbId === ""){
                    imdbId = this.imdb_id;
                }
                axios.get(window.location.origin + "/themoviedbapi?imdb_id=" + imdbId)
                    .then(resp => {
                        this.translatedTitle = resp.data.title;
                        this.overview = resp.data.overview;
                    })
                    .catch(err => {
                        console.log("err");
                    })
            },
            imdbFocus() {
                this.originalTitle = null;
            },
            originalTitleFocus() {
                this.imdb_id = null
            }

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
