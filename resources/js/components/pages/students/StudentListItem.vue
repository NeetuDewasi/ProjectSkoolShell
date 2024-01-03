<template>
    <tr >
        <td>
            <div class="form-check">
                <input type="checkbox" class="form-check-input">
                <label class="form-check-label">#0021</label>
            </div>
        </td>
        <td class="text-center"><img :src="student.avatar" alt="student"></td>
        <td>{{ student.name }}</td>
        <td>{{ student.gender }}</td>
        <td>2</td>
        <td>A</td>
        <td>Jack Sparrow </td>
        <td>TA-107 Newyork</td>
        <td>02/05/2001</td>
        <td>+ 123 9988568</td>
        <td><a href="https://www.radiustheme.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="751e140f1c13141d1c184c46351218141c195b161a18">[email&#160;protected]</a></td>
        <td>
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#"><i
                            class="fas fa-times text-orange-red"></i>Close</a>
                    <a class="dropdown-item" href="#"><i
                            class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                    <a class="dropdown-item" href="#"><i
                            class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                </div>
            </div>
        </td>
    </tr>
</template>

<script>
	export default {
		props: ["student"],
	};
</script>
