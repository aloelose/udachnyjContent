/* eslint-disable no-unused-vars */
import { defineRouter } from "#q-app/wrappers";
import {
  createRouter,
  createMemoryHistory,
  createWebHistory,
  createWebHashHistory,
} from "vue-router";
import routes from "./routes";

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Router instance.
 */

export default defineRouter(function (/* { store, ssrContext } */) {
  const createHistory = process.env.SERVER
    ? createMemoryHistory
    : process.env.VUE_ROUTER_MODE === "history"
    ? createWebHistory
    : createWebHashHistory;

  const Router = createRouter({
    scrollBehavior: (to, from, savedPosition) => {
      if (to.hash) {
        return {
          el: to.hash,
          top: 0, // offset by X pixels
          behavior: "smooth",
        };
      }
      return { left: 0, top: 0 };
    },
    routes,
    history: createHistory(process.env.VUE_ROUTER_BASE),
  });
  // Это редирект, если неавторизованный пользователь пытается зайти на lk
  Router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("authToken");
    if (to.path.startsWith("/lk") && !token) {
      return next({ name: "LandingPage" });
    }
    next();
  });

  // Этот код убирает хещ-ссылку при перезагрузке страницы
  Router.beforeEach((to, from, next) => {
    if (!from.name && to.hash) {
      // Detect initial page load with hash
      const cleanRoute = {
        path: to.path,
        query: to.query,
        hash: undefined,
      };
      return next(cleanRoute);
    }
    next();
  });

  // const Router = createRouter({
  //   scrollBehavior: () => ({ left: 0, top: 0 }),
  //   routes,

  //   // Leave this as is and make changes in quasar.conf.js instead!
  //   // quasar.conf.js -> build -> vueRouterMode
  //   // quasar.conf.js -> build -> publicPath
  //   history: createHistory(process.env.VUE_ROUTER_BASE),
  // });

  return Router;
});
