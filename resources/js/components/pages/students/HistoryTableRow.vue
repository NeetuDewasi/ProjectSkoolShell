<template>
  <tr>
    <td>{{student_history.admission_no}}</td>
    <td>{{student_history.admission_date}}</td>
    <td>{{student_history.student_class}}</td>
    <td>{{student_history.student_session}}</td>
    <td>{{student_history.years}}</td>
    <td>{{student_history.student_name}}</td>
    <td>{{student_history.mobile_no}}</td>
    <td>{{student_history.father_name}}</td>
    <td>{{student_history.father_phone}}</td>
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
        'student_history'
    ],
    data(){
        return{

        }
    }
}




</script>
