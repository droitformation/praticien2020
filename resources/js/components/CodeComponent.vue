<template>
    <div>
        <input type="text" v-model="code" name="code" class="form-control" placeholder="Unique code numérique, prefixe année en cours + 8 chiffres => ex: 2012345678">
    </div>
</template>
<script>

    export default {
        data(){
            return{
                url: location.protocol + "//" + location.host+"/",
                code: null
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
