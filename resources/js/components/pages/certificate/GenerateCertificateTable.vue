<template>
  <tr>
    <td>{{generate_certificate.admission_no}}</td>
    <td>{{generate_certificate.student_name}}</td>
    <td>{{generate_certificate.student_class}}</td>
    <td>{{generate_certificate.father_name}}</td>
    <td>{{generate_certificate.date_of_birth}}</td>
    <td>{{generate_certificate.gender}}</td>
    <td>{{generate_certificate.category}}</td>
    <td>{{generate_certificate.mobile_no}}</td>
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
       props:['generate_certificate'],
       data(){
           return{

           }
       }
}

</script>
