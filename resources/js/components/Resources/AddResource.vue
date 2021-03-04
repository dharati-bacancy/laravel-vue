<template>
  <div class="row">
    <div class="col-sm-12">
      <div class="card mb-4">
        <h4 class="card-header">Add Resource</h4>
        <div class="card-body">
          <ValidationObserver ref="observer" v-slot="{ invalid }" tag="form" @submit.prevent="addResource()">
            <!-- <form method="POST" @submit.prevent="addResource"> -->
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label">Name *</label>
                            <validation-provider
                            name="Name"
                            rules="required"
                            v-slot="{ errors }"
                            >
                            <input
                                :class="[errors[0] ? 'form-control-red' : '']"
                                type="text"
                                class="form-control mb-1"
                                v-model="name"
                            />
                            <small
                                :class="[errors[0] ? 'text-danger' : 'text-muted']"
                                class="font-weight-bold"
                                style="font-size: 11px"
                                >{{ errors[0] ? errors[0] : "Enter Name" }}</small
                            >
                            </validation-provider>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Image *</label>
                            <validation-provider
                            name="Image"
                            v-slot="{ errors }"
                            >
                            <input
                                :class="[errors[0] ? 'form-control-red' : '']"
                                type="file"
                                class="form-control mb-1"
                            />
                            <small
                                :class="[errors[0] ? 'text-danger' : 'text-muted']"
                                class="font-weight-bold"
                                style="font-size: 11px"
                                >{{ errors[0] ? errors[0] : "Choose image" }}</small
                            >
                            </validation-provider>
                        </div>
                    </div>
                </div>
                <button
                    type="submit"
                    class="btn btn-sm btn-success font-weight-bold mt-2"
                >
                    Add
                </button>
                <router-link
                    to="/resources"
                    class="btn btn-sm btn-secondary mt-2"
                    >Cancel</router-link
                >
            <!-- </form> -->
          </ValidationObserver>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import notification from "./../../mixins/notify";

export default {
  mixins: [notification],
  data() {
    return {
      name: "",
    };
  },
  methods: {
    async addResource() {
        const valid = await this.$refs.observer.validate();
        if(valid) {
            const payLoad = {
                name: this.name,
            };
            axios
                .post("/api/resource/store", payLoad)
                .then(response => {
                if (response.data.status == 1) {
                    this.success(response.data.msg);
                    this.$router.push("/resources");
                }
                if (response.data.status != 1) {
                    this.error(response.data.msg);
                }
                })
                .catch(error => {
                this.error(error);
                });
        }
    }
  }
};
</script>

<style scoped>
.form-control-red {
  border: 1px solid red !important;
}
.mx-input {
  border: 1px solid rgba(24, 28, 33, 0.1) !important;
  height: 37px !important;
}
</style>