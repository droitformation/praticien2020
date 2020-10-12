<template>
    <div>
        <div class="form-group">
            <label>Thème principal | Domaine du droit<span class="text-danger">*</span></label>
            <Select2 v-model="selected" :options="themes" @select="isSelected($event)" :settings="{dropdownCssClass:'', placeholder: 'Choix'}" />
            <input v-if="selected" name="theme_id" :value="selected" type="hidden">
        </div>

        <div class="form-group" v-show="subthemes.length > 0 || others.length > 0">
            <label>Sous-thèmes</label>
            <Select2 ref="other" v-if="subthemes" v-model="others" :options="subthemes" :settings="{multiple:true, tags:true, placeholder: 'Sous-thèmes', createTag: createTag}" />
            <input v-if="others" v-for="other in others" name="subthemes[]" :value="other" type="hidden">
        </div>
    </div>
</template>

<script>
    import Select2 from 'v-select2-component';
    export default {
        props: ['themes','current_theme','current_subthemes'],
        components:{
            Select2
        },
        data(){
            return{
                selected : this.current_theme ? this.current_theme.id : null,
                others   : this.current_subthemes ? this.current_subthemes : [],
                subthemes: this.current_theme && this.current_theme.subthemes ? this.current_theme.subthemes : [] ,
                url: location.protocol + "//" + location.host+"/",
            }
        },
        mounted() {
            if(this.$refs.other){
                this.$refs.other.select2.val(this.others).trigger('change');
            }
        },
        methods: {
            isSelected : function($event){
                console.log($event);
                this.subthemes = $event.subthemes;
                this.selected = $event.id;
            },
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
