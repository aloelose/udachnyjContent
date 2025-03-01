<template>
  <div>
    <router-link to="/" class="link">Home</router-link> |
    <router-link to="/login" class="link">Login</router-link> |
    <router-link to="/register" class="link">Register</router-link> |
    <router-link to="/logout" class="link">Logout</router-link>

    <router-view></router-view>
  </div>
</template>

<style>
.link {
  text-decoration: none;
  color: blue;
}

.link:hover {
  color: green;
}
</style>
