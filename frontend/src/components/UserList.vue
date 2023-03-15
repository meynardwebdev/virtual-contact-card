<template>
  <div class="user-list__wrapper page-inner">
    <transition-group
        v-if="$route.name === 'users'"
        tag="ul"
        name="slide"
        class="user-list"
        :class="{ 'is-hidden-info': stateHidden }"
    >
      <li
          v-for="(user, key) in usersList"
          :key="key"
          class="user-list__item"
      >
        <router-link :to="{ name: 'userprofile', params: { id: user.id }}">{{user.name}}</router-link>
      </li>
    </transition-group>
  </div>
</template>

<script>
export default {
  name: 'UsersList',
  props: {
    users: Array,
    stateHidden: Boolean
  },
  data() {
    return {
      usersList: this.users
    };
  },
  watch: {
    users(newValue) {
      this.usersList = newValue;
    }
  },
  methods: {
    userRemove(userToRemove) {
      this.usersList.splice(this.usersList.indexOf(userToRemove), 1);
      this.$tools.setLocalStorage('users', this.usersList);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
