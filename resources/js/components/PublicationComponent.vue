<template>
    <div>
        <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="status" @change="update" v-model="status">
                <option value="pending">Brouillon</option>
                <option value="publish">Publié</option>
                <option value="futur">Date ultérieure</option>
            </select>
        </div>

        <div class="form-group">
            <label>Date de publication</label>
            <span v-if="hint" class="d-block p-2 text-danger"><i class="fas fa-exclamation-triangle"></i> &nbsp;Choisir la date</span>

            <flat-pickr
                v-model="published_at"
                :config="config"
                class="form-control width-sm"
                placeholder="Date"
                @on-change="change"
                name="published_at">
            </flat-pickr>

        </div>

        <div class="form-group mb-0 mt-4 d-flex flex-row justify-content-between">
            <button v-if="!the_status || status == 'pending'" class="btn btn-outline-primary btn-block mr-1" type="submit">Enregistrer brouillon</button>
            <button v-if="status != 'pending'" class="btn btn-primary btn-block ml-1 mt-0" type="submit">Publier</button>
        </div>
    </div>
</template>

<script>

    import { French } from "flatpickr/dist/l10n/fr.js";
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    import moment from 'moment';

    export default {
        props: ['the_status','the_date'],
        data(){
            return{
                status: this.the_status ? this.the_status : (this.isFuture ? 'futur' : 'pending'),
                hint:false,
                published_at: this.the_date ? moment(this.the_date).format('YYYY-MM-DD') : null,
                config: {
                    altInput: true,
                    altFormat: "j F Y",
                    dateFormat: "Y-m-d",
                    locale: French
                },
            }
        },
        mounted() {  },
        computed: {
            isFuture(){
                return moment().diff(this.published_at, 'days') < 0;
            },
        },
        components: {
            flatPickr
        },
        methods: {
            moment: function () {
                return moment();
            },
            change:function(selectedDates, dateStr, instance){
                let today = moment(dateStr).isSame(moment(), 'day');
                self.isToday = today;
                self.hint = false;

                if(dateStr == ''){
                    self.status = 'pending';
                }
                else{
                    self.status = today ? 'publish' : 'futur';
                }
            },
            update : function(){

                const fp = document.querySelector("#published_at")._flatpickr;

                if(this.status == 'pending'){
                    fp.clear();
                }

                if(this.status == 'publish'){
                    fp.setDate(moment().format('YYYY-MM-DD'));
                    this.published_at = moment().format('YYYY-MM-DD');
                }

                if(this.status == 'futur'){
                   this.hint = true;
                }
            }
        }
    }
</script>
