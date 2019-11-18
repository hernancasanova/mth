<template>
    <v-dialog v-model="this.$store.state.auth_login" persistent max-width="600px">
        <v-card>
            <v-card-title>Ingrese a su cuenta</v-card-title>
            <v-card-text>
                <v-form>
                    <v-container grid-list-md>
                        <v-text-field label="Nombre de usuario" v-model="usuario"></v-text-field>
                        <v-text-field label="Contraseña" type="password" v-model="contrasena"></v-text-field>
                    </v-container>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="auth_login">Ingresar</v-btn>
            </v-card-actions>
        </v-card>
        <v-alert
              :value="this.$store.state.alert"
              type="error"
              transition="scale-transition"
              dismissible:true
            >
              Usuario y/o contraseña incorrectos
        </v-alert>
    </v-dialog>
</template>

<script>
    export default {
        name: "Login",
        data () {
            return {
                usuario:'',
                contrasena:'',
                remeber_login: false
            }
        },

        methods: {
            auth_login () {
                this.$store.commit('account_sign_in', {
                    usuario: this.usuario,
                    contrasena: this.contrasena,
                    remeber_login: this.remeber_login
                })
            },
        }
    }
</script>


<style scoped>

</style>