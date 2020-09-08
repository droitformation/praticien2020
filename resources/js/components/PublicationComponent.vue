<template>
    <div>
        <div class="form-group">
            <label>Status</label>
            <select class="form-control custom-select" name="status" @change="update" v-model="status">
                <option value="pending">Brouillon</option>
                <option value="publish">Publié</option>
                <option value="futur">Date ultérieure</option>
            </select>
        </div>

        <div class="form-group">
            <label for="published_at">Date de publication</label>
            <input type="text" v-model="published_at" name="published_at" placeholder="" class="form-control width-sm" id="published_at">
            <span v-if="hint" class="d-block p-2 text-danger"><i class="fas fa-exclamation-triangle"></i> &nbsp;Choisir la date</span>
        </div>

        <div class="form-group mb-0 mt-4 d-flex flex-row justify-content-between">
            <button v-if="!the_status || status == 'pending'" class="btn btn-outline-primary btn-block mr-1" type="submit">Enregistrer brouillon</button>
            <button v-if="status != 'pending'" class="btn btn-primary btn-block ml-1 mt-0" type="submit">Publier</button>
        </div>
    </div>
</template>

<script>
    import flatpickr from "flatpickr";
    import { French } from "flatpickr/dist/l10n/fr.js";

    import moment from 'moment';

    export default {
        props: ['the_status','the_date'],
        data(){
            return{
                status: this.the_status ? this.the_status : (this.isFuture ? 'futur' : 'pending'),
                hint:false,
                published_at:this.the_date ?? null
            }
        },
        mounted() {
            let self = this;

            const fp = flatpickr("#published_at", {
                altInput: true,
                altFormat: "j F Y",
                dateFormat: "Y-m-d",
                minDate: "today",
                locale: French,
                onChange: function(selectedDates, dateStr, instance) {
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
            });
        },
        computed: {
            isFuture(){
                return moment().diff(this.published_at, 'days') < 0;
            },
        },
        methods: {
            moment: function () {
                return moment();
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
