<template>
  <div class="card">
    <div class="card-header font-weight-bold">
      <span style="font-size: 18px">
        <i class="sidenav-icon fas fa-book"></i> List of Resources
      </span>
      <router-link
        to="/resources/add"
        class="btn btn-sm btn-warning font-weight-bold float-right"
      >
        <i class="fas fa-plus"></i> ADD
      </router-link>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card mb-4">
          <h6 class="card-header">Search</h6>
          <div class="card-body">
            <form method="GET" v-on:submit.prevent="search">
              <label>Name</label>
              <input type="text" v-model="name"/>
              <button type="submit" class="btn btn-sm btn-success font-weight-bold"> Search
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
              

    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Image</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(resource, index) in resources" :key="index">
          <td>{{ index + 1 }}</td>
          <td>{{ resource.name }}</td>
          <td><img :src="filePath + resource.image" class="img"></td>
          <td>
            <i
              style="cursor:pointer;"
              @click="editResource(resource.id)"
              class="far fa-edit text-success mr-1"
            ></i>
            <i
              style="cursor:pointer;"
              @click="deleteResource(resource.id)"
              class="far fa-trash-alt text-danger ml-1"
            ></i>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import notification from "./../../mixins/notify";
import config from "./../../config";

export default {
  mixins: [notification],
  data() {
    return {
      resources: {},
      name: '',
      filePath: config.fileUploadPath,
    };
  },
  mounted() {
    this.getResource();
  },
  methods: {
    getResource() {
      let param = '';
      let name = this.$route.query.name;
      if(name) {
        param = '?name='+this.$route.query.name;
      }
      this.name = this.$route.query.name;
      axios
        .get("api/resource/index"+param)
        .then(response => {
          if (response.data.status) {
            this.resources = response.data.resources;
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    editResource(id) {
      const path = `/resources/edit-resource/${id}`;
      if (this.$router.path !== path) this.$router.push(path);
    },
    deleteResource(id) {
      const payLoad = {
        id: id
      };

      axios
        .post("api/resource/delete", payLoad)
        .then(response => {
          if (response.data.status) {
            this.success(response.data.msg);
            this.resources = response.data.resources;
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } else {
            this.error(response.data.msg);
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    search() {
      let name = this.name;
      const path = `/resources?name=`+this.name;
      this.$router.push(path);
      window.location.reload();
    }
  },
  computed: {
  }
};
</script>

<style scoped>
.img {
  height: 50px;
  width: 50px;
}
</style>