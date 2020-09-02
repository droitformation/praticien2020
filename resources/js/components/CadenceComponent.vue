<template>
    <div>
        <div class="card-form-cadence">
            <div class="inputGroup">
                <input id="radio1" v-model="rhythm" name="cadence" value="weekly" type="radio" @change="update" />
                <label :class="updated ? 'active' : ''" for="radio1">Une fois par semaine</label>
            </div>
            <div class="inputGroup">
                <input id="radio2" v-model="rhythm" name="cadence" value="daily" type="radio" @change="update" />
                <label :class="updated ? 'active' : ''" for="radio2">Tous les jours</label>
            </div>
            <div class="inputGroup">
                <input id="radio3" v-model="rhythm" name="cadence" value="" type="radio" @change="update" />
                <label :class="updated ? 'active' : ''" for="radio3">Jamais</label>
            </div>
        </div>
    </div>
</template>
<style>
    .inputGroup input:checked ~ label.active:after {
        background-color: #7cc28c;
        border-color: #7cc28c;
        color:#fff;
    }
</style>
<script>
    export default {
        props: ['cadence','user_id'],
        data(){
            return{
                rhythm : this.cadence,
                updated: false
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            update : function(){
                var self = this;
                axios.post("cadence",{ user_id: this.user_id, cadence: this.rhythm }).then(function (response) {
                    self.updated = true;
                    setTimeout(() => {
                        self.updated = false;
                    }, 1000);

                }).catch(function (error) { console.log(error);});
            }
        }
    }
</script>
