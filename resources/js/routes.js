import Layout from "./components/Layout";
import Dashboard from "./components/Dashboard";

//Resources
import ListResources from "./components/Resources/ListResources";
import EditResource from "./components/Resources/EditResource";
import AddResource from './components/Resources/AddResource';

const router = [
  {
    path: "/",
    component: Layout,
    redirect: "dashboard",
    default: true,
    children: [
      {
        path: "dashboard",
        component: Dashboard,
        default: true
      },
      {
        path: "resources",
        component: ListResources,
        default: true
      }, 
      {
        path: "resources/edit-resource/*",
        component: EditResource,
        default: true
      },
      {
        path: "resources/add",
        component: AddResource,
        default: true
      }
    ]
  }
];

export default router;