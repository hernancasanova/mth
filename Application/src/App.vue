<template>
  <v-app>
    <v-content>
      <v-layout>
        <v-flex>
            <Login/>
          <v-navigation-drawer style="background-color: rgb(37,0,39);" width="250" app v-if="this.$store.state.dash">
            <v-toolbar class="sidebar" >
              <v-list>
                <v-list-tile style="background-color: rgb(37,0,39);color:white">
                  Bienvenido: {{this.$store.state.user}} &nbsp;
                </v-avatar-->
                </v-list-tile>
              </v-list>
            </v-toolbar>
            <v-list >
              <v-list-tile >
                <v-list-tile-action>
                  <v-icon style="color:white">list</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                  <v-list-tile-title ><router-link tag="li" to="/ListadoCasos">Listado de casos</router-link></v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>      
              <v-list-tile >
                <v-list-tile-action>
                  <v-icon style="color:white">person_pin</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                  <v-list-tile-title><router-link tag="li" to="/CambiarContrasena">Cambiar contraseña</router-link></v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-list-tile @click="auth_sign_out">
                <v-list-tile-action>
                  <v-icon style="color:white">exit_to_app</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                  <v-list-tile-title style="color:white">Salir</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
            </v-list>
          </v-navigation-drawer>
        </v-flex>
      </v-layout>
    </v-content>
    <v-content>
      <v-container fluid v-if="this.$store.state.dash" >
          <v-flex>
            <router-view></router-view>
          </v-flex>
      </v-container>
    </v-content>
  </v-app>
</template>
<script>
  import Login from './components/Login';
export default {
  name: 'App',
  components: {
    Login,
  },
  data () {
    return {
    }
  },
  mounted(){
      //router.push({name:'ListadoCasos'});
  },
  methods: {
    auth_sign_out () {
      this.$store.commit('account_sign_out');
    }
  }
}
</script>
<style type="text/css">
.sidebar{
  background-color: rgb(37,0,39);
}
li{
  color:white;
}
li:hover{
  cursor:pointer;
}
</style>
