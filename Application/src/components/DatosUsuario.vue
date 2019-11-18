<template>
	<v-layout align-center >
		<v-flex xs12 sm6 offset-sm3>
	      <v-card>
	        <v-card-title>
	          <div>
	            <span class="grey--text">Datos de usuario</span><br>
	            <span>Nombre de usuario: </span>{{NombreUsuario}}<br>
	            <span>Contraseña:  </span>******* 
	          </div>
	        </v-card-title>
	        <v-card-actions>
	           <v-btn color="warning"><router-link to="/CambiarContraseña">Cambiar contraseña</router-link></v-btn>
	        </v-card-actions>
	      </v-card>
	    </v-flex>
  </v-layout>
</template>
<script>
	export default{
		name:"DatosUsuario",
		data(){
			return{
				comp:'DatosUsuario',
				NombreUsuario: 'hernan'
			}
		}
	}
</script>