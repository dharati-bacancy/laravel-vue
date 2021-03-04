<template>
  <div class="row">
    <div class="col-sm-12">
      <div class="card mb-4">
        <h4 class="card-header">Edit Resource</h4>
        <div class="card-body">
        <ValidationObserver v-slot="{ invalid }">
            <form method="POST" v-on:submit.prevent="updateResource" id="form">
                <div class="form-group">
                    <label for="name"><b>Name</b></label>
                    <validation-provider
                        name="Name"
                        rules="required"
                        v-slot="{ errors }"
                    >
                    <input 
                        type="text" 
                        placeholder="Enter Name" 
                        v-model="name" 
                        :class="[errors[0] ? 'form-control-red' : '']"
                    />
                    <small
                        class="text-danger font-weight-bold"
                        style="font-size: 11px">
                        {{ errors[0] }}
                    </small>
                    </validation-provider>
                </div>
                <div class="form-group">
                    <label for="name"><b>Image</b></label>
                    <validation-provider
                        name="Name"
                        rules="required"
                        v-slot="{ errors }"
                    >
                    <input 
                        type="file" 
                        placeholder="Enter Name" 
                        :class="[errors[0] ? 'form-control-red' : '']"
                    />
                    <img
                    :src="image"
                    class="img"
                    >
                    <small
                        class="text-danger font-weight-bold"
                        style="font-size: 11px">
                        {{ errors[0] }}
                    </small>
                    </validation-provider>
                </div>
                <div class="clearfix">
                    <button 
                        type="submit" 
                        class="signupbtn"
                        :disabled="invalid" 
                        >
                        <strong>Update</strong>
                    </button>
                </div>
            </form>
        </ValidationObserver>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import notification from "./../../mixins/notify";
import config from "./../../config";

export default {
    mixins: [notification],
    data() {
        return {
            id: this.$route.params.pathMatch,
            name: '',
            image: '',
        };
    },
    mounted() {
        this.resourceDetails();
    },
    methods: {
        resourceDetails() {
            const payLoad = {
                resource_id: this.id
            };
            let param = this.id;
            
            axios
            .get("api/resource/edit/"+param)
            .then(response => {
                if (response.data.status) {
                    this.name = response.data.resource.name;
                    this.image = config.fileUploadPath + response.data.resource.image;
                } else {
                    console.log(response)
                }
            })
            .catch(error => {
            console.log(error);
            });
        },

        updateResource() {
            const payLoad = {
                id: this.id,
                name: this.name
            };
            axios
            .post("api/resource/update", payLoad)
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
.img {
    height: 100px;
    width: 100px;
}
</style>