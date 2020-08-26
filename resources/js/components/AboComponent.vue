<template>
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center" style="height: 30px;">
                <p class="d-block">{{ categorie.name }}</p>
                <button class="btn btn-sm btn-droitpraticen d-block" @click="add"><i class="fas fa-plus-circle"></i></button>
            </div>

            <div v-if="words" v-for="(keyword,index) in words" class="d-flex flex-row justify-content-between">
                <input class="form-control" name="keyword[]" type="text" v-model="keyword.text">
                <button class="btn btn-sm btn-danger" @click="remove(index)">x</button>
            </div>

            <div class="toggle-group">
                <input type="checkbox" name="on-off-switch" :id="'on-off-switch_' + categorie.id" v-model="aPublier" tabindex="1">
                <label :for="'on-off-switch_' + categorie.id">Limiter aux arrêts proposé pour la publication </label>
                <div class="onoffswitch pull-right" aria-hidden="true">
                    <div class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    // [['categorie_id' => 244, 'keywords' => [["ATF 138 III 382"]],'toPublish' => 1]]
    export default {
        props: ['categorie','abo','user_id'],
        data(){
            return{
                updated: false,
                categorie_id: this.categorie.id,
                aPublier : this.abo ? this.abo.toPublish : null,
                words : this.abo ? this.abo.keywords : [{text: ''}]
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            add() {
                this.words.push({text: ''})
            },
            remove(index) {
                this.words.splice(index,1)
            },
            update : function(){
                var self = this;
                axios.post("cadence",{ user_id: this.user_id, cadence: this.rhythm }).then(function (response) {
                    self.updated = true;
                    setTimeout(() => {
                        self.updated = false;
                    }, 1500);

                }).catch(function (error) { console.log(error);});
            }
        }
    }
</script>
<style scoped>
    .btn-droitpraticen{
        background-color: #0f4060;
        color: #fff;
    }
    .onoffswitch {
        position: relative;
        width: 55px;
        display: inline-block;
        font-size: 80%;
    }
    .onoffswitch .onoffswitch-label {
        display: block;
        overflow: hidden;
        cursor: pointer;
        border: 1px solid hsl(0, 0%, 90%);
        -moz-border-radius: 20px;
        -webkit-border-radius: 20px;
        border-radius: 20px;
        margin: 0;
    }
    .onoffswitch .onoffswitch-inner {
        width: 200%;
        margin-left: -100%;
        -webkit-transition: margin 0.15s ease-in-out;
        -o-transition: margin 0.15s ease-in-out;
        -moz-transition: margin 0.15s ease-in-out;
        transition: margin 0.15s ease-in-out;
    }
    .onoffswitch .onoffswitch-inner:before,
    .onoffswitch .onoffswitch-inner:after {
        float: left;
        width: 50%;
        height: 24px;
        padding: 0;
        line-height: 24px;
        font-size: 80%;
        color: hsl(0, 0%, 100%);
        font-weight: normal;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }
    .onoffswitch .onoffswitch-inner:before {
        content: "Oui";
        padding-left: 10px;
        background-color: #0f4060;
        color: hsl(0, 0%, 100%);
    }
    .onoffswitch .onoffswitch-inner:after {
        content: "Non";
        padding-right: 10px;
        background-color: hsl(0, 0%, 98%);
        color: hsl(0, 0%, 24%);
        text-align: right;
    }
    .onoffswitch .onoffswitch-switch {
        width: 22px;
        height: 22px;
        margin: 0;
        background: hsl(0, 0%, 100%);
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
        position: absolute;
        top: 2px;
        bottom: 0;
        right: 35px;
        -webkit-transition: right 0.15s ease-in-out;
        -o-transition: right 0.15s ease-in-out;
        -moz-transition: right 0.15s ease-in-out;
        transition: right 0.15s ease-in-out;
    }
    .toggle-group {
        position: relative;
        height: 27px;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
    .toggle-group input[type=checkbox] {
        position: absolute;
        left: 10px;
    }
    .toggle-group input[type=checkbox]:checked ~ .onoffswitch .onoffswitch-label .onoffswitch-inner {
        margin-left: 0;
    }
    .toggle-group input[type=checkbox]:checked ~ .onoffswitch .onoffswitch-label .onoffswitch-switch {
        right: 1px;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
    }
    .toggle-group input[type=checkbox]:focus ~ .onoffswitch {
        outline: thin dotted #333;
        outline: 0;
    }
    .toggle-group label {
        position: absolute;
        cursor: pointer;
        padding-left: 65px;
        display: inline-block;
        text-align: left;
        line-height: 24px;
        width: 100%;
        z-index: 1;
        height: 24px;
        font-weight: 200;
    }
    /* ==== Accessibility ===== */
    .aural {
        clip: rect(1px, 1px, 1px, 1px);
        height: 1px;
        overflow: hidden;
        position: absolute;
        width: 1px;
    }
    .aural:focus {
        clip: rect(0, 0, 0, 0);
        font-size: 1em;
        height: auto;
        outline: thin dotted;
        position: static !important;
        width: auto;
        overflow: visible;
    }

</style>
