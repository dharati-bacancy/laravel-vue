<template>
  <div>
    <div class="row">
      <div class="col-sm-6 col-xl-3">
        <div class="card mb-4">
          <router-link
            to="/resources"
            class="sidenav-link"
            style="text-decoration:none; color:#555555;"
          >
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="lnr lnr-book display-4 text-success"></div>
                <div class="ml-3">
                  <div class="text-muted small font-weight-bold">Resources</div>
                  <div class="text-large">
                    <strong>{{ dashboard.resources }}</strong>
                  </div>
                </div>
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dashboard: {
        resources: "",
      }
    };
  },
  mounted() {
    this.getWidgets();
  },
  methods: {
    getWidgets() {
      axios
        .get("/api/widgets")
        .then(response => {
          this.dashboard = response.data;
        })
        .catch(error => {});
    }
  }
};
</script>