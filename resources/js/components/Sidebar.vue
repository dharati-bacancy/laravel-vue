<template>
  <div
    id="layout-sidenav"
    class="layout-sidenav sidenav sidenav-vertical bg-dark"
  >
    <!-- Brand demo (see assets/css/demo/demo.css) -->
    <div class="app-brand demo px-4 py-3">
      <span class="app-brand-text demo sidenav-text font-weight-normal ml-3"
        >Demo
      </span>
    </div>

    <div class="sidenav-divider mt-0"></div>

    <!-- Links -->
    <ul class="sidenav-inner py-1 pb-5">
      <li class="sidenav-header small font-weight-semibold">MAIN</li>

      <li
        :class="[currentPage.includes('dashboard') ? activeClass : '']"
        class="sidenav-item"
      >
        <router-link
          to="/dashboard"
          class="sidenav-link"
          style="text-decoration: none"
        >
          <i class="sidenav-icon fab fa-dashcube"></i>
          <div>Dashboard</div>
        </router-link>
      </li>

      <li
        :class="[currentPage.includes('resources') ? activeClass : '']"
        class="sidenav-item"
      >
        <router-link
          to="/resources"
          class="sidenav-link"
          style="text-decoration: none"
        >
          <i class="sidenav-icon fab fa-dashcube"></i>
          <div>Resources</div>
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      activeClass: "active",
      appLogo: "favicon.ico"
    };
  },
  computed: {
    currentPage() {
      return this.$route.path;
    }
  }
};
</script>