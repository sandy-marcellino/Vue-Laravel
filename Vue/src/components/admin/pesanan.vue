<template>
  <v-main class="kelola_pesanans">
  <br>
  <br>
  <h2> Hi, Admin! </h2>
  <br>
  <br>
    <v-card max-width="1600" class="ml-9 mr-9" elevation="3" outlined>
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
      </v-card-title>

      <v-data-table :headers = "headers" :items = "pesanan" :search = "search" item-key = "kelola_pesanans">
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
          <v-icon color="blue" @click="editHandler(item)">mdi-pencil</v-icon>
      
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
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model = "form.tanggal"
                  label = "Tanggal Pemesanan"
                  required
                  outlined
                  disabled
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model = "form.parfum"
                  label = "Parfum"
                  required
                  outlined
                  disabled
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model = "form.paket"
                  label = "Paket"
                  required
                  outlined
                  disabled
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model = "form.berat"
                  label = "Berat"
                  required
                  outlined
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-select
                  v-model = "form.status"
                  :items="status"
                  label = "Status"
                  required
                  outlined
                ></v-select>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-select
                  v-model = "form.lokasi"
                  label = "Lokasi"
                  :items="lokasi"
                  required
                  outlined
                  disabled
                ></v-select>
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
export default {
name : "Pesanan",
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
        lokasi : ['Yogyakarta', 'Kulonprogo', 'Purworejo','Purwokerto','Solo'],
        status : ['Diproses', 'Selesai'],
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
            { text : "Harga (Rp)", value : "harga"},
            { text : "Email ", value : "email"},
            { text : "", value : "actions"},
        ],

        pesan : new FormData,
        pesanan : [],

        icons: [
          'mdi-facebook',
          'mdi-twitter',
          'mdi-linkedin',
          'mdi-instagram',
        ],

        form : {
            tanggal : null,
            berat : null,
            paket : null,
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

    //read data paket
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
      this.pesan.append('berat', this.form.berat);
      this.pesan.append('paket', this.form.paket);
      this.pesan.append('parfum', this.form.parfum);
      this.pesan.append('lokasi', this.form.lokasi);
      this.pesan.append('status', this.form.status);
      this.pesan.append('harga', this.form.harga);

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
        tanggal: this.form.tanggal,
        berat: this.form.berat,
        paket: this.form.paket,
        parfum: this.form.parfum,
        lokasi: this.form.lokasi,
        status: this.form.status,
        harga: this.form.harga,
      }

      var url = this.$api + '/kelolaAdmin/' + this.editId;
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
        this.readData();
    },
};
</script>

<style scope>
  .kelola_pesanans{
      background-color:  #ffffff;
  }
</style>
