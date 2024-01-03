<template>
    <tr>
        <td>
            <div class="form-check">
                <input type="checkbox" class="form-check-input">
                <label class="form-check-label">{{result.id}}</label>
            </div>
        </td>
        <td>{{ result.admission_no }}</td>
        <td>{{ result.roll_no }}</td>
        <td>{{ result.stu_name }}</td>
        <td>{{ result.hindi }}</td>
        <td>{{ result.math }}</td>
        <td>{{ result.english }}</td>
        <td>{{ result.sst }}</td>
        <td>{{ result.drawing }}</td>
        <td>{{ result.total }}</td>
        <td>{{ result.percentage }}</td>
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
		props: ["result"],
	};
</script>
