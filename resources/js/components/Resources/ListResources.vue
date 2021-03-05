<template>
  <div id="app">
    <div class="card-header font-weight-bold">
      <span style="font-size: 18px">
        <i class="sidenav-icon fas fa-book"></i> List of Resources
      </span>
      <input
        type="button"
        class="btn btn-warning font-weight-bold float-right"
        value="Add"
        @click="AddResource"
      >
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card mb-4">
          <span class="search">
            <i class="sidenav-icon fas fa-search"></i> Search
          </span>
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
    <DataTable
      :header-fields="headerFields"
      :sort-field="sortField"
      :sort="sort"
      :data="data || []"
      :is-loading="isLoading"
      :css="datatableCss"
      not-found-msg="Resource not found"
      @on-update="dtUpdateSort"
      track-by="firstName"
    >
    <img 
      slot="images" 
      slot-scope="props"
      :src="props.rowData.image"
      class="form-control"
    >
      <template slot="actions" slot-scope="props">
        <input
          type="button"
          class="btn btn-info"
          value="Edit"
          @click="editResource(props);"
        >
        <input
          type="button"
          class="btn btn-danger"
          value="Delete"
          @click="deleteResource(props);"
        >
      </template>
      <div slot="image" slot-scope="props">
          <img 
            :src="filePath + props.rowData.image"
            class="image"
          />
      </div>
      <template v-slot:pagination>
        <Pagination
          :page="currentPage"
          :total-items="totalItems"
          :items-per-page="itemsPerPage"
          :css="paginationCss"
          @on-update="changePage"
          @update-current-page="updateCurrentPage"
        />
      </template>

      <div class="items-per-page" slot="ItemsPerPage">
        <label>Resources per page</label>
        <ItemsPerPageDropdown
          :list-items-per-page="listItemsPerPage"
          :items-per-page="itemsPerPage"
          :css="itemsPerPageCss"
          @on-update="updateItemsPerPage"
        />
      </div>

      <!-- Spinner element as slot used when is-loading attribute is true -->
      <Spinner slot="spinner"/>
      
    </DataTable>
  </div>
</template>


<script>
import notification from "./../../mixins/notify";
import Spinner from "vue-simple-spinner";
import { DataTable, ItemsPerPageDropdown, Pagination } from "v-datatable-light";
import orderBy from "lodash.orderby";
import config from "./../../config";

export default {
  mixins: [notification],
  name: "app",
  components: {
    DataTable,
    ItemsPerPageDropdown,
    Pagination,
    Spinner
  },
  data: function() {
    return {
      headerFields: [
        {
          name: "name",
          label: "Name",
          sortable: true
        },
        {
          name: "image",
          label: "Image",
          customElement: "image"
        },
        "__slot:actions"
      ],
      data: [],
      initialData: [],
      datatableCss: {
        table: "table table-bordered table-hover table-striped table-center",
        theadTh: "header-item",
        thWrapper: "th-wrapper",
        thWrapperCheckboxes: "th-wrapper checkboxes",
        arrowsWrapper: "arrows-wrapper",
        arrowUp: "arrow up",
        arrowDown: "arrow down",
        footer: "footer"
      },
      paginationCss: {
        paginationItem: "pagination-item",
        moveFirstPage: "move-first-page",
        movePreviousPage: "move-previous-page",
        moveNextPage: "move-next-page",
        moveLastPage: "move-last-page",
        pageBtn: "page-btn"
      },
      itemsPerPageCss: {
        select: "item-per-page-dropdown"
      },
      isLoading: false,
      sort: "asc",
      sortField: "firstName",
      listItemsPerPage: [5, 10, 20, 50, 100],
      itemsPerPage: 10,
      currentPage: 1,
      createHeaderName: "created:header",
      totalItems: 0,
      name: '',
      filePath: config.fileUploadPath
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
            let data = Object.entries(response.data.resources);
            console.log(typeof data);

            this.data = response.data.resources.slice(0, 10);
            this.initialData = response.data.resources;
            this.totalItems = response.data.resources.length;
            console.log(this.data)
          }
        })
        .catch(error => {
          console.log(error);
        });
    },

    AddResource() {
      const path = `/resources/add`;
      if (this.$router.path !== path) this.$router.push(path);
    },

    editResource: function(props) {
      let id = props.rowData.id;
      const path = `/resources/edit-resource/${id}`;
      if (this.$router.path !== path) this.$router.push(path);
    },

    deleteResource(props) {
      let id = props.rowData.id;
      const payLoad = {
        id: id
      };
      let that = this;
      axios
        .post("api/resource/delete", payLoad)
        .then(response => {
          if (response.data.status) {
            that.success(response.data.msg);
            that.data = response.data.resource.slice(0, 10);
            that.initialData = response.data.resource;
            that.totalItems = response.data.resource.length;
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } else {
            that.error(response.data.msg);
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
    },

    dtEditClick: props => alert("Click props:" + JSON.stringify(props)),

    dtUpdateSort: function({ sortField, sort }) {
      const sortedData = orderBy(this.initialData, [sortField], [sort]);
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = this.currentPage * this.itemsPerPage;
      this.data = sortedData.slice(start, end);
    },

    updateItemsPerPage: function(itemsPerPage) {
      itemsPerPage = parseInt(itemsPerPage);
      this.itemsPerPage = itemsPerPage;
      if (itemsPerPage >= this.initialData.length) {
        this.data = this.initialData;
      } else {
        this.data = this.initialData.slice(0, itemsPerPage);
      }
    },

    changePage: function(currentPage) {
      this.currentPage = currentPage;
      const start = (currentPage - 1) * this.itemsPerPage;
      const end = currentPage * this.itemsPerPage;
      this.data = this.initialData.slice(start, end);
    },

    updateCurrentPage: function(currentPage) {
      this.currentPage = currentPage;
    },

    actionFirstClick: params => {
      alert(JSON.stringify(params));
    }
  }
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

#app .title {
  margin-bottom: 30px;
}

#app .items-per-page {
  height: 100%;
  display: flex;
  align-items: center;
  color: #337ab7;
}

#app .items-per-page label {
  margin: 0 5px 0 0;
}

/* Datatable CSS */
.v-datatable-light .header-item {
  cursor: pointer;
  color: #337ab7;
  transition: color 0.15s ease-in-out;
}

.v-datatable-light .header-item:hover {
  color: #ed9b19;
}

.v-datatable-light .header-item.no-sortable {
  cursor: default;
}
.v-datatable-light .header-item.no-sortable:hover {
  color: #337ab7;
}

.v-datatable-light .header-item .th-wrapper {
  display: flex;
  width: 100%;
  height: 100%;
  font-weight: bold;
  align-items: baseline;
}

.v-datatable-light .header-item .th-wrapper.checkboxes {
  justify-content: center;
}

.v-datatable-light .header-item .th-wrapper .arrows-wrapper {
  display: flex;
  flex-direction: column;
  margin-left: 10px;
  justify-content: space-between;
}

.v-datatable-light .header-item .th-wrapper .arrows-wrapper.centralized {
  justify-content: center;
}

.v-datatable-light .arrow {
  transition: color 0.15s ease-in-out;
  width: 0;
  height: 0;
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
}

.v-datatable-light .arrow.up {
  border-bottom: 8px solid #337ab7;
  margin-bottom: 5px;
}

.v-datatable-light .arrow.up:hover {
  border-bottom: 8px solid #ed9b19;
}

.v-datatable-light .arrow.down {
  border-top: 8px solid #337ab7;
}

.v-datatable-light .arrow.down:hover {
  border-top: 8px solid #ed9b19;
}

#app .v-datatable-light .row-7 .column-4 {
  color: steelblue;
}

#app .v-datatable-light .row-1 .column-2 {
  color: green;
}

/* #app .v-datatable-light .row-2 .column-1 {
  color: red;
} */
/* 
#app .v-datatable-light .row-3 {
  color: pink;
} */

#app .v-datatable-light .column-5 {
  color: goldenrod;
}

#app .v-datatable-light .row-3 .column-5 {
  color: purple;
}

.v-datatable-light .footer {
  display: flex;
  justify-content: space-between;
  width: 500px;
}
/* End Datatable CSS */

/* Pagination CSS */
.v-datatable-light-pagination {
  list-style: none;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  margin: 0;
  padding: 0;
  width: 300px;
  height: 30px;
}

.v-datatable-light-pagination .pagination-item {
  width: 30px;
  margin-right: 5px;
  font-size: 16px;
  transition: color 0.15s ease-in-out;
}

.v-datatable-light-pagination .pagination-item.selected {
  color: #ed9b19;
}

.v-datatable-light-pagination .pagination-item .page-btn {
  background-color: transparent;
  outline: none;
  border: none;
  color: #337ab7;
  transition: color 0.15s ease-in-out;
}

.v-datatable-light-pagination .pagination-item .page-btn:hover {
  color: #ed9b19;
}

.v-datatable-light-pagination .pagination-item .page-btn:disabled {
  cursor: not-allowed;
  box-shadow: none;
  opacity: 0.65;
}
/* END PAGINATION CSS */

/* ITEMS PER PAGE DROPDOWN CSS */
.item-per-page-dropdown {
  background-color: transparent;
  min-height: 30px;
  border: 1px solid #337ab7;
  border-radius: 5px;
  color: #337ab7;
}
.item-per-page-dropdown:hover {
  cursor: pointer;
}
.image {
  height: 50px;
  width: 50px;
}
.search {
  font-size: 14px;
  margin-top: 20px;
  font-weight: 600;
}

/* END ITEMS PER PAGE DROPDOWN CSS */
</style>