<template>
  <tr>
    <td>{{student_certificate.certificate_name}}</td>
    <td>{{student_certificate.background_image}}</td>
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
    props:['student_certificate','index'],
    data(){
        return{

        }
    }
}
</script>
