import Vue from 'vue'
import Vuex from 'vuex'
import Router from 'vue-router'
import router from './router'
const axios=require('axios');
Vue.use(Vuex)
Vue.use(Router)
export default new Vuex.Store({
  state: {
    auth_login: true,
    host: 'http://mth.sistematiza.cl',
    //host: 'http://localhost:8000',
    user:'',
    password:'',
    remeber_login: false,
    dash:false,
    api_token:'',
    user_id:0,
    alert:false,
    usuario:'',
    constrasena:''
  },
  mutations: {
    account_sign_in (state, params) {
      let uri = state.host+'/api/login';//cambiar username por usuario
      axios.post(uri,{email:params.usuario,password:params.contrasena}).then((response) => {
            let res = response.data;
            if (res.status_code == 200) {
                state.api_token=res.api_token;
                router.push({name:'ListadoCasos'});
                //router.push({name:'home'});
                state.auth_login=false;//oculta el v-dialog
                state.dash=true;
                state.user=res.user;
                state.password=res.password;
                state.user_id=res.user_id;
            }else{
              state.alert=true;
              //alert('usuario y contraseña INCORRECTOS');
              //console.log('error en autenticación');
            }
        });
        /*.catch(
          //let res=error.data;
            console.log('Combinación de usuario y contraseña incorrectos');
            state.auth_login=false;
        );*/
      /*console.log('Store sign in');
      if ((state.usuario==params.usuario) && (state.contraseña==params.contraseña)) {
        console.log("USUARIO y CONTRASEÑA CORRECTOS");
        router.push({name:'ListadoCasos'});
        state.auth_login=true;
        state.dash=true;
      }else{
        console.log("USUARIO Y CONTRASEÑA INCORRECTOS");
        state.auth_login=false;
      }*/
    },
    account_sign_out (state) {
      let uri = state.host+'/api/logout';//cambiar username por usuario
      axios.post(uri,{api_token:state.api_token}).then((response) => {
            let res = response.data;
            if (res.status_code == 200) {
              console.log('deslogueado');
              state.user='';
              state.usuario='';
              state.contrasena='';
              state.password='';
              state.auth_login = true;
              state.alert=false;
              if (state.dash) {
                state.dash=false;
              }
            }
        });/*.catch(error => {
            console.log(res.logout);
            state.auth_login=false;
        
        });*/
    },
  },
  actions: {
  }
})
