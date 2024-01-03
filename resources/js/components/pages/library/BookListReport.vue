<template>
  <tr>
    <td>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" />
        <label class="form-check-label"></label>
      </div>
    </td>
    <td>{{ BookReport.BookTile }}</td>
    <td>{{ BookReport.BookNumber }}</td>
    <td>{{ BookReport.ISBNNumber }}</td>
    <td>{{ BookReport.Publisher }}</td>
    <td>{{ BookReport.RackNumber }}</td>
    <td>{{ BookReport.Quantity }}</td>
    <td>{{ BookReport.Price }}</td>
    <td>{{ BookReport.PostDate }}</td>
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
  props: ["BookReport"],
};
</script>