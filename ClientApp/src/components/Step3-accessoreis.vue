<template>
    <div>
                <el-card  class="box-card" v-if="selectedAccessories.item1.selected">
                       
                        <el-col :span="2"><el-button @click="$emit('onDeleteAccessories', 1)"  type="text">
                            <i class="el-icon-circle-close-outline delete-accessories"></i></el-button>
                        </el-col>
                        <el-col :span="7">
                            <img :src="url+'assets/'+selectedAccessories.item1.img" width="100" alt="">
                        </el-col>
                        <el-col :span="15">
                            <p><strong>{{selectedAccessories.item1.name}}</strong></p>                                    
                            <p>{{this.service_dictionary[58]}} <span class="stronge-price">{{selectedAccessories.item1.price  | aroundPrice}}</span>{{this.service_dictionary[59]}} </p> 
                        </el-col>                
                </el-card>
                <el-card class="box-card" v-if="selectedAccessories.item2.selected"> 
                        
                        <el-col :span="2"><el-button @click="$emit('onDeleteAccessories', 2)" type="text">
                            <i class="el-icon-circle-close-outline delete-accessories"></i></el-button>
                        </el-col>
                        <el-col :span="7">   
                                <img :src="url+'assets/cable.jpg'" width="100" alt="">
                        </el-col>
                        <el-col :span="15">
                                <p><strong>{{selectedAccessories.item2.name}} </strong></p>
                                <p>{{this.service_dictionary[58]}} <span class="stronge-price">{{selectedAccessories.item2.price  | aroundPrice}}</span>{{this.service_dictionary[59]}}</p>   
                                <p>{{this.service_dictionary[83]}} <strong>{{selectedAccessories.item2.length}} </strong>  м</p>
                        </el-col>                                                          
                </el-card>
                <el-card class="box-card" v-if="selectedAccessories.item3.selected"> 
                     
                    <el-col :span="2"><el-button @click="$emit('onDeleteAccessories', 3)" type="text">
                        <i class="el-icon-circle-close-outline delete-accessories"></i></el-button> 
                    </el-col>
                    <el-col :span="7">
                            <img v-if="selectedAccessories.item3.type=='coupling filler'" :src="url+'assets/mufta_zal.jpg'" width="90px" alt="">
                            <img v-else-if="selectedAccessories.item3.type=='coupling thermo'" :src="url+'assets/mufta_termo.jpg'" width="90px" alt="">
                    </el-col>
                    <el-col :span="15">
                            <p><strong>{{selectedAccessories.item3.name}} </strong> </p>
                            <p>{{this.service_dictionary[58]}} <span class="stronge-price">{{selectedAccessories.item3.price | aroundPrice}}</span>{{this.service_dictionary[59]}}</p>   
                            <p>{{this.service_dictionary[99]}} <strong> {{selectedAccessories.item3.section}}</strong> мм<sup>2</sup></p>
                    </el-col>                
                </el-card>
                <el-card   class="box-card"  v-if="selectedAccessories.item4.selected"> 
                    
                    <el-col :span="2"><el-button @click="$emit('onDeleteAccessories', 4)" type="text">
                        <i class="el-icon-circle-close-outline delete-accessories"></i></el-button> 
                    </el-col>
                    <el-col :span="7">
                        <img :src="url+'assets/bak.jpg'" width="100px" alt="">
                    </el-col>
                    <el-col :span="15">
                            <p><strong>{{selectedAccessories.item4.name}} </strong> </p>
                            <p>{{this.service_dictionary[157]}} <strong>{{selectedAccessories.item4.volume}} </strong> {{this.service_dictionary[100]}} </p>
                            <p>{{this.service_dictionary[58]}} <span class="stronge-price">{{selectedAccessories.item4.price | aroundPrice}}</span>{{this.service_dictionary[59]}}</p>   
                    </el-col>                
                </el-card>
                <el-card class="box-card" v-if="selectedAccessories.item5.selected"> 
                    
                    <el-col :span="2"><el-button @click="$emit('onDeleteAccessories', 5)" type="text">
                        <i class="el-icon-circle-close-outline delete-accessories"></i></el-button> </el-col>
                    <el-col :span="7">
                        <img :src="url+'assets/jackets.jpg'" width="100px" alt="">
                    </el-col>
                    <el-col :span="15">
                        <p><strong>{{selectedAccessories.item5.name}} </strong> </p>
                        <p>{{this.service_dictionary[83]}}  <strong>{{selectedAccessories.item5.length}} </strong> {{this.service_dictionary[76]}} </p>
                        <p>{{this.service_dictionary[58]}} <span class="stronge-price">{{selectedAccessories.item5.price  | aroundPrice}}</span>{{this.service_dictionary[59]}}</p>
                    </el-col>                
                </el-card>  
    </div>
</template>
 
<script>
  export default {
    props: ['url', 'selectedAccessories', "service_dictionary" ],
    data() {        
      return {        
      }
    },
    filters: {
        aroundPrice: function (value) {
            let val = (value/1).toFixed(0)
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")+',- '
        },
        aroundNumber: function (value) {
            value = Number(value).toFixed(2)
            return value
        }
    }
  };
</script>
<style >
.mobile .box-card img {
    width: 65px
}
</style>