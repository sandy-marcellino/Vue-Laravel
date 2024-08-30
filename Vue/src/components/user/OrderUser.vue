<template>
  <v-main class="order">
  <br>
  <br>
  <br>
  <br>
    <v-card max-width="1600" class="ml-9 mr-9 mt-8" elevation="3" outlined>
      <v-card-title>
        <v-text>
            <h3> List Pesanan </h3>
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

        <v-btn color = "primary" dark @click = "create = true">
            Tambah
        </v-btn>
      </v-card-title>

      <v-data-table :headers="headers" :items="readPesanan()" :search="search" item-key="kelola_pesanans">
        <template v-slot:[`item.status`]="{ item }">
            <td>
                <v-chip v-if="item.status == 'Diproses'" color="red" outlined>
                    {{ item.status }}
                </v-chip>

                <v-chip v-else-if="item.status == 'Selesai'" color="green" outlined>
                    {{ item.status }}
                </v-chip>
            </td>
        </template>

        <template v-slot:[`item.actions`]= "{ item }">
          <span v-if= "item.status == 'Diproses'">
            <v-icon color="blue" @click="editHandler(item)">mdi-pencil</v-icon>
          </span>
      
          <v-icon color="red" @click="deleteHandler(item.id)">mdi-delete</v-icon>
        </template>
      </v-data-table>
    </v-card>

    <v-dialog v-model = "create" persistent max-width = "600px">
      <v-card>
        <br>
        <v-card-title>
          <span class = "headline">{{ formTitle }} Pesanan</span>
        </v-card-title>

        <v-card flat class="pl-9 pr-9">
          <v-container fluid>
            <v-select
              v-model = "form.parfum"
              label = "Parfum"
              :items="parfum"
              required
              outlined
            ></v-select>
        
            <v-select
              v-model = "form.paket"
              label = "Paket"
              :items="data_paket"
              required
              outlined
            ></v-select>

            <v-select
              v-model = "form.lokasi"
              label = "Lokasi"
              :items="lokasi"
              required
              outlined
            ></v-select>
          </v-container>
        </v-card>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color = "red darken-1" text @click = "Tidak">
              Batal
          </v-btn>

          <v-btn v-if="editCheck == true" color = "blue darken-1" text @click = "setForm">
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

              <v-btn color="green darken-1" text @click="modalDelete = false">
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
// import jspdf from 'jspdf'

export default {
name : "order",
data() {
    return {
        inputType: 'Tambah',
        load: false,
        search : null,
        create : false,
        radio: null,
        cetakpdf: false,
        editCheck: true,
        modalDelete: false,
        modalEdit: false,
        itemTemp: null,
        snackbar :false,
        error_message:'',
        dialogConfirm: false,
        color: '',
        lokasi : ['Yogyakarta', 'Kulonprogo', 'Purworejo','Purwokerto','Solo'],
        
        parfum : ['Vannila', 'Anggur', 'Strawberry'],
        headers : [
            {
                text : "Tanggal",
                align : "start",
                sortable : true,
                value : "created_at",
            },
            { text : "Berat", value : "berat"},
            { text : "Paket", value : "paket"},
            { text : "Parfum", value : "parfum"},
            { text : "Lokasi", value : "lokasi"},
            { text : "Status", value : "status"},
            { text : "Harga", value : "harga"},
            { text : "", value : "actions"},
        ],

        pesan : new FormData,
        pesanan : [],
        data_paket: [],
        loadPesananUser: [],

        icons: [
        'mdi-facebook',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
        ],

        form : {
            tanggal : null,
            berat : null,
            data_paket : null,
            parfum : null,
            lokasi : null,
            status : null,
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
        if(this.inputType === 'Tambah'){//---- ini perubahan
          this.save()
        }else{
          this.update()
        }
    },

    readPesanan(){
        return this.pesanan.filter(pesan=>pesan.email===this.loadPesananUser.email)
    },

    readData3() {
      var url = this.$api + '/lokasiAll'
      this.$http.get(url,{
        headers:{
          'Authorization' : 'Bearer ' + localStorage.getItem('token')
        }
      }).then(response => { 
        this.lokasi = response.data.data
      })
    },

    readData2() {
      var url = this.$api + '/mitraUser'
      this.$http.get(url,{
        headers:{
          'Authorization' : 'Bearer ' + localStorage.getItem('token')
        }
      }).then(response => { 
        console.log(response)
        this.loadPesananUser = response.data.user
      })
    },

    //read data paket
    readData1() {
      var url = this.$api + '/paketAll'
      this.$http.get(url,{
        headers:{
          'Authorization' : 'Bearer ' + localStorage.getItem('token')
        }
      }).then(response => { 
        this.data_paket = response.data.data
      })
    },

    readData() {
      var url = this.$api + '/kelola'
      this.$http.get(url,{
        headers:{
          'Authorization' : 'Bearer ' + localStorage.getItem('token')
        }
      }).then(response => { 
        this.pesanan = response.data.data
      })
    },

    //simpan data produk
    save() {
      this.pesan.append('created_at', this.form.tanggal);
      this.pesan.append('paket', this.form.paket);
      this.pesan.append('parfum', this.form.parfum);
      this.pesan.append('lokasi', this.form.lokasi);
      this.pesan.append('email', this.loadPesananUser.email);

      var url = this.$api + '/kelola'
      this.load = true
      this.$http.post(url, this.pesan, {
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
        paket: this.form.paket,
        parfum: this.form.parfum,
        lokasi: this.form.lokasi,
      }

      var url = this.$api + '/kelola/' + this.editId;
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
        //menghapus data
        var url = this.$api + '/kelola/' + this.deleteId;
        
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
      this.form.tanggal= item.tanggal;
      this.form.berat= item.berat;
      this.form.paket= item.paket;
      this.form.parfum= item.parfum;
      this.form.lokasi= item.lokasi;
      this.form.status= item.status;
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
          berat : null,
          paket : null,
          parfum : null,
          lokasi : null,
          status : null,
          harga : null,
        };
      },
    },
    computed: {
        formTitle() {
            return this.inputType
        },
    },

    mounted() {
        this.readData1();
        this.readData();
        this.readData2();
        this.readData3();
    },
};
</script>

<style scope>
  .order{
      background-color:  #ffffff;
  }
</style>