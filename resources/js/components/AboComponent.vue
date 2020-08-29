<template>
    <div :class="'card mb-3 ' + (active ? 'abo-card-active' : '')">
        <div class="card-body">

            <div class="categorie-header">
                <p class="categorie-title">{{ categorie.name }}</p>
                <div class="title-btn">
                    <button class="btn btn-sm btn-open" @click='toggle()'><i :class="'fas ' + (active ? 'fa-edit' : 'fa-plus')"></i></button>
                    <button v-if="active" class="btn btn-sm btn-delete" @click='destroy()'><i class="fas fa-times"></i></button>
                </div>
            </div>

            <div v-show="isOpen" class="wrapper">
                <div v-if="words.length" class="keywords_wrapper">
                    <div v-for="(keyword,index) in words" class="d-flex flex-row justify-content-between my-3">
                        <input class="form-control form-control-keyword" name="keyword[]" type="text" v-model="keyword.text">
                        <button class="btn btn-sm btn-danger btn-remove" @click="remove(index)">x</button>
                    </div>
                </div>

                <p class="text-right">
                    <button class="btn btn-sm btn-droitpraticen" @click="add" data-toggle="tooltip" data-placement="top" title="Limiter par mots-clés">
                        <i class="fas fa-plus"></i> &nbsp;Mots-cles</button>
                </p>

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

                <button :class="'btn btn-sm d-block ' + (active ? 'btn-save-active' : 'btn-save') " type="button" @click="save">
                    Enregistrer <span><transition name="fade"><i v-show="updated" class="fas fa-check"></i></transition></span>
                </button>
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
                isOpen: false,
                updated: false,
                categorie_id: this.categorie.id,
                aPublier : this.abo ? this.abo.toPublish : null,
                words : this.abo ? this.abo.keywords : [],
                active: this.abo ?? null
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            toggle: function(){
                this.isOpen = !this.isOpen
            },
            add() {
                this.words.push({text: ''})
            },
            remove(index) {
                this.words.splice(index,1)
            },
            destroy(){
                var self = this;
                axios.post("unsubscribe",{
                    user_id: this.user_id,
                    categorie_id: this.categorie_id,
                }).then(function (response) {

                    console.log(response);
                    self.updated = true;
                    setTimeout(() => {
                        self.updated = false;
                        self.isOpen = false;
                        self.active = null;
                    }, 1500);

                }).catch(function (error) { console.log(error);});
            },
            save() {
                var self = this;
                axios.post("subscribe",{
                    user_id: this.user_id,
                    categorie_id: this.categorie_id,
                    keywords: this.words ,
                    toPublish: this.aPublier
                }).then(function (response) {

                    console.log(response);
                    self.updated = true;
                    setTimeout(() => {
                        self.updated = false;
                        self.isOpen = false;
                        self.active = response.data.abo;
                    }, 1500);

                }).catch(function (error) { console.log(error);});
            },
        }
    }
</script>
<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0
    }

    .title-btn{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .abo-card-active .card-body{
        background-color: #0f4060;
        color: #fff;
    }

    .abo-card-active .categorie-header .btn-open{
        background-color: #fff;
        color: #938164;
    }

    .abo-card-active .categorie-header .btn-open:hover{
        background-color: #fff;
        color: #000;
    }

    .wrapper{
        margin-top: 20px;
    }
    .keywords_wrapper{
        margin: 30px 0 0px 0;
    }
    .categorie-header{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .categorie-title{
        display: block;
        line-height: 20px;
        font-size: 18px;
        padding-right: 10px;
        margin-bottom: 0;
    }

    .btn-delete,
    .btn-open{
        font-size: 11px;
        width: 75px;
        padding: 1px;
        text-transform: uppercase;
        height: 26px;
        border: none;
        display: block;
    }

    .btn-open{
        background-color: #0f4060;
        color: #fff;
        margin-right: -2px;
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
    }

    .btn-open:hover{
        background-color: #0c3956;
    }

    .btn-danger{
        background-color: #a12f10;
        border-color:#a12f10;
    }

    .btn-delete{
        width: 45px;
        background-color: #a12f10;
        color: #fff;
        margin-left: -2px;
        border-bottom-left-radius: 0;
        border-top-left-radius: 0;
    }

    .btn-delete:hover{
        background-color: #932406;
    }

    .btn-droitpraticen{
        background-color: #9c8b6f;
        color: #fff;
        font-size: 11px;
        width: 90px;
        padding: 3px;
        text-transform: uppercase;
        height: 26px;
    }
    .btn-save{
        background-color: #0f4060;
        color: #fff;
        font-size: 12px;
        padding: 5px;
        text-transform: uppercase;
        display: block;
        width: 100%;
        margin-top: 20px;
    }
    .btn-save-active{
        background-color: #fff;
        color: #0f4060;
        font-size: 12px;
        padding: 5px;
        text-transform: uppercase;
        display: block;
        width: 100%;
        margin-top: 20px;
    }

    .btn-save span{
        width: 15px;
        display: inline-block;
    }
    .btn-remove{
        border-bottom-left-radius: 0;
        border-top-left-radius: 0;
        padding: .1rem .5rem;
    }
    .form-control-keyword{
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
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
        background-color: #9c8b6f;
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
        margin-top: 10px;
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
        font-size: 14px;
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
