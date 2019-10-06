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
                                       placeholder="Enter the original title of the Film">
                                <small id="originalTitleHelp" class="form-text text-muted">
                                    Enter the original title of the Film
                                </small>
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
    export default {
        data() {
            return {
                imdb: null,
                originalTitle: null
            }
        },
        methods: {
            dataCheck(){
              console.log(this.imdb+ " " + this.originalTitle);
              axios.get("http://www.omdbapi.com/?t=Interstellar&apikey=1e5f14ff")
                  .then(reponse => {
                      console.log(reponse);
                  })
                  .catch(error => {
                      console.log(error);
                  })
          }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
