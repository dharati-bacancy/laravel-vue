<template>
  <div class="layout-wrapper layout-2">
    <div class="layout-inner">
      <side-bar></side-bar>

      <!-- Layout container -->
      <div class="layout-container">
        <div class="layout-content">
          <div class="container-fluid flex-grow-1 container-p-y">
            <router-view></router-view>
          </div>
        </div>
      </div>
      <!-- / Layout container -->
    </div>
  </div>
</template>

<script>
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";
import notification from "./../mixins/notify";

export default {
  mixins: [notification],
  components: {
    "nav-bar": Navbar,
    "side-bar": Sidebar
  },
  methods: {
  }
};
</script>