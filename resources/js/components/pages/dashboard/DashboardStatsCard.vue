<template>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="dashboard-summery-one mg-b-20">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="item-icon bg-light-green ">
                        <!-- <i :class="stats.icon"></i> -->
                    </div>
                </div>
                <div class="col-6">
                    <div class="item-content">
                        <div class="item-title"></div>
                        <div class="item-number"><span class="counter"
                                data-num=""></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
	export default {
		props: ["stats"],
	};
</script>
