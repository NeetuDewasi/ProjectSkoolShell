<template>
    <tr>
        <td>
            <div class="form-check">
                <input type="checkbox" class="form-check-input">
                <label class="form-check-label">{{exam.id}}</label>
            </div>
        </td>
        <td>{{ exam.testname }}</td>
        <td>{{ exam.subject }}</td>
        <td>{{ exam.class }}</td>
        <td>{{ exam.section }}</td>
        <td>{{ exam.time }}</td>
        <td>{{ exam.date }}</td>
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
		props: ["exam"],
	};
</script>
