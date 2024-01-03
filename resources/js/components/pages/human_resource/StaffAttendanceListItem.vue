<template>
    <tr>
        <td>
            <div class="form-check">
                <input type="checkbox" class="form-check-input">
                <label class="form-check-label">{{staffAttendence.id}}</label>
            </div>
        </td>
        <td>{{ staffAttendence.name }}</td>
        <td>{{ staffAttendence.present }}</td>
        <td>{{ staffAttendence.absent }}</td>
        <td>{{ staffAttendence.late }}</td>
        <td>{{ staffAttendence.holiday }}</td>
        <td>{{ staffAttendence.half_day }}</td>
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
		props: ["staffAttendence"],
	};
</script>
