<template>
  <v-main class="paket">
    <br>
    <br>
    <h2> Hi, Admin! </h2>
    <br>
    <br>
    <v-card max-width="1600" class="ml-9 mr-9" elevation="3" outlined>
      <v-card-title>
        <v-text>
            <h3> List Paket Laundry </h3>
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

      <v-data-table :headers = "headers" :items = "todos" :search = "search" item-key = "paket">
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
          <span class = "headline">{{ formTitle }} Paket</span>
        </v-card-title>

        <v-card flat class="pl-9 pr-9">
          <v-container fluid>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model = "form.nama_paket"
                  label = "Nama Paket"
                  required
                  outlined
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model = "form.waktu"
                  label = "Waktu"
                  required
                  outlined
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model = "form.harga"
                  label = "Harga"
                  required
                  outlined
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-select
                  v-model = "form.detergen"
                  :items="detergen"
                  label = "Detergen"
                  required
                  outlined
                ></v-select>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-select
                  v-model = "form.ongkir"
                  :items="ongkir"
                  label = "Ongkir"
                  required
                  outlined
                ></v-select>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-select
                  v-model = "form.pribadi"
                  :items="pribadi"
                  label = "Pribadi"
                  required
                  outlined
                ></v-select>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-select
                  v-model = "form.terpisah"
                  :items="terpisah"
                  label = "Terpisah"
                  required
                  outlined
                ></v-select>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-select
                  v-model = "form.setrika"
                  :items="setrika"
                  label = "Setrika"
                  required
                  outlined
                ></v-select>
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
                Hapus
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
  name : "Paket",
  data() {
    return {
        inputType: 'Tambah',
        load: false,
        search : null,
        create : false,
        radio: null,
        editCheck: true,
        modalDelete: false,
        modalEdit: false,
        itemTemp: null,
        snackbar :false,
        error_message:'',
        dialogConfirm: false,
        color: '',
        detergen : ['Premium', 'Standard'],
        ongkir : ['Gratis', 'Bayar'],
        pribadi : ['Ya', 'Tidak'],
        terpisah : ['Ya', 'Tidak'],
        setrika : ['Ya', 'Tidak'],
        headers : [
            {
                text : "Nama Paket",
                align : "start",
                sortable : true,
                value : "nama_paket",
            },
            { text : "Pribadi", value : "pribadi"},
            { text : "Terpisah", value : "terpisah"},
            { text : "Detergen", value : "detergen"},
            { text : "Setrika", value : "setrika"},
            { text : "Ongkir", value : "ongkir"},
            { text : "Waktu (Jam)", value : "waktu"},
            { text : "Harga (Rp)", value : "harga"},
            { text : "", value : "actions"},
        ],

        todo : new FormData,
        todos : [],

        icons: [
          'mdi-facebook',
          'mdi-twitter',
          'mdi-linkedin',
          'mdi-instagram',
        ],

        form : {
            paket : null,
            pribadi : null,
            terpisah : null,
            detergen : null,
            setrika : null,
            ongkir : null,
            waktu : null,
            harga : null,
            action : null,
        },
        deleteId: '',
        editId: ''
    };
},

methods: {
  //ini fungsi tambah
    setForm() {
        // this.todos.push(this.form);
        // this.resetForm();
        // this.create = false;
        if(this.inputType === 'Tambah'){//---- ini perubahan
          this.save()
        }else{
          this.update()
        }
    },

    //read data paket
    readData() {
      var url = this.$api + '/paket'
      this.$http.get(url,{
        headers:{
          'Authorization' : 'Bearer ' + localStorage.getItem('token')
        }
      }).then(response => { 
        this.todos = response.data.data
      })
    },

    //simpan data produk
    save() {
      this.todo.append('nama_paket', this.form.nama_paket);
      this.todo.append('pribadi', this.form.pribadi);
      this.todo.append('terpisah', this.form.terpisah);
      this.todo.append('detergen', this.form.detergen);
      this.todo.append('setrika', this.form.setrika);
      this.todo.append('ongkir', this.form.ongkir);
      this.todo.append('waktu', this.form.waktu);
      this.todo.append('harga', this.form.harga);

      var url = this.$api + '/paket'
      this.load = true
      this.$http.post(url, this.todo, {
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

    //ubah data produk
    update() {
      let newData = {
          nama_paket: this.form.nama_paket,
          pribadi: this.form.pribadi,
          terpisah: this.form.terpisah,
          detergen: this.form.detergen,
          setrika: this.form.setrika,
          ongkir: this.form.ongkir,
          waktu: this.form.waktu,
          harga: this.form.harga
      }

      var url = this.$api + '/paket/' + this.editId;
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

    //hapus data produk
    deleteData() {
        //mengahapus data
        var url = this.$api + '/paket/' + this.deleteId;
        
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
      this.form.nama_paket= item.nama_paket;
      this.form.pribadi= item.pribadi;
      this.form.terpisah= item.terpisah;
      this.form.detergen= item.detergen;
      this.form.setrika= item.setrika;
      this.form.ongkir= item.ongkir;
      this.form.waktu= item.waktu;
      this.form.harga= item.harga;
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
          paket : null,
          pribadi : null,
          terpisah : null,
          detergen : null,
          setrika : null,
          ongkir : null,
          waktu : null,
          harga : null,
          action : null,
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
    },
};
</script>

<style scope>
  .paket{
      background-color:  #ffffff;
  }
</style>
