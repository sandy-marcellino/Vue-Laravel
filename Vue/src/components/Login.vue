<template>
    <v-main class="login">
        <v-row class="fill-height">
            <v-col class="my-0">
                <div class="mt-16">
                    <img class="logo" src="../assets/logo.png">
                    <br>
                    <br>
                    <h1 class="masuk"><b>Masuk</b></h1>
                    <br>
                    <v-card class="mx-auto" width="500" elevation="3">
                        <v-form v-model="valid" ref="form">
                            <div class="ipt">
                            <br>
                                <v-text-field
                                label="Email"
                                v-model="email"
                                :rules="emailRules"
                                hide-details="auto"
                                outlined
                                class="ml-4"
                                required
                                ></v-text-field>

                                <br>
                                <v-text-field 
                                class="ml-4" 
                                label="Password" 
                                outlined
                                v-model="password"
                                :rules="passwordRules" 
                                type="password" 
                                min="8"
                                required 
                                ></v-text-field>

                                <v-btn 
                                    class="ml-1 mb-3" 
                                    color="#ABE6EE"
                                    @click="submit" 
                                    elevation="3"
                                >Masuk
                                </v-btn>
                            </div>
                        </v-form>
                    </v-card>
                </div>
            </v-col>

            <v-col class="rgt">
                <v-toolbar color="#E8F0F9" flat permanent fixed height="40">
            
                    <v-spacer></v-spacer>

                    <v-card
                        color="#E8F0F9"
                        v-for="item in items"
                        :key="item.title"
                        class="pr-9 mt-1 mx-auto"
                        :to = "item.to"
                        flat>
                        <v-btn text>
                            {{ item.title }}
                        </v-btn>
                    </v-card>   
                    
                </v-toolbar>
                
                <img class=" ml-12 mt-9" src="../assets/4.png">
            </v-col>
        </v-row>
        <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
        {{error_message}}
        </v-snackbar>
    </v-main>
</template>

<script>
  export default {
    name : "login",
    data (){
        return {
            load: false,
            valid: false,
            error_message: '',
            color: '',
            password: '',
            passwordRules: [
                (v) => !!v || 'Password tidak boleh kosong',
            ],
            email: '',
            emailRules: [
                (v) => !!v || 'E-mail tidak boleh kosong',
            ],
            items : [
                { title : "Beranda", to:"/index"},
                { title : "Pemesanan", to:"/login"},
                { title : "Masuk", to:"/login"},
                { title : "Registrasi", to:"/register"},
            ],
        };
    },
    methods: {
        submit() {
            if (this.$refs.form.validate()) { //cek apakah data yang akan dikirim sudah valid
                this.load = true
                this.$http.post(this.$api + '/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    localStorage.setItem('id', response.data.user.id); //menyimpan id user yang sedang login
                    localStorage.setItem('token', response.data.access_token);
                    // localStorage.setItem('name', response.data.user.name);
                    // localStorage.setItem('email', response.data.user.email);
                    // localStorage.setItem('status', response.data.user.status);
                    //menyimpan auth token
                    this.error_message=response.data.message;
                    this.color="green"
                    this.snackbar=true;
                    this.load = false;
                    this.clear();
                    if(response.data.user.status === 'user'){
                        this.$router.push({
                        name: 'beranda'
                    })

                    }else if(!(response.data.user.status === 'user')){
                        this.$router.push({
                        name: 'menuAdmin'
                    })

                    }
                }).catch(error => {
                    this.error_message=error.response.data.message;
                    this.color="red"
                    this.snackbar=true;
                    localStorage.removeItem('token')
                    this.load = false
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
  padding-top:5%;  
  padding-bottom:5%;
  margin-left:10%;
  width:75%;
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
.left {
  background-color: white;
}
/* Control the right side */
.rgt{
  background-color: #E8F0F9;
}

</style>
