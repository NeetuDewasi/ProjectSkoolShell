<template>
  <div class="col-md-12 col-12">
    <VueSelect2
        ref="commonSelect2"
      class="form-control"
      v-model="itemId"
      :options="options"
      @change="onChange($event)"
    />
  </div>
</template>

<script>
    export default {
        props: ["items", 'placeholder', 'selectedId'],
        data() {
            return {
                list: [],
                itemId: -1,
                options: [],
                optionPlaceHolder: '--SELECT AN OPTION--'
            };
        },
        mounted() {
            this.list = this.items;
            this.optionPlaceHolder = this.placeholder != null ? this.placeholder : '--SELECT AN OPTION--';
            this.itemId = this.selectedId;
        },
        watch: {
            items: function (val) {
                this.list = val;
            },
            itemId: function (val){
                this.itemId = val;
            },
        },
        methods: {
            loadSelect2Script() {
                select2Script();
            },
            updateList(list) {
                this.list = list;
                this.options = [];
                this.options.push({text: this.optionPlaceHolder, id: -1})
                this.list.forEach(item => {
                    this.options.push({
                        text: item.name,
                        id: item.value
                    });
                });
            },
            setSelected(val) {
                this.itemId = val;
            },
            getSelectedId() {
                this.itemId = this.$refs.select2.value
                return this.itemId;
            },
            changeItemId(value) {
                this.itemId = value;
            },
            onChange(value) {
                this.$emit("change", this.itemId);
            },
        },
    };
    function select2Script() {
        if ($.fn.select2 !== undefined) {
            $(".select2").select2({
                width: "100%",
            });
        }
    }
</script>

<style>
    .form-control > .select2.select2-container.select2-container--default .select2-selection--single{
        height: 45px;
        background: none;
        border:none
    }
    .form-control > .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 10px;
    }
    .form-control > .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 42px;
    }
    .form-control > .select2.select2-container.select2-container--default:nth-child(3) {
        display: none;
    }
</style>
