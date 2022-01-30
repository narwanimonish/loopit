<template>
  <div class="container mt-5 px-lg-5">
    <router-link class="nav-link" :to="{ name: 'Login' }"> Login </router-link>
    <router-link class="nav-link" :to="{ name: 'Register' }">
      Register
    </router-link>
    <router-view />
  </div>
</template>

<style>
/* #app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
} */

@import '~bootstrap/dist/css/bootstrap.css';
</style>
