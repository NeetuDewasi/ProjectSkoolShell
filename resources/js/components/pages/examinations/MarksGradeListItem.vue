<template>
    <tr>
        <td>
            <div class="form-check">
                <input type="checkbox" class="form-check-input">
                <label class="form-check-label">{{mark.id}}</label>
            </div>
        </td>
        <td>{{mark.grade}}</td>
        <td>{{mark.name}}</td>
        <td>{{mark.gradePoint}}</td>
        <td>{{mark.percentageFrom}}</td>
        <td>{{mark.percentageTo}}</td>
        <td>{{mark.comment}}</td>
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
		props: ["mark"],
	};
</script>
