<template>
  <div class="user-profile card flex col-6">
    <div class="header">
      <img src="../assets/img/logo.png" alt="Logo" class="logo">
    </div>
    <div class="card-body">
<!--      @NOTE: image urls are not working-->
<!--      <img-->
<!--          :src="userData.mug"-->
<!--          :alt="userData.name"-->
<!--          class="user-preview__img"-->
<!--      >-->
      <i class="user-profile__img avatar fa fa-user-circle"></i>

      <transition name="fade">
        <div
            class="user-profile__content"
        >
          <h2 class="user-profile__name">
            {{ userData.name }}
          </h2>

          <a :href="'http://127.0.0.1:8000/download-vcf/' + userData.id" class="button-long">
            <i class="fa fa-address-card" aria-hidden="true"></i> Save Contact
          </a>

          <div class="user-profile__description">
            <p>
              <b>Roles:</b> {{ userData.roles }}
            </p>
            <br />
            <a :href="'tel: ' + userData.phone" class="button">
              <i class="fa fa-phone" aria-hidden="true"></i>
            </a>
            <a :href="'mailto: ' + userData.email" class="button">
              <i class="fa fa-envelope" aria-hidden="true"></i>
            </a>
            <br />
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  name: 'UserProfile',
  components: {},
  data: function () {
    return {
      id: this.$route.params.id,
      userData: [],
      loaded: false
    }
  },
  created() {
    const users = this.$tools.getLocalStorage('users');
    this.userData = users.filter(d => d.id === this.id)[0];
  },
  methods: {
    userRemoveEmit(userToRemove) {
      this.$emit('remove', userToRemove);
    }
  },
  watch: {
    userData(newValue) {
      this.userData = newValue;
    }
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.user-profile {
  width: 70%;
  margin: 0 auto;
  color: #000000;
}
p {
  font-size: 12px;
}
.logo {
  width: 80%;
}
img.user-profile__img  {
  width: 10rem;
  height: 10rem;
  border-radius: 100%;
  margin: 0 auto;
}
i.user-profile__img {
  border-radius: 100%;
  font-size: 11rem;
  line-height: 10rem;
  background-color: #ffffff;
}
.user-profile__content {
  width: 100%;
  margin: -3rem auto 0;
  background: #ffffff;
  border-radius: .5rem;
  height: 80%;
  display: block;
  min-height: 500px;
}
.user-profile__name {
  font-weight: 700;
  padding: 3.5rem 0 1rem;
}
.user-profile__description {
  padding-bottom: 5rem;
}
.header img {
  margin: 0 auto;
}
.button {
  color: #ffffff;
  background: #000000;
  font-size: 18px;
  width: 40px;
  height: 40px;
  border-radius: 100%;
  display: inline-block;
  margin: 0 2rem;
  line-height: 40px;
}
.button-long {
  color: #ffffff;
  background: #000000;
  font-size: 18px;
  width: 70%;
  height: 40px;
  border-radius: 10px;
  display: inline-block;
  line-height: 40px;
  margin: 1rem auto 3rem;
}
.button-long i {
  margin-right: 1rem;
}
</style>
