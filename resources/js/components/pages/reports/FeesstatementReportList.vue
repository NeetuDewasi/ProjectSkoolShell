<template>
  <tr>
    <td>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" />
        <label class="form-check-label"></label>
      </div>
    </td>
    <td>{{ streport.FeesGroup }}</td>
    <td>{{ streport.FeesCode }}</td>
    <td>{{ streport.DueDate }}</td>
    <td>{{ streport.Status }}</td>
    <td>{{ streport.Amount }}</td>
    <td>{{ streport.PaymentID }}</td>
    <td>{{ streport.Mode }}</td>
    <td>{{ streport.Date }}</td>
    <td>{{ streport.Discount }}</td>
    <td>{{ streport.Fine }}</td>
    <td>{{ streport.Paid }}</td>
    <td>{{ streport.Balance }}</td>
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
