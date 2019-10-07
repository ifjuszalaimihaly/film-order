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
                                       v-model="imdb"
                                       :disabled="imdbDisabled"
                                       v-on:focus="onFocus($event)"
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
                                       :disabled="originalTitleDisabled"
                                       v-on:focus="onFocus($event)"
                                       placeholder="Enter the original title of the Film">
                                <small id="originalTitleHelp" class="form-text text-muted">
                                    Enter the original title of the Film
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="translatedTitle">Translated title</label>
                                <input type="text"
                                       class="form-control"
                                       id="translatedTitle"
                                       aria-describedby="translatedTitleHelp"
                                       name="translatedTitle"
                                       v-model="translatedTitle" disabled>
                            </div>
                            <button type="button" id="dataCheck" class="btn btn-success" @click="dataCheck">
                                Check Data
                            </button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-primary" @click="reset">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            console.log("data");
            return {
                imdb: null,
                originalTitle: null,
                translatedTitle: null,
                imdbDisabled: false,
                originalTitleDisabled: false,
            }
        },
        methods: {
            dataCheck() {
                if(this.originalTitle != null && this.originalTitle.length !== 0) {
                    this.$http.get(`http://www.omdbapi.com/?t=${this.originalTitle}&apikey=1e5f14ff`)
                        .then(response => {
                            console.log(response);
                        }, response => {
                            console.log(response.status);
                        })
                }
            },
            reset() {
                this.imdbDisabled=false;
                this.originalTitleDisabled=false;
            },
            onFocus: function(event) {
                console.log(event.target.id);
            }
        },
        mounted() {
            console.log('Component mounted.');
            this.imdbDisabled = false;
            this.originalTitleDisabled = false;
        }
    }
</script>
