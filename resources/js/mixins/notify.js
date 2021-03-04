export default {
  methods: {
    error(msg) {
      toastr["error"](msg, "Error", {
        positionClass: "toast-top-right",
        progressBar: true,
        newestOnTop: true
      });
    },
    success(msg) {
      toastr["success"](msg, "Success", {
        positionClass: "toast-top-right",
        progressBar: true,
        newestOnTop: true
      });
    }
  }
};
