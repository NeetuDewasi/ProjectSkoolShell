<template>
    <tr>
        <td>{{index+1}}</td>
        <td>{{attendance.admission_number}}</td>
        <td>{{attendance.role_number}}</td>
        <td>{{attendance.name}}</td>
        <td>
        <div class="form-group">
            <input class="form-radio-input" type="radio"
            name="present"
            id="pre" />
            <label class="form-label mr-5" for="present">
            present
            </label>

            <input
            class="form-radio-input"
            type="radio"
            name="late"
            id="late"
            />
            <label class="form-label mr-5" for="late">
            Late
            </label>

            <input
            class="form-radio-input"
            type="radio"
            name="absent"
            id="absent"
            />
            <label class="form-label mr-5" for="absent">
            Absent
            </label>

            <input
            class="form-radio-input"
            type="radio"
            name="half_day"
            id="half_day"
            />
            <label class="form-label mr-5" for="half_day"
            >Half Day
            </label>
        </div>
        </td>
        <td>
        <input type="text" name="note" />
        </td>
    </tr>
</template>

<script>

export default {
    props: ['attendance']
}
</script>
