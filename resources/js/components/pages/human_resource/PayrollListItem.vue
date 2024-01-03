<template>
    <tr>
        <td>
            <div class="form-check">
                <input type="checkbox" class="form-check-input">
                <label class="form-check-label">{{payroll.id}}</label>
            </div>
        </td>
        <td>{{ payroll.staff_id }}</td>
        <td>{{ payroll.name }}</td>
        <td>{{ payroll.role }}</td>
        <td>{{ payroll.department }}</td>
        <td>{{ payroll.designation }}</td>
        <td>{{ payroll.phone }}</td>
        <td class="badge badge-pill badge-success d-block mg-t-8">
            {{ payroll.status }}
            </td>
        <td>
           <div class="form-group">
                <button type="submit" class="btn btn-success btn-hover-bluedark mx-2">
                    <i class="fas fa-pen text-white"></i>
                </button>
                <button type="submit" class="btn btn-danger btn-hover-bluedark">
                    <i class="fas fa-trash text-white"></i>
                </button>
                 <button type="submit" class="btn btn-success btn-hover-bluedark">
                  <i class="ti-files text-white"></i>
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
	export default {
		props: ["payroll"],
	};
</script>
