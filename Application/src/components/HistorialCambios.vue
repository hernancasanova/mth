<template>
	<v-container>
		<v-layout row wrap>
				<table id="infocaso" width='50%'>
					<tr class="primary" style="color:white">
						<th colspan="2">Información del Caso</th>
					</tr>
					<tr>
						<td class="bottom-border"><b>Caso</b></td>
						<td class="bottom-border">{{this.datosCaso.nombre_caso}}</td>
					</tr>
					<tr>
						<td class="bottom-border" ><b>Fecha creación</b></td>
						<td class="bottom-border">{{this.datosCaso.fecha_creacion}}</td>
					</tr>
					<tr>
						<td class="bottom-border"><b>Fecha envío</b></td>
						<td class="bottom-border">{{this.datosCaso.fecha_envio}} </td>
					</tr>
					<tr>
						<td class="bottom-border"><b>Fecha recepción</b></td>
						<td class="bottom-border">{{this.datosCaso.fecha_recepcion}}</td>
					</tr>
					<tr>
						<td class="bottom-border"><b>Fecha respuesta final</b></td>
						<td class="bottom-border">{{this.datosCaso.fecha_respuesta_final}}</td>
					</tr>
					<tr>
						<td class="bottom-border"><b>Estado</b></td>
						<td class="bottom-border">{{this.datosCaso.nombre_estado}}</td>
					</tr>
				</table>
			<v-flex xs6>
					<embed id="pdfcaso" :src="this.urlPDF" type="application/pdf" width="92%" height="500px" style="margin-left: 60px" />
					<center><v-label for="pdfcaso" style="margin-left: 70px">Vista previa</v-label></center>
			</v-flex>
		</v-layout>
		<template>		
			<h3>Historial de actualizaciones</h3>
			<!--ALERT PARA EL LISTADO DE LAS ACTUALIZACIONES-->
             <v-alert
                :value="alertListadoActualizaciones"
                type="error"
                transition="scale-transition"
                dismissible:true
              >
                Hubo un problema al buscar las actualizaciones
              </v-alert>
              <v-alert
                :value="alertInformacionCaso"
                type="error"
                transition="scale-transition"
                dismissible:true
              >
                Hubo un problema al buscar información sobre el caso
              </v-alert>
	  <v-data-table
		    :headers="headers"
		    :items="actualizaciones"
		    class="elevation-1"
		  ><template v-slot:items="props">
		      <td>{{ props.item.name }}</td>
		      <td>{{ props.item.fecha_modificacion }}</td>
		      <td>{{ props.item.comentario }}</td>
		      <td>{{ props.item.nombre_estado }}</td>
		      <td><a :href="urlDescAdj">{{ (props.item.archivos_adjuntos) }}</a></td>
		    </template>
		  </v-data-table>
		</template>
	</v-container>
</template>
<script>
	const axios=require('axios');
	export default{
		name:"HistorialCambios",
		data(){
			return{
				alertListadoActualizaciones:false,
				alertInformacionCaso:false,
				Components:{
				},
				urlPDF:'',
				comp:'Historial de cambios',
				headers: [
                  { 
                    text: 'Modificado por',
                    sortable: false,
                    value: 'Modificador', 
                  },
                  { text: 'Fecha modificación', value: 'fecha_modificacion' },
                  { text: 'Comentarios hechos', value: 'comentario' },
                  { text: 'Estado asigando', value: 'estado' },
                  { text: 'Archivos adjuntos', value: 'Archivos_adjuntos', sortable: false }
                ],
				actualizaciones:[],
				datosCaso: [],
				caso_id: this.$route.params.id_caso,
				archivoprinc:0,
				archivos:[],
				urlDescAdj:'',
			}
		},
		mounted(){
			//BUSQUEDA DE LAS ACTUALIZACIONES REALIZADAS A UN CASO
			let uri = this.$store.state.host+'/api/actualizaciones/'+this.caso_id+'?api_token='+this.$store.state.api_token;
            axios.get(uri).then((response) => {
                let res = response.data;
                if (res.status_code == 200) {
                    this.actualizaciones=res.actualizaciones;
                    this.archivoprinc=res.archivoprinc.id;
                    this.urlPDF=this.$store.state.host+'/api/archivos/'+this.archivoprinc+'?api_token='+this.$store.state.api_token;
                    this.urlDescAdj=this.$store.state.host+'/api/archivos/'+this.archivoprinc+'/descargar?api_token='+this.$store.state.api_token;
                    this.alertListadoActualizaciones=false;
                }
                else{
                	this.alertListadoActualizaciones=true;
                }
            });
            //BUSQUEDA DE INFORMACION DEL CASO
            let uri2 = this.$store.state.host+'/api/casos/'+this.caso_id+'?api_token='+this.$store.state.api_token;
            axios.get(uri2)
            .then((response) => {
                let res2 = response.data;
                if (res2.status_code == 200) {
                    this.datosCaso=res2.caso;
                    this.alertInformacionCaso=false;
                }else{
                	this.alertInformacionCaso=true;
                }
            });
		}
	}
</script>
<style type="text/css">
	.bottom-border { border: 1px solid black;padding:3px; }
</style>