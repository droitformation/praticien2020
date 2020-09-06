<template>
    <div>
        <div class="form-group">
            <label>Thème principal | Domaine du droit<span class="text-danger">*</span></label>
            <Select2 v-model="selected" :options="themes" @select="isSelected($event)" :settings="{dropdownCssClass:'', placeholder: 'Choix'}" />
        </div>
        <div class="form-group" v-show="subthemes.length">
            <label>Sous-thèmes</label>
            <Select2 v-model="others" :options="subthemes" @select="isNew($event)" :settings="{multiple:true, tags:true, placeholder: 'Sous-thèmes', createTag: createTag}" />
        </div>
    </div>
</template>

<script>
    import Select2 from 'v-select2-component';
    export default {
        props: ['themes'],
        components:{
            Select2
        },
        data(){
            return{
                selected:null,
                others:null,
                subthemes:[],
                url: location.protocol + "//" + location.host+"/",
            }
        },
        mounted() {},
        methods: {
            isSelected : function($event){
                console.log($event);
                this.subthemes = $event.subthemes;
            },
/*            isNew : function($event){
                let self = this;

                axios.post(this.url + "backend/theme/create", {name: term}).then(function (response) {

                    return {
                        id: response.data.id,
                        text: term,
                    }

                }).catch(function (error) { console.log(error);});
            },*/
            createTag : function(params){
                let term = $.trim(params.term);

                if (term === '') {return null;}

                return {
                    id: 'new:' + params.term,
                    text: params.term
                };
            },
        }
    }
</script>
<style>
    .select2-container .select2-selection--single{
        height: 35px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        height: 35px;
        line-height:35px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 35px;
        line-height:35px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        color:#000;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple{
        padding-bottom: 0;
    }
    .select2-container--default .select2-search--inline .select2-search__field{
        height: 25px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
        line-height: 25px;
    }
    .select2-container--default .select2-selection--multiple {
        padding-bottom: 0;
    }
</style>
