<template>
  <v-main class="menuAdmin">
    <v-container class="mt-7">
      <h2> Hi, Admin! </h2>
      <br>
      <br>
      <v-row dense>
        <v-col>
          <v-card
            class="mx-auto"
            width ="250"
            elevation="3">
            <br>
            <br>
            <img
              class="white--text align-end"
              height="100px"
              src="../assets/Truk.png">
            <br>
            <br>
            <v-btn 
              depressed
              to="/kelola_pesanans"
            >
              Pesanan
            </v-btn>
            <br>
            <br>
          </v-card>
        </v-col>

        <v-col>
          <v-card
            class="mx-auto"
            width ="250"
            elevation="3">
            <br>
            <br>
            <img
              class="white--text align-end"
              height="100px"
              src="../assets/mitra.png">
            <br>
            <br>
            <v-btn 
              depressed
              to="/mitra"
            >
              Mitra
            </v-btn>
            <br>
            <br>
          </v-card>
        </v-col>

        <v-col>
          <v-card
            class="mx-auto"
            width ="250"
            elevation="3">
            <br>
            <br>
            <img
              class="white--text align-end"
              height="100px"
              src="../assets/paket.png">
            <br>
            <br>
            <v-btn 
              depressed
              to="/data_paket"
            >
              Paket
            </v-btn>
            <br>
            <br>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
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
              class="mx-7 mb-n4 white--text"
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
    name : "menuAdmin",
    data: () => ({
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
.menuAdmin{
  background-color: #E8F0F9;
}
</style>
