<template>
  <v-system-bar color="lightgrey" 
    style="height:50px;width: calc((100% - 10px) - 60px);top:120px;left:16px;"
    class="rounded"
  >
    <h2 class="pa-1 d-inline" style="margin-right: auto;"> {{ $t('Authorization') }}</h2>
    <v-btn
      icon="mdi-login-variant"
      @click="login"
      style="margin: 0 1%;"
    >    	
    </v-btn>
  </v-system-bar>
  <div style="width:100%; margin-top:65px;"></div>
  <v-text-field 
    type="text"
    :label="$t('Login')"
    ref="name"
    v-model="loginData.name"
  >
  </v-text-field>
  <v-text-field 
    type="password"
    :label="$t('Password')"
    ref="password"
    v-model="loginData.password"
  >
  </v-text-field>
<v-checkbox
    v-model="loginData.remember_me"
    label="Remember"
    color="primary"
    hide-details
  >       	
  </v-checkbox>
</template>

<script>
  export default {
    data() {
      return {
        name: 'Login page',
        showPassword: false, 
        loginData: {
        	name: '',
        	password: '',
        	remember_me: 0 
        }
      }
    },
    mounted() {
    },
    methods: {
      login() {
	    const app = this
        this.$auth.login({
            params: app.loginData, 
            success: function () {},
            error: function () {},
            rememberMe: this.loginData.remember_me,
            redirect: '/home',
            fetchUser: true,
        });
      }
    }
  }
</script>