<template>
  <div id="app">
    <div id="nav">
      <router-link to="/">Users</router-link>
    </div>

    <UserList
      :users="usersList"
    />
    <router-view :users-fetch="getUsers"/>
  </div>
</template>

<script>
// import Home from './components/Home'
// import About from './components/About'
import UserList from './components/UserList'

export default {
  name: 'App',
  components: {
    UserList
  },
  data() {
    return {
      usersList: []
    };
  },
  computed: {
    getUsers() {
      return this.usersList;
    }
  },
  watch: {
    $route: {
      handler(to, from) {
        const html = document.getElementsByTagName('html')[0];
        const body = document.getElementsByTagName('body')[0];
        if (typeof from !== 'undefined') {
          html.classList.remove(
              'page',
              `page-${from.name.toLowerCase()}`
          );
        }
        html.classList.add('page', `page-${to.name.toLowerCase()}`);
        body.classList.add('page-body');
      },
      immediate: true
    }
  },
  created() {
    this.checkUsers();
  },
  methods: {
    async fetchUsers() {
      const response = await fetch('https://api.canzell.com/__public__/user-service/users');
      const data = await response.json();
      console.log(data);

      return data;
    },
    createUsers(data) {
      return data.map(user => ({
        id: user.id,
        name: user.first_name + ' ' + user.last_name,
        phone: user.phone,
        email: user.email,
        roles: user.roles.join(', '),
        imageLarge: user.mug
      }));
    },
    async setUsers() {
      const data = await this.fetchUsers();
      this.usersList = await this.createUsers(data);
      this.$tools.setLocalStorage('users', this.usersList);
    },
    checkUsers() {
      if (this.$tools.getLocalStorage('users')) {
        this.updatedUsers();
      } else {
        this.setUsers();
      }
    },
    updatedUsers() {
      this.usersList = this.$tools.getLocalStorage('users');
    },
  }
}
</script>

<style>
@import "assets/css/app.css";
@import 'https://use.fontawesome.com/releases/v5.8.2/css/all.css';

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #ffffff;
  margin: 2rem auto 0;
  width: 30%;
}
body {
  background-color: #840202;
}
#nav {
  padding: 1rem;
  margin-bottom: 1rem;
  border-bottom: solid 1px #ffffff;
}
</style>
