<template>
    <div>
        <div id="wrapper" class="wrapper bg-ash" v-show="activeSchoolId !== -1">
            <div class="navbar navbar-expand-md header-menu-one bg-light">
                <div class="nav-bar-header-one">
                    <div class="header-logo">
                        <router-link :to="{ name: 'school.dashboard' }">
                            <img src="/assets/img/logo.png" alt="logo" />
                        </router-link>
                    </div>
                    <div class="toggle-button sidebar-toggle">
                        <button type="button" class="item-link">
                            <span class="btn-icon-wrap">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="d-md-none mobile-nav-bar">
                    <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse"
                        data-target="#mobile-navbar" aria-expanded="false">
                        <i class="far fa-arrow-alt-circle-down"></i>
                    </button>
                    <button type="button" class="navbar-toggler sidebar-toggle-mobile">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="header-main-menu collapse navbar-collapse" id="mobile-navbar">
                    <ul class="navbar-nav">
                        <li class="navbar-item header-search-bar">
                            <div class="input-group stylish-input-group">
                                <span class="input-group-addon">
                                    <button type="submit">
                                        <span class="flaticon-search" aria-hidden="true"></span>
                                    </button>
                                </span>
                                <input type="text" class="form-control" placeholder="Find Something . . ." />
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="navbar-item dropdown header-language">
                            <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-expanded="false">Session : {{ activeSession }}</a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" @click.prevent="activeSession = '2022-23'">2022-23</a>
                                <a class="dropdown-item" href="#" @click.prevent="activeSession = '2021-22'">2021-22</a>
                            </div>
                        </li>
                        <li class="navbar-item dropdown header-admin">
                            <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-expanded="false">
                                <div class="admin-title">
                                    <h5 class="item-title">Stevne Zone</h5>
                                    <span>Admin</span>
                                </div>
                                <div class="admin-img">
                                    <img src="/assets/img/figure/admin.jpg" alt="Admin" />
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="item-header">
                                    <h6 class="item-title">Steven Zone</h6>
                                </div>
                                <div class="item-content">
                                    <ul class="settings-list">
                                        <li>
                                            <a href="#">
                                                <i class="flaticon-user"></i>My
                                                Profile
                                            </a>
                                        </li>
                                        <!-- <li>
                      <a href="#">
                        <i class="flaticon-list"></i>Task
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="flaticon-chat-comment-oval-speech-bubble-with-text-lines"></i>Message
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="flaticon-gear-loading"></i>Account Settings
                      </a>
                    </li> -->
                                        <li>
                                            <a @click.prevent="logout()">
                                                <i class="flaticon-turn-off"></i>Log Out
                                            </a>
                                            <form ref="userLogout" id="logout-form" action="/logout" method="POST"
                                                style="display: none">
                                                <input type="hidden" name="_token" :value="csrf" />
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!-- <li class="navbar-item dropdown header-message">
              <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-expanded="false">
                <i class="far fa-envelope"></i>
                <div class="item-title d-md-none text-16 mg-l-10">Message</div>
                <span>5</span>
              </a>

              <div class="dropdown-menu dropdown-menu-right">
                <div class="item-header">
                  <h6 class="item-title">05 Message</h6>
                </div>
                <div class="item-content">
                  <div class="media">
                    <div class="item-img bg-skyblue author-online">
                      <img src="/assets/img/figure/student11.png" alt="img" />
                    </div>
                    <div class="media-body space-sm">
                      <div class="item-title">
                        <a href="#">
                          <span class="item-name">Maria Zaman</span>
                          <span class="item-time">18:30</span>
                        </a>
                      </div>
                      <p>
                        What is the reason of buy this
                        item. Is it usefull for me.....
                      </p>
                    </div>
                  </div>
                  <div class="media">
                    <div class="item-img bg-yellow author-online">
                      <img src="/assets/img/figure/student12.png" alt="img" />
                    </div>
                    <div class="media-body space-sm">
                      <div class="item-title">
                        <a href="#">
                          <span class="item-name">Benny Roy</span>
                          <span class="item-time">10:35</span>
                        </a>
                      </div>
                      <p>
                        What is the reason of buy this
                        item. Is it usefull for me.....
                      </p>
                    </div>
                  </div>
                  <div class="media">
                    <div class="item-img bg-pink">
                      <img src="/assets/img/figure/student13.png" alt="img" />
                    </div>
                    <div class="media-body space-sm">
                      <div class="item-title">
                        <a href="#">
                          <span class="item-name">Steven</span>
                          <span class="item-time">02:35</span>
                        </a>
                      </div>
                      <p>
                        What is the reason of buy this
                        item. Is it usefull for me.....
                      </p>
                    </div>
                  </div>
                  <div class="media">
                    <div class="item-img bg-violet-blue">
                      <img src="/assets/img/figure/student11.png" alt="img" />
                    </div>
                    <div class="media-body space-sm">
                      <div class="item-title">
                        <a href="#">
                          <span class="item-name">Joshep Joe</span>
                          <span class="item-time">12:35</span>
                        </a>
                      </div>
                      <p>
                        What is the reason of buy this
                        item. Is it usefull for me.....
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="navbar-item dropdown header-notification">
              <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-expanded="false">
                <i class="far fa-bell"></i>
                <div class="item-title d-md-none text-16 mg-l-10">Notification</div>
                <span>8</span>
              </a>

              <div class="dropdown-menu dropdown-menu-right">
                <div class="item-header">
                  <h6 class="item-title">
                    03 Notifiacations
                  </h6>
                </div>
                <div class="item-content">
                  <div class="media">
                    <div class="item-icon bg-skyblue">
                      <i class="fas fa-check"></i>
                    </div>
                    <div class="media-body space-sm">
                      <div class="post-title">
                        Complete Today Task
                      </div>
                      <span>1 Mins ago</span>
                    </div>
                  </div>
                  <div class="media">
                    <div class="item-icon bg-orange">
                      <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="media-body space-sm">
                      <div class="post-title">
                        Director Metting
                      </div>
                      <span>20 Mins ago</span>
                    </div>
                  </div>
                  <div class="media">
                    <div class="item-icon bg-violet-blue">
                      <i class="fas fa-cogs"></i>
                    </div>
                    <div class="media-body space-sm">
                      <div class="post-title">
                        Update Password
                      </div>
                      <span>45 Mins ago</span>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="navbar-item dropdown header-language">
              <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-globe-americas"></i>EN
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">English</a>
                <a class="dropdown-item" href="#">Spanish</a>
                <a class="dropdown-item" href="#">Franchis</a>
                <a class="dropdown-item" href="#">Chiness</a>
              </div>
            </li> -->
                    </ul>
                </div>
            </div>
            <div class="dashboard-page-one">
                <div class="
						sidebar-main
						sidebar-menu-one
						sidebar-expand-md
						sidebar-color
					">
                    <div class="mobile-sidebar-header d-md-none">
                        <div class="header-logo">
                            <router-link to="{name:'admin.dashboard'}">
                                <img src="/assets/img/logo1.png" alt="logo" />
                            </router-link>
                        </div>
                    </div>
                    <!-- <SidebarItem v-for="(menuItem, index) in sidebarMenuList" :key="index" :menu="menuItem" /> -->
                    <div class="sidebar-menu-content">
                        <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                            <li class="nav-item sidebar-nav-item" v-for="menu, index in menus" :key="menu.menu_id">
                                <a href="#" class="nav-link">
                                    <span> {{ menu.menu_name }}</span>
                                </a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item" v-for="component, index in menu.components"
                                        :key="component.component_id">
                                        <router-link class="text-light p-2" :to="component.path_name">
                                            <i class="fas fa-angle-right mx-4 p-2"></i>
                                            {{ component.component_name }}
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <!-- <li class="nav-item" >
          <router-link :to="menu.to" class="nav-link">


              <span>{{ menu.title }}</span>
          </router-link>
      </li> -->
                    </div>
                </div>
                <div class="main-content-container">
                    <router-view @click.native="scrollToTop" :key="$route.fullPath"></router-view>
                </div>
            </div>
        </div>
        <div v-show="!loader && activeSchoolId === -1">
            <div v-if="!isActive && active_school">
                <div v-show="active_school.group && !isActive" style="
						box-shadow: 0 8px 6px -6px #d4d4d4;
						border-radius: 5px;
					" class="py-3">
                    <div class="text-center">
                        <img src="/assets/img/school_group1.png" alt width="150" />
                    </div>
                    <div class="text-center">
                        <strong>{{ active_school.group.group_name ? active_school.group.group_name : '' }}</strong>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-5" v-if="!isActive">
                <div class="row text-center justify-content-center">
                    <div class="col-md-2 col-sm-12 pointer text-center" v-if="active_school">
                        <div class="school_card" :style="`background-color: ${randomColor()}`"
                            @click="setActiveSchool(active_school)">
                            <img src="/assets/img/school.png" alt width="100" />
                            <div class="mt-2">
                                <strong>{{ active_school.name }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <div class="text-muted">Select a School to Continue</div>
                </div>

            </div>
        </div>

        <div class="card centered-section shadow-lg p-3 mb-5 bg-body rounded" v-show="isActive">
            <label>Activation key<strong class="text-danger">*</strong></label>
            <input class="form-control p-4" placeholder="Enter the Activation key" v-model="activation_key" />
            <button type="submit" class="mt-3 btn btn-sm btn-success" @click="addActivation()">Submit</button>
        </div>
    </div>
</template>

<script>
// import SidebarItem from "./widget/SidebarItem";

import MenuList from "./SideMenu";
export default {
    //   components: { SidebarItem },
    data() {
        return {
            activeSession: "2022-23",
            activeSchoolId: -1,
            active_school: {
                group: {}
            },
            loader: true,
            schools: [],
            schoolGroup: [],
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            sidebarMenuList: [],
            menus: [],
            components: [],
            active_school_id: -1,
            activation_key: '',
            isActive: false,
        };
    },
    mounted() {
        this.loadMainScript();
        // this.loadOtherScript();
        setTimeout(() => {
            this.loader = false;
        }, 1500);
    },
    created() {
        this.getSchools();
        if (sessionStorage.getItem('activeSchool') && sessionStorage.getItem('activeSchool') !== null) {
            this.activeSchoolId = parseInt(sessionStorage.getItem('activeSchool')); // Parse it as an integer
            this.getMenus();
            this.getComponents();
        }
    },

    methods: {
        scrollToTop() {
            window.scrollTo(0, 0);
        },
        logout() {
            sessionStorage.removeItem('activeSchool');
            this.$refs.userLogout.submit();
        },
        loadMainScript() {
            init();
        },
        loadOtherScript() {
            otherScript();
            select2Script();
        },
        loadDataTableScript() {
            dataTableScript();
        },
        loadSelect2Script() {
            select2Script();
        },
        async addActivation() {
            var data = new FormData();
            data.append("active_school_id", this.active_school_id);
            data.append("activation_key", this.activation_key);
            const res = await this.callApi(
                "post",
                `/api/this_school/activation/`,
                data
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    window.location.reload(true);
                }
            }
        },
        async getSchools() {
            const res = await this.callApi("get", `/api/all_schools`, null);
            this.activeSchoolId = -1;
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.active_school = data.active_school;
                    console.log('schools', this.active_school);
                    this.activeSchoolId = data.active_school_id;
                    //   this.schoolGroup = data.school_group;
                }
            }
        },
        async setActiveSchool(item) {
            var data = new FormData();
            data.append("school_id", item.school_id);
            const res = await this.callApi(
                "post",
                `/api/this_schools/selected`,
                data
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    sessionStorage.setItem('activeSchool', item.school_id);

                    this.active_school_id = data.active_school_id;
                    if (data.school.activation_start_date !== null && data.school.activation_end_date !== null) {
                        window.location.reload(true);
                        this.active_school_id = data.active_school_id;
                        console.log('school active id', this.active_school_id);
                        this.getMenus(this.active_school_id);
                    } else {
                        this.isActive = true;
                    }

                }
            }
        },
        async getMenus(active_school) {
            console.log('active id', this.activeSchoolId);
            const res = await this.callApi("get", `/api/menus/${this.activeSchoolId}`, null);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.menus = data.menu_names;
                    // arr = MenuList.SchoolMenuList.filter((e,i) => e.name === data.menus[i]);
                }
            }
        },
        async getComponents() {
            const res = await this.callApi("get", `/api/admin/component/component_list`, null);
            console.log(res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.components = data.components;
                    this.menus = data.menu_names;
                }
            }
        },
    }
};
function init() {
    $(".sidebar-toggle-view").on(
        "click",
        ".sidebar-nav-item .nav-link",
        function (e) {
            if (!$(this).parents("#wrapper").hasClass("sidebar-collapsed")) {
                var animationSpeed = 300,
                    subMenuSelector = ".sub-group-menu",
                    $this = $(this),
                    checkElement = $this.next();
                if (
                    checkElement.is(subMenuSelector) &&
                    checkElement.is(":visible")
                ) {
                    checkElement.slideUp(animationSpeed, function () {
                        checkElement.removeClass("menu-open");
                    });
                    checkElement
                        .parent(".sidebar-nav-item")
                        .removeClass("active");
                } else if (
                    checkElement.is(subMenuSelector) &&
                    !checkElement.is(":visible")
                ) {
                    var parent = $this.parents("ul").first();
                    var ul = parent.find("ul:visible").slideUp(animationSpeed);
                    ul.removeClass("menu-open");
                    var parent_li = $this.parent("li");
                    checkElement.slideDown(animationSpeed, function () {
                        checkElement.addClass("menu-open");
                        parent
                            .find(".sidebar-nav-item.active")
                            .removeClass("active");
                        parent_li.addClass("active");
                    });
                }
                if (checkElement.is(subMenuSelector)) {
                    e.preventDefault();
                }
            } else {
                if ($(this).attr("href") === "#") {
                    e.preventDefault();
                }
            }
        }
    );

    $(".sidebar-toggle").on("click", function () {
        window.setTimeout(function () {
            $("#wrapper").toggleClass("sidebar-collapsed");
        }, 500);
    });

    $(".sidebar-toggle-mobile").on("click", function () {
        $("#wrapper").toggleClass("sidebar-collapsed-mobile");
        if ($("#wrapper").hasClass("sidebar-collapsed")) {
            $("#wrapper").removeClass("sidebar-collapsed");
        }
    });

    $.scrollUp({
        scrollText: '<i class="fa fa-angle-up"></i>',
        easingType: "linear",
        scrollSpeed: 900,
        animation: "fade",
    });

    $("#preloader").fadeOut("slow", function () {
        $(this).remove();
    });

}
function otherScript() {
    $(".checkAll").on("click", function () {
        $(this)
            .parents(".table")
            .find("input:checkbox")
            .prop("checked", this.checked);
    });

    $('[data-toggle="tooltip"]').tooltip();

    if ($.fn.datepicker !== undefined) {
        $(".air-datepicker").datepicker({
            language: {
                days: [
                    "Sunday",
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday",
                ],
                daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                months: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ],
                monthsShort: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                today: "Today",
                clear: "Clear",
                dateFormat: "dd/mm/yyyy",
                firstDay: 0,
            },
        });
    }

    var counterContainer = $(".counter");
    if (counterContainer.length) {
        counterContainer.counterUp({
            delay: 50,
            time: 1000,
        });
    }

    if ($.fn.vectorMap !== undefined) {
        $("#world-map").vectorMap({
            map: "world_mill",
            zoomButtons: false,
            backgroundColor: "transparent",

            regionStyle: {
                initial: {
                    fill: "#0070ba",
                },
            },
            focusOn: {
                x: 0,
                y: 0,
                scale: 1,
            },
            series: {
                regions: [
                    {
                        values: {
                            CA: "#41dfce",
                            RU: "#f50056",
                            US: "#f50056",
                            IT: "#f50056",
                            AU: "#fbd348",
                        },
                    },
                ],
            },
        });
    }

    if ($("#earning-line-chart").length) {
        var lineChartData = {
            labels: ["", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun", ""],
            datasets: [
                {
                    data: [0, 5e4, 1e4, 5e4, 14e3, 7e4, 5e4, 75e3, 5e4],
                    backgroundColor: "#ff9d01",
                    borderColor: "#ff9d01",
                    borderWidth: 1,
                    pointRadius: 0,
                    pointBackgroundColor: "#ff9d01",
                    pointBorderColor: "#ffffff",
                    pointHoverRadius: 6,
                    pointHoverBorderWidth: 3,
                    fill: "origin",
                    label: "Total Collection",
                },
                {
                    data: [0, 3e4, 2e4, 6e4, 7e4, 5e4, 5e4, 9e4, 8e4],
                    backgroundColor: "#042954",
                    borderColor: "#042954",
                    borderWidth: 1,
                    pointRadius: 0,
                    pointBackgroundColor: "#042954",
                    pointBorderColor: "#ffffff",
                    pointHoverRadius: 6,
                    pointHoverBorderWidth: 3,
                    fill: "origin",
                    label: "Fees Collection",
                },
            ],
        };
        var lineChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
            },
            scales: {
                xAxes: [
                    {
                        display: true,
                        ticks: {
                            display: true,
                            fontColor: "#222222",
                            fontSize: 16,
                            padding: 20,
                        },
                        gridLines: {
                            display: true,
                            drawBorder: true,
                            color: "#cccccc",
                            borderDash: [5, 5],
                        },
                    },
                ],
                yAxes: [
                    {
                        display: true,
                        ticks: {
                            display: true,
                            autoSkip: true,
                            maxRotation: 0,
                            fontColor: "#646464",
                            fontSize: 16,
                            stepSize: 25000,
                            padding: 20,
                            callback: function (value) {
                                var ranges = [
                                    {
                                        divider: 1e6,
                                        suffix: "M",
                                    },
                                    {
                                        divider: 1e3,
                                        suffix: "k",
                                    },
                                ];

                                function formatNumber(n) {
                                    for (var i = 0; i < ranges.length; i++) {
                                        if (n >= ranges[i].divider) {
                                            return (
                                                (
                                                    n / ranges[i].divider
                                                ).toString() + ranges[i].suffix
                                            );
                                        }
                                    }
                                    return n;
                                }
                                return formatNumber(value);
                            },
                        },
                        gridLines: {
                            display: true,
                            drawBorder: false,
                            color: "#cccccc",
                            borderDash: [5, 5],
                            zeroLineBorderDash: [5, 5],
                        },
                    },
                ],
            },
            legend: {
                display: false,
            },
            tooltips: {
                mode: "index",
                intersect: false,
                enabled: true,
            },
            elements: {
                line: {
                    tension: 0.35,
                },
                point: {
                    pointStyle: "circle",
                },
            },
        };
        var earningCanvas = $("#earning-line-chart").get(0).getContext("2d");
        var earningChart = new Chart(earningCanvas, {
            type: "line",
            data: lineChartData,
            options: lineChartOptions,
        });
    }
    if ($("#expense-bar-chart").length) {
        var barChartData = {
            labels: ["Jan", "Feb", "Mar"],
            datasets: [
                {
                    backgroundColor: ["#40dfcd", "#417dfc", "#ffaa01"],
                    data: [125000, 100000, 75000, 50000, 150000],
                    label: "Expenses (millions)",
                },
            ],
        };
        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
            },
            scales: {
                xAxes: [
                    {
                        display: false,
                        maxBarThickness: 100,
                        ticks: {
                            display: false,
                            padding: 0,
                            fontColor: "#646464",
                            fontSize: 14,
                        },
                        gridLines: {
                            display: true,
                            color: "#e1e1e1",
                        },
                    },
                ],
                yAxes: [
                    {
                        display: true,
                        ticks: {
                            display: true,
                            autoSkip: false,
                            fontColor: "#646464",
                            fontSize: 14,
                            stepSize: 25000,
                            padding: 20,
                            beginAtZero: true,
                            callback: function (value) {
                                var ranges = [
                                    {
                                        divider: 1e6,
                                        suffix: "M",
                                    },
                                    {
                                        divider: 1e3,
                                        suffix: "k",
                                    },
                                ];

                                function formatNumber(n) {
                                    for (var i = 0; i < ranges.length; i++) {
                                        if (n >= ranges[i].divider) {
                                            return (
                                                (
                                                    n / ranges[i].divider
                                                ).toString() + ranges[i].suffix
                                            );
                                        }
                                    }
                                    return n;
                                }
                                return formatNumber(value);
                            },
                        },
                        gridLines: {
                            display: true,
                            drawBorder: true,
                            color: "#e1e1e1",
                            zeroLineColor: "#e1e1e1",
                        },
                    },
                ],
            },
            legend: {
                display: false,
            },
            tooltips: {
                enabled: true,
            },
            elements: {},
        };
        var expenseCanvas = $("#expense-bar-chart").get(0).getContext("2d");
        var expenseChart = new Chart(expenseCanvas, {
            type: "bar",
            data: barChartData,
            options: barChartOptions,
        });
    }
    if ($("#student-doughnut-chart").length) {
        var doughnutChartData = {
            labels: ["Female Students", "Male Students"],
            datasets: [
                {
                    backgroundColor: ["#304ffe", "#ffa601"],
                    data: [45000, 105000],
                    label: "Total Students",
                },
            ],
        };
        var doughnutChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 65,
            rotation: -9.4,
            animation: {
                duration: 2000,
            },
            legend: {
                display: false,
            },
            tooltips: {
                enabled: true,
            },
        };
        var studentCanvas = $("#student-doughnut-chart")
            .get(0)
            .getContext("2d");
        var studentChart = new Chart(studentCanvas, {
            type: "doughnut",
            data: doughnutChartData,
            options: doughnutChartOptions,
        });
    }

    if ($.fn.fullCalendar !== undefined) {
        $("#fc-calender").fullCalendar({
            header: {
                center: "basicDay,basicWeek,month",
                left: "title",
                right: "prev,next",
            },
            fixedWeekCount: false,
            navLinks: true,
            editable: true,
            eventLimit: true,
            aspectRatio: 1.8,
            events: [
                {
                    title: "All Day Event",
                    start: "2019-04-01",
                },

                {
                    title: "Meeting",
                    start: "2019-04-12T14:30:00",
                },
                {
                    title: "Happy Hour",
                    start: "2019-04-15T17:30:00",
                },
                {
                    title: "Birthday Party",
                    start: "2019-04-20T07:00:00",
                },
            ],
        });
    }
}
function dataTableScript() {
    if ($.fn.DataTable !== undefined) {
        $(".data-table").DataTable({
            paging: true,
            searching: false,
            info: false,
            lengthChange: false,
            lengthMenu: [20, 50, 75, 100],
            columnDefs: [
                {
                    targets: [0, -1],
                    orderable: false,
                },
            ],
        });
    }
}
function select2Script() {
    if ($.fn.select2 !== undefined) {
        $(".select2").select2({
            width: "100%",
        });
    }
}
</script>
<style scoped>
.school_card {
    margin: auto !important;
    border-radius: 5px;
    box-shadow: 0 0 5px #000;
    padding: 50px;
    width: fit-content;
    margin-bottom: 20px !important;
}

.centered-section {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 40vh;
    margin: 20%;
    width: 50%;
    border: 1px;
    border-radius: 5px;
    box-shadow: 0 .125rem .25rem rgba($black, .075);
}
</style>
