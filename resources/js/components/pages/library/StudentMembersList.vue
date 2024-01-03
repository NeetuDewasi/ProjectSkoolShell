<template>
  <tr>
    <td>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" />
        <label class="form-check-label"></label>
      </div>
    </td>
    <td>{{ StudentReport.MemberId }}</td>
    <td>{{ StudentReport.libraryCardNumber }}</td>
    <td>{{ StudentReport.StudentName }}</td>
    <td>{{ StudentReport.EmailId }}</td>
    <td>{{ StudentReport.DateOfBirth }}</td>
    <td>{{ StudentReport.ContectNumber }}</td>
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
  props: ["StudentReport"],
};
</script>