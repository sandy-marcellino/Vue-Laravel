<template>
  <v-main class="beranda">
    <v-layout justify>
      <div class="layout">
        <div class="centered1">
          <h2>Kami hadir untuk membantu Anda!</h2>
          <p>Pakaian yang bersih membuat Anda  
            <br>
            terlihat segar dan mempesona</p>
        </div>
        <div class="centered">
          <img src="../assets/2.png">
        </div>
      </div>
    </v-layout>

    <div class="paket">
      <v-container fixed>
        <br>
        <h2> Paket </h2>
        <br>
        <br>
        <v-row dense class="mt-9">
          <v-col>
            <img
                class="white--text align-end pxt"
                height="100px"
                src="../assets/jam.png">

            <v-card
              class="mx-auto crd"
              width="250"
              height="310"
              elevation="3"
              color="#E8F0F9">
              <br>
              <br>
              <br>
              <br>
              <h4 class="text-center">
                Express
              </h4>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title>- 1 Pelanggan 1 mesin</v-list-item-title>
                  <v-list-item-title>- Pakaian putih dicuci terpisah</v-list-item-title>
                  <v-list-item-title>- Detergen Premium</v-list-item-title>
                  <v-list-item-title>- Setrika Uap</v-list-item-title>
                  <v-list-item-title>- Free antar - jemput</v-list-item-title>
                  <v-list-item-title>- Lama pengerjaam 6 jam</v-list-item-title>
                  <v-list-item-title>- Rp 16.000/kg</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-card>
          </v-col>

          <v-col>
            <img
              class="white--text align-end pxt"
              height="100px"
              src="../assets/hand.png">

            <v-card
              class="mx-auto crd"
              width ="250"
              height="310"
              elevation="3"
              color="#E8F0F9">
              <br>
              <br>
              <br>
              <br>
              <h4 class="text-center">
                Next Day
              </h4>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title>- 1 Pelanggan 1 mesin</v-list-item-title>
                  <v-list-item-title>- Pakaian putih dicuci terpisah</v-list-item-title>
                  <v-list-item-title>- Detergen Standard</v-list-item-title>
                  <v-list-item-title>- Setrika Uap</v-list-item-title>
                  <v-list-item-title>- Free antar - jemput</v-list-item-title>
                  <v-list-item-title>- Lama pengerjaam 24 jam</v-list-item-title>
                  <v-list-item-title>- Rp 12.000/kg</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <br>
              <br>
            </v-card>
          </v-col>

          <v-col>
            <img
              class="white--text align-center pxt"
              height="100px"
              src="../assets/check.png">
              
            <v-card
              class="mx-auto crd"
              width="250"
              height="310"
              elevation="3"
              color="#E8F0F9">
              <br>
              <br>
              <br>
              <br>
              <h4 class="text-center">
                Reguler
              </h4>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title>- 1 Pelanggan 1 mesin</v-list-item-title>
                  <v-list-item-title>- Pakaian putih dicuci terpisah</v-list-item-title>
                  <v-list-item-title>- Detergen Standard</v-list-item-title>
                  <v-list-item-title>- Setrika Uap</v-list-item-title>
                  <v-list-item-title>- Free antar - jemput</v-list-item-title>
                  <v-list-item-title>- Lama pengerjaam 48 jam</v-list-item-title>
                  <v-list-item-title>- Rp 8.000/kg</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <br>
              <br>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <div class="mitra">
      <v-container>
        <br>
        <h2> Daftar Mitra Kami </h2>
        <br>
        <br>
        <v-row dense class="mt-9">
          <v-col>
            <v-card
              class="mx-auto"
              width="250"
              elevation="3">
              <img
                class="white--text align-end mt-9"
                height="100px"
                src="../assets/xx.png">
              <h3 class="text-center mt-5">Jakarta</h3>
              <img
                class="white--text align-end mt-3"
                height="20px"
                src="../assets/location.png">
              <div class="text--primary mt-3">
                Jl.MH Thamrin No 1<br>
                Jakarta Pusat 10310"
              </div>
              <br>
              <br>
              <v-card-actions>
                <div class="text-center">
                  <v-btn
                    rounded
                    color="#ABE6EE"
                    class="ml-6 mb-3"
                    to="/pemesanan"
                  >
                    Order Sekarang
                  </v-btn>
                </div>
              </v-card-actions>
            </v-card>
          </v-col>

          <v-col>
            <v-card
              class="mx-auto"
              width="250"
              elevation="3">
              <img
                class="white--text align-end mt-9"
                height="100px"
                src="../assets/xx.png">
              <h3 class="text-center mt-5">Yogyakarta</h3>
              <img
                class="white--text align-end mt-3"
                height="20px"
                src="../assets/location.png">
              <div class="text--primary mt-3">
                Jl.Babarsari No.43<br>
                Yogyakarta 552781"
              </div>
              <br>
              <br>
              <v-card-actions>
                <div class="text-center">
                  <v-btn
                    rounded
                    color="#ABE6EE"
                    class="ml-6 mb-3"
                    to="/pemesanan"
                  >
                    Order Sekarang
                  </v-btn>
                </div>
              </v-card-actions>
            </v-card>
          </v-col>

          <v-col>
             <v-card
              class="mx-auto"
              width="250"
              elevation="3">
              <img
                class="white--text align-end mt-9"
                height="100px"
                src="../assets/xx.png">
              <h3 class="text-center mt-5">Solo</h3>
              <img
                class="white--text align-end mt-3"
                height="20px"
                src="../assets/location.png">
              <div class="text--primary mt-3">
                Jl. Siwalankerto No.121 - 131<br>
                Jawa Timur 60236"
              </div>
              <br>
              <br>
              <v-card-actions>
                <div class="text-center">
                  <v-btn
                    rounded
                    color="#ABE6EE"
                    class="ml-6 mb-3"
                    to="/pemesanan"
                  >
                    Order Sekarang
                  </v-btn>
                </div>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </div>
    <v-footer padless dark relative >
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
              class="mx-7 mb-n4 white--text"
              icon>
              <v-icon size="24px">
                {{ icon }}
              </v-icon>
            </v-btn>
            <v-card-text class="white--text pt-3">
            <br/>
                  <iframe width="900" height="400" id="gmap_canvas" src="https://maps.google.com/maps?q=uajy%20kampus%203&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                  </iframe>
       
            </v-card-text>
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
    name : "beranda",
    data: () => ({
      // items : [
      //     { title : "Beranda", to:"/index"},
      //     { title : "Pemesanan", to:"/login"},
      //     { title : "Masuk", to:"/login"},
      // ],
      icons: [
        'mdi-facebook',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
      ],
    }),
  }
</script>

<style scope>
.layout{
  background-color:#E8F0F9; 
  height:700px;
}
.centered {
  position: relative;
  margin-top:2%;
  left: 10%
}

.centered1 {
  position: relative;
  text-align: center;
  color: #015F7A;  
  left:7%;
  margin-top:16%;
}

/* Style the image inside the centered container, if needed */
.centered img {
  width: 150%;
  height:90%
}
.split {
  height: fit-content;
  
  position: relative;
  top: fit-content;
  overflow-x: hidden;
  padding-top: 10px;
}
/* Control the left side */
.left {
  left: 0;
  width: 40%;
  background-color: #E8F0F9;
}
/* Control the right side */
.right {
  right: 0;
  width: 60%;
  background-color: #E8F0F9;
}
.mitra{
  top:fit-content;
  background-color: #E8F0F9;  
  height:700px;
}
.menuAdmin{
  background-color: #FFFFFF;
}
.paket{
  background-color: #FFFFFF;
  height:700px;
}
.pxt{
  position:relative;
  z-index:1;
}
.crd{
  top:-15%;
  z-index:0; 
}
</style>