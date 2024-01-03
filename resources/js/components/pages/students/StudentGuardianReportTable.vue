<template>
  <tr>
    <td>{{index+1}}</td>
    <td>{{guardian_report.admission_no}}</td>
    <td>{{guardian_report.student_name}}</td>
    <td>{{guardian_report.student_class}}</td>
    <td>{{guardian_report.mobile_no}}</td>
    <td>{{guardian_report.father_name}}</td>
    <td>{{guardian_report.father_phone}}</td>
    <td>{{guardian_report.mother_name}}</td>
    <td>{{guardian_report.mother_phone}}</td>
    <td>{{guardian_report.guardian_name}}</td>
    <td>{{guardian_report.guardian_relation}}</td>
    <td>{{guardian_report.guardian_phone}}</td>
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
            'guardian_report','index'
        ],
}


</script>
