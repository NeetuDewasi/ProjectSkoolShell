<template>
    <li class="nav-item sidebar-nav-item"  v-if="menu.subMenuList && menu.subMenuList.length">
        <a href="#" class="nav-link">
            <i :class="menu.flatIcon" v-if="menu.flatIcon"></i>
            <img :src="menu.imageIcon" class="image-icon" v-if="menu.imageIcon" />
            <span>{{ menu.title }}</span>
        </a>
        <ul class="nav sub-group-menu">
            <li class="nav-item" v-for="(item, index) in menu.subMenuList" :key="index">
                <router-link :to="item.to" class="nav-link">
                    <i class="fas fa-angle-right"></i>
                    {{ item.name }}
                </router-link>
            </li>
        </ul>
    </li>
    <li class="nav-item" v-else>
        <router-link :to="menu.to" class="nav-link">
            <i :class="menu.flatIcon" v-if="menu.flatIcon"></i>
            <img :src="menu.imageIcon" class="image-icon" v-if="menu.imageIcon" />
            <span>{{ menu.title }}</span>
        </router-link>
    </li>
</template>

<script>
	export default {
		props: ["menu"],
	};
</script>

<style>

</style>
