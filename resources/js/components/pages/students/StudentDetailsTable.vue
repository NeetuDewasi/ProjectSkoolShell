<template>
  <tr>
    <td>{{index+1}}</td>
    <td>{{student_details.admission_no}}</td>
    <td>{{student_details.student_name}}</td>
    <td>{{student_details.student_class}}</td>
    <td>{{student_details.father_name}}</td>
    <td>{{student_details.mother_name}}</td>
    <td>{{student_details.mobile_no}}</td>
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
    props:['student_details','index'],
    data(){
        return{

        }
    }
}
</script>
