<template>
    <div>
        <div class="form-group">
            <label for="nbr">Nombre de codes</label>
            <input id="nbr" name="nbr" v-model="nbr" class="form-control" type="number">
        </div>
        <div class="form-group" v-if="nbr > 1">
            <label>Des codes uniques seront crées automatiquement par le système</label>
        </div>
        <div class="form-group" v-if="nbr == 1">
            <label for="code">Code</label>
            <input id="code" type="text" v-model="code" name="code" class="form-control" placeholder="Unique code numérique, prefixe année en cours + 8 chiffres => ex: 2012345678">
        </div>
    </div>
</template>
<script>

    export default {
        data(){
            return{
                url: location.protocol + "//" + location.host+"/",
                code: null,
                nbr:1
            }
        },
        mounted() {
            this.create();
        },
        methods: {
            create: function () {
                let self = this;
                axios.post(this.url + "backend/newcode",{}).then(function (response) {
                    self.code = response.data.code;
                }).catch(function (error) { console.log(error);});
            },
        },
    }
</script>
