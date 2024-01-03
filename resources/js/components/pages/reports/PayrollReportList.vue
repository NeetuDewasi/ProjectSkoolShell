<template>
  <tr>
    <td>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" />
        <label class="form-check-label"></label>
      </div>
    </td>
    <td>{{ streport.Name }}</td>
    <td>{{ streport.Role }}</td>
    <td>{{ streport.Designation }}</td>
    <td>{{ streport.MonthYear }}</td>
    <td>{{ streport.Payslip }}</td>
    <td>{{ streport.BasicSalary }}</td>
    <td>{{ streport.Erning }}</td>
    <td>{{ streport.GrossSalary }}</td>
    <td>{{ streport.Tax }}</td>
    <td>{{ streport.NetSalary }}</td>
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