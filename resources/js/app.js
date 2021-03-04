require("./bootstrap");

window.Vue = require("vue");

import Vue from "vue";
import App from "./App";
import VueRouter from "vue-router";
import routes from "./routes";
import Axios from "axios";
import config from "./config";
import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
import * as rules from "vee-validate/dist/rules";
import {
  messages
} from "vee-validate/dist/locale/en.json";

Object.keys(rules).forEach(rule => {
  extend(rule, {
    ...rules[rule], // copies rule configuration
    message: messages[rule] // assign message
  });
});

const service = Axios.create({
  baseURL: config.baseUrl
});

window.axios = service;

Vue.use(VueRouter);
Vue.component("ValidationProvider", ValidationProvider);
Vue.component("ValidationObserver", ValidationObserver);

const scrollBehavior = function () {
  return {
    x: 0,
    y: 0
  }
}

const router = new VueRouter({
  base: config.basePath,
  scrollBehavior,
  routes,
  mode: "history"
});

router.beforeEach((to, from, next) => {
  next(); // does not require auth, make sure to always call next()!
});


Vue.config.devtools = true;

const app = new Vue({
  el: "#app",
  router,
  render: h => h(App)
});
