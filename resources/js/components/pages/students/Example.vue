<template>
	<div>
		{{ result }}
		{{ calculate(number1, number2) }}
		<i class="fas fa-ad"></i>
	</div>
</template>

<script>
export default {
	data() {
		return {
			number1: 10,
			number2: 20,
			result: 0,
		};
	},
	created() {},
	mounted() {
		this.getData();
	},
	methods: {
		calculate(a, b) {
			return a + b;
		},
		async getData() {
			const res = await this.callApi("get", "/api/example", null, null);
			this.number1 = res.data.number1;
			this.number2 = res.data.number2;
			this.result = this.calculate(this.number1, this.number2);
		},
	},
};
</script>
<style scoped>
.fa-inventory {
	content: "\f480";
}
</style>
