<template>
  <tr>
    <td>{{index++}}</td>
    <td>{{student_house.name}}</td>
    <td>{{student_house.description}}</td>
    <!-- <td>{{student_house.student_house_id}}</td> -->
    <td>
      <div class="form-group">
        <button type="submit" class="btn btn-success btn-hover-bluedark mx-2">
          <i class="fas fa-pen text-white"></i>
        </button>
        <button type="submit" class="btn btn-danger btn-hover-bluedark">
          <i class="fas fa-trash text-white" @click="deleteItem()"></i>
        </button>
      </div>
    </td>
  </tr>
</template>

<script>
export default {
       props:['student_house','index'],
     data(){
         return{
         }
     },
     methods:{
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
                        this.$parent.deleteData(this.student_house, 'deleted');
                    }
                });
            },
     }
}
</script>
