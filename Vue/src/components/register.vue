<template>
    <v-main class="register">
        <v-row>
            <v-col class="left">
                <div class="mt-0">
                    <img class="logo" src="../assets/logo.png">
                    <h1 class="masuk"><b>Selamat Datang</b></h1>
                    <v-card class="mx-auto" width="500" elevation="3">
                        <v-form v-model="valid" ref="form">
                            <div class="ipt">
                                <v-row class="mt-2">
                                    <v-col cols="10" sm="6">
                                        <v-text-field v-model="username" :rules="usernameRules"
                                        class="ml-1" label="Username" outlined></v-text-field>
                                    </v-col>   
                                    
                                    <v-col cols="10" sm="6">
                                         <v-text-field v-model="email" :rules="emailRules" 
                                        class="ml-1" label="Email" outlined></v-text-field>
                                    </v-col>   
                                </v-row> 

                                <v-row class="ma-auto">
                                    <v-text-field v-model="password" :rules="passwordRules" 
                                    class="ml-1" label="Password" outlined type="password" min="7" ></v-text-field>

                                    <v-text-field v-model="telp" :rules="telpRules" 
                                    class="ml-1" label="Telpon" outlined ></v-text-field>

                                    <v-textarea v-model="alamat" :rules="alamatRules" 
                                    class="ml-1" label="Alamat" outlined></v-textarea>
                                </v-row>

                                <v-btn class="mr-2" color="#ABE6EE" @click="submit">
                                    Registrasi
                                </v-btn>
                            </div>
                        </v-form>
                    </v-card>
                </div>
            </v-col>
            
            <v-col class="right">
                    <v-toolbar color="#E8F0F9" flat permanent fixed height="40">
                        <v-spacer></v-spacer>
                        <v-card
                            color="#E8F0F9"
                            v-for="item in items"
                            :key="item.title"
                            class="pr-9 "
                            :to = "item.to"
                            flat>
                            <v-btn text>
                                {{ item.title }}
                            </v-btn>
                        </v-card>   
                    </v-toolbar>
                    <img class=" ml-5 mt-5" src="../assets/4.png" width="700" height="700">
            </v-col>
        </v-row>
        <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
            {{error_message}}
        </v-snackbar>
    </v-main>
</template>

<script>
  export default {
    name : "register",
    data (){
        return {
            load: false,
            valid: false,
            error_message: '',
            color: '',
            password: '',
            passwordRules: [
                (v) => !!v || 'Password tidak boleh kosong',
                (v) => v.length > 7 || 'Password kurang dari 8 karakter',
            ],
            email: '',
            emailRules: [
                (v) => !!v || 'E-mail tidak boleh kosong',
                v => /.+@.+/.test(v) || 'E-mail must be valid',
            ],
            telp: '',
            telpRules: [
                (v) => !!v || 'Nomor Telepon tidak boleh kosong',
                (v) => v.length > 10 || 'Digit kurang dari 10',
                (v) => v.length < 13 || 'Digit lebih dari 13',
            ],
            alamat: '',
            alamatRules: [
                (v) => !!v || 'Alamat tidak boleh kosong',
            ],
            username: '',
            usernameRules: [
                (v) => !!v || 'Username tidak boleh kosong',
            ],
            user: new FormData,
            users:[],
            items : [
                { title : "Beranda", to:"/index"},
                { title : "Pemesanan", to:"/pesanan"},
                { title : "Masuk", to:"/login"},
                { title : "Registrasi", to:"/register"},
            ],
        };
    },
    computed: {
    usernameAlredyExists() {
      return this.$store.getters["login/usernameAlredyExists"];
    }
  },
    methods: {
        callCheckUsername(value) {
            if (value) {
                this.$store.dispatch("login/checkUsername", {
                username: this.username
                });
            }
        },
       submit() {
            if (this.$refs.form.validate()) {
            this.user.append('name', this.username);
            this.user.append('email', this.email);
            this.user.append('password', this.password);
            this.user.append('telp', this.telp);
            this.user.append('alamat', this.alamat);

            var url = this.$api + '/register'
            this.load = true
            this.$http.post(url, this.user, {
                email: this.email,
                password: this.password
            }).then(response => {
                this.error_message=response.data.message;
                this.color="green"
                this.snackbar=true;
                this.load = false;
                this.clear();
                this.create = false;
                this.$router.push({
                    name: 'verif'
                })
            }).catch(error => {
                this.error_message=error.response.data.message;
                this.color="red"
                this.snackbar=true;
                this.load = false;
            })
            }
        },

        clear() {
            this.$refs.form.reset() //Clear form login
        }
    },
}
</script>

<style scope>
.btn{
  background-color: #E8F0F9;
}
.ipt{
  padding-top:2%;  
  padding-bottom:5%;
  margin-left:10%;
  width:80%;
}
.msk{
  top:20%;
  height: fit-content;
}
.masuk{
  margin-top:-12%;
  
}
.split {
  height: 100%;
  position: fixed;
  top: fit-content;
  overflow-x: hidden;
  padding-top: 20px;
}
.logo{
  position:relative;
  margin-top:-5%;
  width:25%;
  height:25%;
}
.apa{
  width:fit-content;
  height:fit-content;
}
/* Control the left side */
.left {
  left: 0;
  width: 50%;
  background-color: white;
}
/* Control the right side */
.right {
  background-color: #E8F0F9;
  weight:100%;
}
</style>
