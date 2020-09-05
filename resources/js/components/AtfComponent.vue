<template>
    <div>
        <div class="form-group">
            <label for="title">Titre<span class="text-danger">*</span></label>
            <input type="text" name="title" v-model="title" @blur="search" required="" placeholder="Titre de l'arrêt" class="form-control" id="title">
        </div>

        <div class="form-group">
            <label for="atf">Lien ATF</label>
            <div class="input-group">
                <div v-if="atf" class="input-group-prepend">
                    <span :class="'input-group-text ' + (atf ? 'bg-success text-white' : '')" id="basic-addon1"><i class="fas fa-check"></i></span>
                </div>
                <input type="text" name="meta[atf]" v-model="atf" placeholder="https://www.bger.ch..." class="form-control" id="atf">
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return{
                title:'',
                atf:'',
                url: location.protocol + "//" + location.host+"/",
            }
        },
        mounted() {},
        methods: {
            search : function(){
                let self = this;
                axios.post(this.url + "backend/arret/atf", {title : this.title}).then(function (response) {
                    self.atf = response.data.url;
                }).catch(function (error) { console.log(error);});
            }
        }
    }
</script>
