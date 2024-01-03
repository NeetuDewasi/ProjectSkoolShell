<template>
  <tr>
    <td>{{generate_id.admission_no}}</td>
    <td>{{generate_id.student_name}}</td>
    <td>{{generate_id.student_class}}</td>
    <td>{{generate_id.father_name}}</td>
    <td>{{generate_id.date_of_birth}}</td>
    <td>{{generate_id.gender}}</td>
    <td>{{generate_id.category}}</td>
    <td>{{generate_id.mobile_no}}</td>
    <td>
      <div class="form-group">
        <button type="submit" class="btn btn-success btn-hover-bluedark mx-2">
          <i class="fas fa-pen text-white"></i>
        </button>
        <button type="submit" class="btn btn-danger btn-hover-bluedark">
          <i class="fas fa-trash text-white"></i>
        </button>
      </div>
    </td>
  </tr>
</template>
<script>


export default {
    props:[
        'generate_id','index'
    ],
    data(){
        return{

        }
    }
}

</script>
