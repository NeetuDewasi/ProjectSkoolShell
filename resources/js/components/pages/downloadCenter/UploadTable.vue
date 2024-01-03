<template>
  <tr>
    <td>{{index+1}}</td>
    <td>{{uploadContent.user_id}}</td>
    <td>{{uploadContent.school_class}}</td>
    <td>{{uploadContent.school_section}}</td>
    <td>{{uploadContent.content_type}}</td>
    <td>{{uploadContent.title}}</td>
    <td>{{uploadContent.published_at}}</td>
    <td>{{uploadContent.description}}</td>
    <td>{{uploadContent.documents}}</td>
    <td>
      <button type="submit" class="btn btn-success btn-hover-bluedark mx-2">
        <i class="fas fa-pen text-white" @click.prevent="edit()"></i>
      </button>
      <button type="submit" class="btn btn-danger btn-hover-bluedark">
        <i class="fas fa-trash text-white" @click="deleteItem()"></i>
      </button>
    </td>
  </tr>
</template>

<script>

export default {
    props: ['index','uploadContent'],

methods:{
    //  edit(item){
    //             this.$router.push({
    //                 path: `/admin/academics/class/edit/${item.id}`,
    //             });
    //         },
    //         deleteItem() {
    //             SwalCustomBtn.fire({
    //                 title: "Are you sure?",
    //                 text: "You won't be able to revert this!",
    //                 icon: "warning",
    //                 showCancelButton: true,
    //                 confirmButtonText: "Yes, Delete it!",
    //                 cancelButtonText: "No, cancel!",
    //                 reverseButtons: true,
    //             }).then((result) => {
    //                 if (result.isConfirmed) {
    //                     this.$parent.deleteData(this.uploadContent, 'deleted');
    //                 }
    //             });
    //         },

}
}
</script>
