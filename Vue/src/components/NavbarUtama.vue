<template>
    <div class="utama">
        <v-toolbar color="#E8F0F9" flat permanent app fixed height="50">
            <v-toolbar-title>
            <br>
                <img
                    class="align-center mt-3"
                    height="140px"
                    src="../assets/logo.png">
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-card
                color="#E8F0F9"
                v-for="item in items"
                :key="item.title"
                class="py-0 mt-8 mx-auto"
                :to = "item.to"
                flat>
                <v-btn text>
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

        <div class = "fullheight mt-9">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name : "utama",
        data() {
            return {
                items : [
                    { title : "Beranda", to:"/beranda"},
                    { title : "Pemesanan", to:"/pemesanan"},
                ],
            };
        },
        methods:{
            logout() {
                localStorage.removeItem('token')
                this.$router.push('/login')
            },
            prop(){
                this.$router.push('/profile')
            }
        }
    };
</script>

<style scope>
    .utama{
        background-color:#E8F0F9;
    }
</style>