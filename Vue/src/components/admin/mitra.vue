<template>
  <v-main class="mitra">
  <br>
  <br>
  <h2> Hi, Admin! </h2>
  <br>
  <br>
    <v-card max-width="1600" class="ml-9 mr-9" elevation="3" outlined>
      <v-card-title>
        <v-text>
            <h3> List Mitra </h3>
        </v-text>

        <v-spacer></v-spacer>

        <v-col
            class="d-flex"
            cols="12"
            sm="5">
            <v-text-field
                v-model="search" label="Search"
                outlined
                hide-details
                dense
                append-icon ="mdi-magnify"
            ></v-text-field>
        </v-col>

        <v-btn color = "success" dark @click = "create = true">
            Tambah
        </v-btn>
      </v-card-title>

      <v-data-table :headers = "headers" :items = "mitras" :search = "search" item-key = "mitra">
        <template v-slot:[`item.actions`]= "{ item }">
          <v-icon color="blue" @click="editHandler(item)">mdi-pencil</v-icon>
      
          <v-icon color="red" @click="deleteHandler(item.id)">mdi-delete</v-icon>
        </template>
      </v-data-table>
    </v-card>

    <v-dialog v-model = "create" persistent max-width = "600px">
      <v-card>
        <br>
        <v-card-title>
          <span class = "headline">{{ formTitle }} Mitra Baru</span>
        </v-card-title>

        <v-card flat class="pl-9 pr-9">
          <v-container fluid>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model = "form.pemilik"
                  label = "Nama Pemilik"
                  required
                  outlined
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model = "form.alamat"
                  label = "Alamat"
                  required
                  outlined
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model = "form.email"
                  label = "Email"
                  required
                  outlined
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model = "form.telp"
                  label = "No. Handphone"
                  required
                  outlined
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color = "blue darken-1" text @click = "Tidak">
              Batal
          </v-btn>

          <v-btn v-if="editCheck == true" color = "red darken-1" text @click = "setForm">
              Simpan
          </v-btn>

        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="modalDelete" persistent max-width="400px">
      <v-card>
          <v-card-title > 
              <span class="headline font-weight-bold">Yakin ingin menghapus?</span>
          </v-card-title>

          <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn color="blue darken-1" text @click="modalDelete = false">
                Tidak
              </v-btn>

              <v-btn color="red darken-1" text @click="deleteData">
                Ya
              </v-btn>                    
          </v-card-actions>
      </v-card>
    </v-dialog>

    <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
      {{error_message}}
    </v-snackbar>

    <v-footer padless dark relative>
      <v-col class="text-center p-0 m-0">
        <v-card
          flat
          tile
          color="#636E72">
          <v-card-text>
            <v-card-text class="white--text pt-3">
              Informasi lebih lanjut, Silakan hubungi kami melalui sosial media dibawah ini
            </v-card-text>

            <v-btn
              v-for="icon in icons"
              :key="icon"
              class="mx-7 mb-n3 white--text"
              icon>
              <v-icon size="24px">
                {{ icon }}
              </v-icon>
            </v-btn>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-text class="white--text">
            {{ new Date().getFullYear() }} — <strong>Laundry & Shine</strong>
          </v-card-text>
        </v-card>
      </v-col>
    </v-footer>
  </v-main>
</template>

<script>
export default {
name : "Mitra",
data() {
    return {
        load: false,
        inputType: 'Tambah',
        search : null,
        create : false,
        radio: null,
        editCheck: true,
        modalDelete: false,
        modalEdit: false,
        itemTemp: null,
        snackbar: false,
        dialogConfirm: false,
        color: '',
        error_message:'',

        headers : [
            {
                text : "Nama Pemilik",
                align : "start",
                sortable : true,
                value : "pemilik",
            },
            { text : "Email", value : "email"},
            { text : "No. Hp", value : "telp"},
            { text : "Alamat", value : "alamat"},
            { text : "Actions", value : "actions"},
        ],

        mitra : new FormData,
        mitras : [],
        // todos : [],

        icons: [
        'mdi-facebook',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
      ],

        form : {
            pemilik : null,
            email : null,
            telp : null,
            alamat : null,
            action : null,
        },
        deleteId: '',
        editId: ''
    };
},

methods: {
  setForm() {
        if(this.inputType === 'Tambah'){//---- ini perubahan
          this.save()
        }else{
          this.update()
        }
    },

    readData() {
      var url = this.$api + '/mitra'
      this.$http.get(url,{
        headers:{
          'Authorization' : 'Bearer ' + localStorage.getItem('token')
        }
      }).then(response => { 
        this.mitras = response.data.data
      })
    },

    save() {
      this.mitra.append('pemilik', this.form.pemilik);
      this.mitra.append('email', this.form.email);
      this.mitra.append('telp', this.form.telp);
      this.mitra.append('alamat', this.form.alamat);

      var url = this.$api + '/mitra'
      this.load = true
      this.$http.post(url, this.mitra, {
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
          this.resetForm();
          this.create = false;
      }).catch(error => {
          this.error_message=error.response.data.message;
          this.color="red"
          this.snackbar=true;
          this.load = false;
      })
    },

    update() {
      let newData = {
        pemilik: this.form.pemilik,
        email: this.form.email,
        telp: this.form.telp,
        alamat: this.form.alamat,
      }

      var url = this.$api + '/mitra/' + this.editId;
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
          this.resetForm();
          this.inputType = 'Tambah';
          this.create = false;
      }).catch(error => {
          this.error_message=error.response.data.message;
          this.color="red"
          this.snackbar=true;
          this.load = false;
      })
    },

    deleteData() {
        //menghapus data
        var url = this.$api + '/mitra/' + this.deleteId;
        
        //data dihapus berdasarkan id
        this.$http.delete(url, {
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
            this.resetForm();
            this.inputType = 'Tambah';
            this.modalDelete = false;
        }).catch(error => {
            this.error_message=error.response.data.message;
            this.color="red"
            this.snackbar=true;
            this.load = false;
        })
    },

    editHandler(item){
      this.inputType = 'Ubah';
      this.editId = item.id;
      this.form.pemilik= item.pemilik;
      this.form.email= item.email;
      this.form.telp= item.telp;
      this.form.alamat= item.alamat;
      this.create = true;
    },

    deleteHandler(id){
      this.deleteId = id
      this.modalDelete = true;
    },

    close() {
      this.dialog = false
      this.inputType = 'Tambah';
    },

    Tidak() {
      this.resetForm();
      this.readData();
      this.create = false;
      this.inputType = 'Tambah';
    },

    resetForm() {
      this.form = {
          pemilik : null,
          email : null,
          telp : null,
          alamat : null,
        };
      },
    },
    computed: {
      formTitle() {
        return this.inputType
      },
    },

    mounted() {
      this.readData();
    }
};
</script>

<style scope>
  .mitra{
      background-color:  #ffffff;
  }
</style>