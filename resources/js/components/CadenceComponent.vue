<template>
    <div>
        <div class="card-form-cadence">
            <div class="inputGroup">
                <input id="radio1" v-model="rhythm" name="cadence" value="weekly" type="radio" @change="update" />
                <label for="radio1">Une fois par semaine</label>
            </div>
            <div class="inputGroup">
                <input id="radio2" v-model="rhythm" name="cadence" value="daily" type="radio"  @change="update" />
                <label for="radio2">Tous les jours</label>
            </div>
        </div>
    </div>
</template>

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
                    }, 1500);

                }).catch(function (error) { console.log(error);});
            }
        }
    }
</script>
