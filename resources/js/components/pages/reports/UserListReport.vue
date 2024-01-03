<template>
  <tr>
    <td>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" />
        <label class="form-check-label">{{ userreport.Users }}</label>
      </div>
    </td>
    <td>{{ userreport.Role }}</td>
    <td>{{ userreport.IpAddress }}</td>
    <td>{{ userreport.LoginTime }}</td>
    <td>{{ userreport.UserAgent }}</td>
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
  props: ["userreport"],
};
</script>