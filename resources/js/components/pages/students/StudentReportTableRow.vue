<template>
  <tr>
    <td>{{index+1}}</td>
    <td>{{student_report.admission_number}}</td>
    <td>{{student_report.student_name}}</td>
    <td>{{student_report.user_name}}</td>
    <td>{{student_report.password}}</td>
    <td>{{student_report.parent_username}}</td>
    <td>{{student_report.parent_password}}</td>
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
    props:['student_report','index'

    ],
    data(){
        return{

        }
    }
}



</script>
