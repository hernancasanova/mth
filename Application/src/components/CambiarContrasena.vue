<template>
	<v-layout align-center >
		<v-flex xs12 sm3 offset-sm3 lg4>
		<!--v-flex xs12 sm6 offset-sm3-->
	      <v-card>
	        <v-card-title>
	          <div>
	            <span class="grey--text">Ingrese la contraseña actual</span><br>
	            <v-text-field
	            v-model="contrasenaActual"
            	type="password"
         		></v-text-field>
         		<span class="grey--text">Ingrese la contraseña nueva</span><br>
	            <v-text-field
	            type="password"
	            v-model="contrasenaNueva"
         		></v-text-field>
         		<span class="grey--text">Confirme la contraseña nueva</span><br>
	            <v-text-field
	            type="password"
            	v-model="contrasenaNueva2"
         		></v-text-field>
	          </div>
	        </v-card-title>
	        <v-card-actions>
	           <v-btn color="success" @click="cambiarContraseña()">Cambiar contraseña</v-btn>
	           <v-btn color="warning" @click="cancelar()">Cancelar</v-btn>
	        </v-card-actions>
	      </v-card>
	       <!--ALERT PARA ACTUALIZACION DE CONTRASENA-->
                     <v-alert
                        :value="alertCambioContrasena"
                        type="error"
                        transition="scale-transition"
                        dismissible:true
                      >
                        Las contraseñas ingresadas no coinciden y/o su nueva contraseña no pueda ser igual a la que desea reemplazar
                      </v-alert>
	    </v-flex>
  </v-layout>
</template>
<script>
	const axios=require('axios');
    import router from '../router'
	export default{
		name:"DatosUsuario",
		data(){
			return{
				comp:'DatosUsuario',
				contrasenaActual:'',
				contrasenaNueva:'',
				contrasenaNueva2:'',
				alertCambioContrasena:false
			}
		},
		methods:{
			cambiarContraseña(){
				let formData=new FormData();
				let uri = this.$store.state.host+'/api/users/'+this.$store.state.user;
				//let uri = this.$store.state.host+`/api/cambiarContrasena?contrasenaActual=${this.contrasenaActual}&contrasenaNueva=${this.contrasenaNueva}&api_token=${this.$store.state.api_token}`;
				formData.append('contrasenaActual',this.contrasenaActual);
                formData.append('contrasenaNueva',this.contrasenaNueva);
                formData.append('api_token',this.$store.state.api_token);
                formData.append('_method','PUT');
				axios.post(uri,formData).then((response) => {//,formData,{headers:{'Content-Type':'multipart/form-data'}}).then((response) => {
                      let res = response.data;
                      if (res.status_code == 200) {
                           router.push({name:'ListadoCasos'});
                           this.alertCambioContrasena=false;
                      }
                      else{
                      	this.alertCambioContrasena=true;
                      }
                  });
			},
			cancelar(){
				router.push({name:'ListadoCasos'});
			}
		}
	}
</script>