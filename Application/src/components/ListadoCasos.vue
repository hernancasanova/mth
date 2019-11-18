<template>
    <!--v-dialog v-model="!this.$store.state.auth_login" persistent max-width="600px">  
    </v-dialog-->
        <!--v-contanier grid-list-md text-xs-center-->
    <div >
        <h3>Filtrar por: </h3>  
                <v-flex xs12 fluid>
                    <v-layout row wrap>
                        <v-flex xs2>
                            Caso:
                                <v-flex>
                                  <v-text-field
                                    v-model="SelectCaso"
                                    placeholder="Ej: R2019M3291914"
                                  ></v-text-field>
                              </v-flex>
                        </v-flex>
                        <v-flex xs2 >
                            Empresa: 
                                <v-select
                                  :items="Empresas"
                                  item-text='nombre_empresa'
                                  item-value='id'
                                  v-model="SelectEmpresa"
                                ></v-select>
                        </v-flex>
                        <v-flex xs2>
                            Estado:
                                <v-select
                                  :items="Estados"
                                  item-text='nombre_estado'
                                  item-value='id'
                                  v-model="SelectEstado"
                                ></v-select>
                        </v-flex>
                        <v-flex xs6>
                            <v-layout row wrap>
                                <v-flex xs4>
                                Fecha de creación inicio: 
                                    <v-menu
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                                  >
                                    <template v-slot:activator="{ on }">
                                      <v-text-field
                                        v-model="fecha_inicio_creacion"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="fecha_inicio_creacion" @input="menu = false" locale="es-es"></v-date-picker>
                                  </v-menu>
                                </v-flex>
                                <v-flex xs4>
                                Fecha de creación fin:
                                  <v-menu
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                                  >
                                    <template v-slot:activator="{ on }">
                                      <v-text-field
                                        v-model="fecha_fin_creacion"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="fecha_fin_creacion" @input="menu2 = false" locale="es-es"></v-date-picker>
                                  </v-menu>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <!--SEGUNDA FILA DE FILTROS-->
                <v-flex xs12 lg12>
                    <v-layout row wrap>
                       <v-flex xs4>
                           <v-layout row wrap>
                                <v-flex xs6>
                                Fecha de envío inicio: 
                                    <v-menu
                                    v-model="menu3"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                                    >
                                    <template v-slot:activator="{ on }">
                                      <v-text-field
                                        v-model="fecha_inicio_envio"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="fecha_inicio_envio" @input="menu3 = false" locale="es-es"></v-date-picker>
                                    </v-menu>
                                </v-flex>
                                <v-flex xs6>
                                Fecha de envío fin:
                                  <v-menu
                                    v-model="menu4"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                                  >
                                    <template v-slot:activator="{ on }">
                                      <v-text-field
                                        v-model="fecha_fin_envio"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="fecha_fin_envio" @input="menu4 = false" locale="es-es"></v-date-picker>
                                  </v-menu>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex xs4>
                            <v-layout row wrap>
                                <v-flex xs6>
                                Fecha de recepción inicio: 
                                    <v-menu
                                    v-model="menu5"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                                  >
                                    <template v-slot:activator="{ on }">
                                      <v-text-field
                                        v-model="fecha_inicio_recepcion"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="fecha_inicio_recepcion" @input="menu5 = false" locale="es-es"></v-date-picker>
                                  </v-menu>
                                </v-flex>
                                <v-flex xs6> 
                                Fecha de recepción fin:
                                  <v-menu
                                    v-model="menu6"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                                  >
                                    <template v-slot:activator="{ on }">
                                      <v-text-field
                                        v-model="fecha_fin_recepcion"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="fecha_fin_recepcion" @input="menu6 = false" locale="es-es"></v-date-picker>
                                  </v-menu>
                                </v-flex>
                            </v-layout>
                        </v-flex>        
                        <v-flex xs4>
                            <v-layout row wrap xs2>
                                <v-flex xs6>
                                Fecha respuesta final inicio: 
                                    <v-menu
                                    v-model="menu7"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                                  >
                                    <template v-slot:activator="{ on }">
                                      <v-text-field
                                        v-model="fecha_inicio_respuesta_final"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="fecha_inicio_respuesta_final" @input="menu7 = false" locale="es-es"></v-date-picker>
                                  </v-menu>
                                </v-flex>
                                <v-flex xs6> 
                                Fecha de respuesta final fin:
                                  <v-menu
                                    v-model="menu8"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                                  >
                                    <template v-slot:activator="{ on }">
                                      <v-text-field
                                        v-model="fecha_fin_respuesta_final"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="fecha_fin_respuesta_final" @input="menu8 = false" locale="es-es"></v-date-picker>
                                  </v-menu>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <v-flex xs12>
                    <v-btn color="primary" class="mt-20" right @click="buscarCasos">Buscar casos</v-btn><br><br>
                </v-flex>
                
            <!--DIALOG DE ACTUALIZAR CASO-->
                <template>
                    <v-toolbar flat color="white" fluid>
                      <v-dialog v-model="dialog" max-width="500px">
                        <v-card>
                          <v-card-title>
                            <span class="headline">Actualizar caso</span>
                          </v-card-title>
                          <v-card-text>
                            <v-container grid-list-md>
                              <v-layout row wrap>
                                <v-flex lg12>
                                      <v-select
                                          :items="Estados"
                                          item-text='nombre_estado'
                                          item-value='id'
                                          v-model="SelectEstadoModal"
                                          label="Seleccione estado"
                                      ></v-select>
                                  </v-flex>
                                  <v-flex>
                                    <v-textarea
                                      box
                                      placeholder="Ingrese comentarios al caso"
                                      name="input-7-4"
                                      label=""
                                      value=""
                                      :no-resize=true
                                      v-model="comentario"
                                      mx-2
                                    ></v-textarea>
                              </v-flex>
                              <v-flex>
                                <v-label>Adjuntar archivo </v-label>
                                <input ref="file" type="file">
                              </v-flex>
                            </v-layout>
                            </v-container>
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1"  @click="ActualizarCaso()">Actualizar caso</v-btn>
                            <v-btn color="blue darken-1" flat @click="close()">Cancelar</v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                    </v-toolbar>
                    <!--ALERT PARA CASOS-->
                     <v-alert
                        :value="alertListadoCasos"
                        type="error"
                        transition="scale-transition"
                        dismissible:true
                      >
                        Hubo un problema al buscar casos
                      </v-alert>
                       <!--ALERT PARA EMPRESAS DEL USUARIO-->
                     <v-alert
                        :value="alertEmpresasUsuario"
                        type="error"
                        transition="scale-transition"
                        dismissible:true
                      >
                        Hubo un problema al buscar sus empresas administradas
                      </v-alert>
                      <!--ALERT PARA ESTADOS-->
                     <v-alert
                        :value="alertEstados"
                        type="error"
                        transition="scale-transition"
                        dismissible:true
                      >
                        Hubo un problema al buscar los estados
                      </v-alert>
                      <!--ALERT PARA ACTUALIZACION DEL CASO-->
                     <v-alert
                        :value="alertActualizacionCaso"
                        type="error"
                        transition="scale-transition"
                        dismissible:true
                      >
                        Hubo un problema al actualizar el caso
                      </v-alert>
                    <!--DATATABLE-->
                    <v-data-table lg4
                        :headers="headers"
                        :items="list_casos"
                        class="elevation-1"
                    >
                        <template v-slot:items="props">
                            <td>{{ props.item.nombre_caso }}</td>
                            <td>{{ props.item.dias}}</td>
                            <td>{{ props.item.fecha_creacion }}</td>
                            <td>{{ props.item.fecha_envio }}</td>
                            <td>{{ props.item.fecha_recepcion }}</td>
                            <td>{{ props.item.fecha_respuesta_final }}</td>
                            <td>{{ props.item.nombre_empresa }}</td>
                            <td>{{ props.item.nombre_estado }}</td>
                            <td class="justify-center layout px-0">
                                <v-icon
                                   class="mr-2"
                                   @click="VerCaso(props.item.id)"
                                    >
                                search
                                </v-icon>
                                <v-icon
                                    @click="AbreModalActualizarCaso(props.item.id)"
                                      >
                                    edit
                                </v-icon>
                            </td>
                        </template>
                    </v-data-table>
                </template>      
            <br><br>
        <!--/v-layout-->
    </div>
</template>
<script>
    const axios=require('axios');
    import router from '../router'
    export default {
        name: "ListCases",
        components:{
        },
        data () {
            return {
                alertListadoCasos:false,
                alertEmpresasUsuario: false,
                alertEstados:false,
                alertActualizacionCaso: false,
                file:'',
                dialog:false,
                headers: [
                  { 
                    text: 'Caso',
                    align: 'left',
                    sortable: false,
                    value: 'caso_id', 
                  },
                  { text: 'Dias', value: 'dias',sortable:false},
                  { text: 'Fecha reclamo', value: 'fecha_creacion' },
                  { text: 'Fecha envío', value: 'fecha_envio' },
                  { text: 'Fecha recepción', value: 'fecha_recepcion' },
                  { text: 'Fecha respuesta final', value: 'fecha_respuesta_final' },
                  { text: 'Empresa', value: 'Empresa' },
                  { text: 'Estado', value: 'Estado' },
                  { text: 'Acciones', value: 'caso_id', sortable: false }
                ],
                list_casos: [
                ],
                modal:false,
                date: new Date().toISOString().substr(0, 10),
                date2: new Date().toISOString().substr(0, 10),
                date3: new Date().toISOString().substr(0, 10),
                date4: new Date().toISOString().substr(0, 10),
                date5: new Date().toISOString().substr(0, 10),
                date6: new Date().toISOString().substr(0, 10),
                date7: new Date().toISOString().substr(0, 10),
                date8: new Date().toISOString().substr(0, 10),
                menu: false,
                menu2:false,
                menu3:false,
                menu4:false,
                menu5:false,
                menu6:false,
                menu7:false,
                menu8:false,
                picker: new Date().toISOString().substr(0, 10),
                //casos: ['1','2','3','4'],
                //casos:[],
                TipoFechas: ['fecha_creacion','fecha_envio','fecha_recepcion','fecha_respuesta_final'],
                //Estados: ['Pendiente', 'Finalizado'],
                //Estados_values:[1,2],
                //Estados:[{estado:'Pendiente', valor:1},{estado:'Finalizado',valor:2},{estado:'Sin informacion',valor:3}],
                //Empresas: ['Salcobrand','Preunic','MTH'],
                Estados:[],
                Empresas:[],
                TipoArchivos:[],
                editedIndex: -1,
                //fecha_inicio: '',
                //fecha_fin:'',
                SelectCaso:'',
                SelectEmpresa:'',
                SelectEstado:'',
                fecha_inicio_creacion:'',
                fecha_fin_creacion: '',
                fecha_inicio_envio: '',
                fecha_fin_envio: '',
                fecha_inicio_recepcion: '',
                fecha_fin_recepcion:'',
                fecha_inicio_respuesta_final: '',
                fecha_fin_respuesta_final:'',
                comentario:'',
                SelectEstadoModal:'',
                caso_id:0,  
                //usuario:10,
                id_estado:0,
                //fecha_modificacion:'2019-09-17 15:54:26',
                fecha_modificacion:'',
                valor:9,
            }
        },
        filters:{
          parseValor(valor) {
               if(valor != undefined && valor != null) {
                   //return valor.toLocaleString('es-CL');
                   //var valor2=valor*1000;
                   //return (valor2).toISOString().split('.')[0];
               }
               return valor;
           }
        },
        mounted(){
            this.initialize();
        },
        methods: {
            /*auth_login () {

                this.$store.commit('account_sign_in', {
                    usuario: this.usuario,
                    contraseña: this.contraseña,
                    remeber_login: this.remeber_login
                })

                this.usuario = '';
                this.contraseña = '';
                this.remeber_login = false;
            },*/
            initialize(){
                  //OBTENCION DE LOS ESTADOS DE LA BASE DE DATOS
                  this.fecha_modificacion = new Date().toJSON().slice(0,10);
                  //this.fecha_modificacion = new DateTime;.toJSON().slice(0,10).replace(/-/g,'/');
                  let uriestados=this.$store.state.host+`/api/estados?api_token=${this.$store.state.api_token}`;
                  axios.get(uriestados).then((response)=>{
                      let resp=response.data;
                      if (resp.status_code == 200) {
                          this.Estados=resp.estados;
                          this.alertEstados=false;
                      }else{
                          this.alertEstados=true;
                      }
                  });
                  //OBTENCION DE LOS CASOS DE LA BASE DE DATOS SOLO DE LAS EMPRESAS ASOCIADAS AL USUARIO
                  let uricasos = this.$store.state.host+`/api/casos?caso=${this.SelectCaso}&id_estado=${this.SelectEstado}&id_empresa=${this.SelectEmpresa}&fecha_inicio_creacion=${this.fecha_inicio_creacion}&fecha_fin_creacion=${this.fecha_fin_creacion}&fecha_inicio_envio=${this.fecha_inicio_envio}&fecha_fin_envio=${this.fecha_fin_envio}&fecha_inicio_recepcion=${this.fecha_inicio_recepcion}&fecha_fin_recepcion=${this.fecha_fin_recepcion}&fecha_inicio_respuesta_final=${this.fecha_inicio_respuesta_final}&fecha_fin_respuesta_final=${this.fecha_fin_respuesta_final}&user_id=${this.$store.state.user_id}&api_token=${this.$store.state.api_token}`;
                  axios.get(uricasos).then((response) => {
                        let res = response.data;
                        if (res.status_code == 200) {
                            this.list_casos=res.casos;
                            this.alertListadoCasos=false;
                        }else{
                          this.alertListadoCasos=true;
                        }
                    });
                  //OBTENCION DE LAS EMPRESAS ADMINISTRADAS POR EL USUARIO
                    let uriempresas=this.$store.state.host+`/api/empresasUser/${this.$store.state.user_id}?api_token=${this.$store.state.api_token}`;
                    axios.get(uriempresas).then((response)=>{
                    let result = response.data;
                          if (result.status_code == 200) {
                              this.Empresas=result.empresas;
                              this.alertEmpresasUsuario=false;
                          }else{
                            this.alertEmpresasUsuario=true;
                          }
                      });
            },
            buscarCasos(){
              //OBTENCION DE LOS CASOS DE LA BASE DE DATOS SOLO DE LAS EMPRESAS ASOCIADAS AL USUARIO
                  let uricasos = this.$store.state.host+`/api/casos?caso=${this.SelectCaso}&id_estado=${this.SelectEstado}&id_empresa=${this.SelectEmpresa}&fecha_inicio_creacion=${this.fecha_inicio_creacion}&fecha_fin_creacion=${this.fecha_fin_creacion}&fecha_inicio_envio=${this.fecha_inicio_envio}&fecha_fin_envio=${this.fecha_fin_envio}&fecha_inicio_recepcion=${this.fecha_inicio_recepcion}&fecha_fin_recepcion=${this.fecha_fin_recepcion}&fecha_inicio_respuesta_final=${this.fecha_inicio_respuesta_final}&fecha_fin_respuesta_final=${this.fecha_fin_respuesta_final}&user_id=${this.$store.state.user_id}&api_token=${this.$store.state.api_token}`;
                  axios.get(uricasos).then((response) => {
                        let res = response.data;
                        if (res.status_code == 200) {
                            this.list_casos=res.casos;
                            this.alertListadoCasos=false;
                            //this.limpiarFiltros();
                        }else{
                            this.alertListadoCasos=true;
                        }
                    });
            },
            AbreModalActualizarCaso(caso_id){
                this.dialog=true;
                this.caso_id=caso_id;
            },
            ActualizarCaso(){//SOLO CREA UNA ACTUALIZACION EN LA TABLA DE ACTUALIZACIONES
                let formData=new FormData();
                this.file = this.$refs.file.files[0];             
                 //ACTUALIZA EL ESTADO DEL CASO EN LA TABLA CASOS Y ADEMÁS CREA UNA ACTUALIZACION EN LA TABLA DE ACTUALIZACIONES
                //let uri = this.$store.state.host+'/api/casos/'+this.caso_id;
                let uri = this.$store.state.host+'/api/casos/'+this.caso_id;
                //let uri = this.$store.state.host+'/api/casos/';
                formData.append('fecha_modificacion',this.fecha_modificacion);
                formData.append('comentario',this.comentario);
                formData.append('estado_id',this.SelectEstadoModal);
                formData.append('user_id',this.$store.state.user_id);
                formData.append('caso_id',this.caso_id);
                formData.append('_method','PUT');
                formData.append('api_token',this.$store.state.api_token);
                formData.append('file',this.file);
                axios.post(uri,formData,{headers:{'Content-Type':'multipart/form-data'}}).then((response) => {
                //axios.post(uri,formData).then((response) => {//ESTE FUNCIONA
                      let res = response.data;
                      if (res.status_code == 200) {
                          this.close();
                          this.list_casos=res.casos;
                          this.alertActualizacionCaso=false;
                      }else{
                          this.alertActualizacionCaso=true;
                      }
                  });
            },
            VerCaso (id_caso) {
                router.push({name:'HistorialCambios', params: {id_caso}, props:true});
            },

            close() {
                this.dialog = false
            },
            limpiarFiltros(){
              console.log('Limpiando los filtros de busqueda');
              this.SelectCasoId='';
              this.SelectEmpresa='';
              this.SelectEstado='';
              this.fecha_inicio_creacion='';
              this.fecha_fin_creacion= '';
              this.fecha_inicio_envio= '';
              this.fecha_fin_envio= '';
              this.fecha_inicio_recepcion= '';
              this.fecha_fin_recepcion='';
              this.fecha_inicio_respuesta_final= '';
              this.fecha_fin_respuesta_final='';
            },
        }
    }
</script>
<style scoped>
</style>