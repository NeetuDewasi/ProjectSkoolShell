<!-- <template>
  <tr>
    <td>{{index+1}}</td>
    <td>{{category.category_name}}</td>
    <td>
      <div class="form-group">
        <button type="submit" class="btn btn-success btn-hover-bluedark mx-2">
          <i class="fas fa-pen text-white" @click.prevent="edit()"></i>
        </button>
        <button type="submit" class="btn btn-danger btn-hover-bluedark" @click="deleteItem()">
          <i class="fas fa-trash text-white"></i>
        </button>
      </div>
    </td>
  </tr>
</template>

<script>
export default{
    props: [
            'category','index'

           ],
           data(){
               return{

               }
           },
           methods:{
               edit(){
            this.$parent.editData(this.category);
        },
               deleteItem() {
                SwalCustomBtn.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$parent.deleteData(this.category, 'deleted');
                    }
                });
            },

           }
};
</script> -->
