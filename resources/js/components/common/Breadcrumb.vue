<template>
    <div>
        <div class="breadcrumbs-area">
            <div class="d-flex justify-content-between">
                <h3>{{ pageTitle }}</h3>
                <div>
                    <slot name="button"></slot>
                </div>
            </div>
            <ul>
                <li v-for="(item, index) in breadcrumbList" :key="index">
                    <router-link :to="item.to" v-if="item.to">{{ item.name }}</router-link>
                    <span v-else>{{ item.name }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
	export default {
		props: ["pageTitle", "breadcrumbList"],
	};
</script>
