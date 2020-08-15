<template>
  <div id="app">
    <!-- <div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link>
    </div> -->
    
    <vk-navbar>
      <vk-navbar-nav>
        <vk-navbar-nav-item title="Active"></vk-navbar-nav-item>
        <vk-navbar-nav-dropdown title="Parent">
          <vk-navbar-nav-dropdown-nav>
            <vk-nav-item title="About" active></vk-nav-item>
            <vk-nav-item title="Item"></vk-nav-item>
            <vk-nav-item title="Item"></vk-nav-item>
          </vk-navbar-nav-dropdown-nav>
        </vk-navbar-nav-dropdown>
        <vk-navbar-nav-item title="Item"></vk-navbar-nav-item>
      </vk-navbar-nav>
    </vk-navbar>

    <router-view/>
  </div>
</template>

<style>
#app {
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
}
</style>
