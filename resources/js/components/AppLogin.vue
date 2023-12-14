<template>
  <v-system-bar color="lightgrey" 
    style="height:50px;width: calc((100% - 10px) - 22px);top:120px;left:16px;"
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
    :error-messages="errors.login"
  >
  </v-text-field>
  <v-text-field 
    :type="showPassword ? 'text' : 'password'"
    :label="$t('Password')"
    ref="password"
    v-model="loginData.password"
    :append-inner-icon="showPassword ? 'mdi-eye-outline' : 'mdi-eye-off-outline'"
    @click:append-inner="showPassword=!showPassword"
    :error-messages="errors.login"
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
        },
        errors: {}
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
            error: function (e) {
              console.log(e)
            },
            rememberMe: this.loginData.remember_me,
            redirect: '/',
            fetchUser: true,
        }).catch(e => {
          console.log(e)
          if(typeof(e.response) === 'object' && typeof(e.response.data) === 'object') {
            this.errors = e.response.data;
          }
        });
      }
    }
  }
</script>