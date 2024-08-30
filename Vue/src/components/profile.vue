<template>
  <v-main class="profile">
    <v-row>
      <v-col class="split right">
          <v-toolbar color="white" flat permanent fixed height="25">
            <v-spacer></v-spacer>
            <v-card
              color="white"
              v-for="item in items"
              :key="item.title"
              class="py-0 mt-8 mx-auto"
              :to = "item.to"
              flat>
              <v-btn text class="pr-9">
                  {{ item.title }}
              </v-btn>
            </v-card>   
            <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">   
                    <v-btn icon v-bind="attrs" v-on="on" class="mt-7 mr-5">
                        <v-icon>mdi-account</v-icon>
                    </v-btn>   
                </template>
                
                <v-list>
                    <v-list-tile>
                        <v-list-tile-action>
                            <v-list-item-title>
                                <v-btn text @click="prop"> Profile </v-btn>
                            </v-list-item-title>
                            <v-list-item-title>
                                <v-btn text @click="logout"> Logout </v-btn>
                            </v-list-item-title>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list>
            </v-menu>  
          </v-toolbar>
            <v-form class="mt-16 ml-16">
                <v-container class="ipt">
                  <v-row>
                      <p class="txt1"> Nama </p>
                      <v-text-field label="Nama" v-model="form.name" :rules="usernameRules" outlined></v-text-field>
                  </v-row>

                  <v-row horizontal justify-center>
                      <p class="txt1"> Email </p>
                      <v-text-field v-model="form.email" disabled label="Email" outlined></v-text-field>
                  </v-row>

                  <v-row>
                      <p class="txt"> No. Telp </p>
                      <v-text-field label="Telpon" v-model="form.telp" :rules="telpRules" outlined ></v-text-field>
                  </v-row>

                  <v-row>
                      <p class="txt2"> Alamat </p>
                      <v-textarea label="Alamat" v-model="form.alamat" :rules="alamatRules" outlined></v-textarea>
                  </v-row>

                  <v-row class="d-flex flex-row-reverse">
                    <v-btn color="#ABE6EE" @click="update()" elevation="3">Simpan
                    </v-btn>
                  </v-row>
                  <br>
                </v-container>
            </v-form>
        </v-col>

      <v-col class="split left">
        <img class="logo mt-2" src="../assets/logo.png">
        <h1 class="prop"><b>Profile</b></h1>
        <img class="picture" :src="form.url">
        <v-file-input
          class="cam"
          prepend-icon="mdi-camera"
          type="file"
          @change="handleImage(getImage)"
          v-model="getImage"
          accept="image/*"
          hide-input
        ></v-file-input>
      </v-col>
    </v-row>

    <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
      {{error_message}}
    </v-snackbar>
  </v-main>
</template>

<script>
  export default {
    name : "profile",
    data () {
      return {
        load: false,
        editCheck: true,
        itemTemp: null,
        snackbar :false,
        error_message:'',
        color: '',
        getImage:null,
        // form:[],
        form :{
          id: localStorage.getItem('id'),
          name: null,
          email: null,
          telp: null,
          alamat: null,
          url:null,
        },
        profil : new FormData,
        profile : [],
        items : [
          { title : "Beranda", to:"/index"},
          { title : "Pemesanan", to:"/pemesanan"},
        ],
        telpRules: [
            (v) => !!v || 'Nomor Telepon tidak boleh kosong',
            (v) => v.length > 10 || 'Digit kurang dari 10',
            (v) => v.length < 13 || 'Digit lebih dari 13',
        ],
        alamatRules: [
            (v) => !!v || 'Alamat tidak boleh kosong',
        ],
        usernameRules: [
            (v) => !!v || 'Username tidak boleh kosong',
        ],
        deleteId: '',
        editId: ''
      }
    },
    methods:{
      handleImage(e){
        // const selectedImage = getImage.target.files[0];
        // this.createBase64Image(e);
        var reader = new FileReader();
        reader.readAsDataURL(e);
        reader.onload = (e) => {
          this.form.url = e.target.result;
        }
      },
      logout() {
          localStorage.removeItem('token')
          this.$router.push('/index')
      },
      prop(){
          this.$router.push('/profile')
      },
      readData() {
        var url = this.$api + '/user'
        this.$http.get(url,{
          headers:{
            'Authorization' : 'Bearer ' + localStorage.getItem('token')
          }
        }).then(response => { 
          console.log(response)
          this.form = response.data.data
        })
      },
      update() {
        let newData = {
          name: this.form.name,
          telp: this.form.telp,
          alamat: this.form.alamat,
          url:this.form.url,
        }
        var url = this.$api + '/profile/' + this.form.id;
        this.load = true
        this.$http.put(url, newData, {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        }).then(response => {
            this.error_message=response.data.message;
            this.color="green"
            this.snackbar=true;
            this.load = false;
            this.close();
            this.readData(); //mengambil data
        }).catch(error => {
            this.error_message=error.response.data.message;
            this.color="red"
            this.snackbar=true;
            this.load = false;
        })
      },
    },
    mounted() {
      this.readData();
    },
};
</script>

<style scope>
.prop{
  margin-top:-7%;
}
.btnc{
    padding-right:20%;
}
.txt{
    font-weight: 700;
    text-align: center;
    margin: 6%;
    margin-top:2.5%
}
.txt1{
    font-weight: 700;
    text-align: center;
    margin-right:10%;
    margin-left:5.2%;
    margin-top:2.5%;
    margin-bottom:5%;
}
.txt2{
    font-weight: 700;
    text-align: center;
    margin-right:10%;
    margin-left:3.5%;
    margin-top:2.5%;
    margin-bottom:5%;
}
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
  left:12.5%;
  height: fit-content;
}
.split {
  height: 100%;
  position: fixed;
  top: fit-content;
  overflow-x: hidden;
}
.logo{
  position:relative;
  margin-top:-7%;
  width:25%;
  height:30%;
}
.picture{
  margin-top:5%;
  width:46%;
  height:48%;
}

.apa{
  width:fit-content;
  height:fit-content;
}

/* Control the left side */
.left {
  left: 0;
  width: 50%;
  background-color: #E8F0F9;
}

/* Control the right side */
.right {
  right:2%;
  width: 50%;
  background-color: white;
}
.cam{
  margin-left: 48%;
}
</style>



