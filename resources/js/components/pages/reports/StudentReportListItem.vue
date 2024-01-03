<template>
  <tr>
    <td>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" />
        <label class="form-check-label"></label>
      </div>
    </td>
    <td>{{ streport.ClassSection }}</td>
    <td>{{ streport.AdmissionNumber }}</td>
    <td>{{ streport.StudentName }}</td>
    <td>{{ streport.FatherName }}</td>
    <td>{{ streport.DateOfBirth }}</td>
    <td>{{ streport.Gender }}</td>
    <td>{{ streport.Category }}</td>
    <td>{{ streport.MobileNumber }}</td>
    <td>{{ streport.NationalInternationalNumber }}</td>
    <td>{{ streport.LocalInternationalNumber }}</td>
    <td>{{ streport.Ret }}</td>
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
  props: ["streport"],
};
</script>