<template>
<div>
        <el-row class="accesorias-item" :gutter="20">
            <div v-for="item in controllers" :key="item.id">         
                       <!--  -->
                <el-col>            
                    <el-card v-if="!(paramOfSelectedPump.phase==3 && item.features.phase==1)" style="min-width:300px">                                   
                                <div style="float:right">
                                    <img v-if="item.features.class=='Економ'" :src="url+'assets/econom.jpg'" width="70px" alt="">
                                    <img v-if="item.features.class=='Стандарт'" :src="url+'assets/standart.jpg'" width="70px" alt="">
                                    <img v-if="item.features.class=='Преміум'" :src="url+'assets/premium.jpg'" width="70px" alt="">
                                </div> 
                                <img :src="url+'assets/'+item.features.img"  class="image"> 
                            <p class="stronge-price">{{item.name}}</p>                        
                            <el-collapse accordion> 
                            <el-collapse-item name="1">
                                <template slot="title">
                                {{service_dictionary[69]}}<i class="header-icon el-icon-info"></i>
                                </template>
                            <p class="text" v-html="item.features.description"></p>
                            <p><strong>{{service_dictionary[86]}}</strong> {{item.features.current_max}} A </p>
                            <p><strong>{{service_dictionary[87]}}</strong> {{item.features.dim}}  </p>
                            <p><strong>{{service_dictionary[88]}}</strong> {{item.features.start}}</p>
                            <p>
                              <strong>{{service_dictionary[89]}}</strong> {{item.features.operation}}    
                            </p>                                                  
                            <p><el-popover
                                placement="top-start"
                                width="250"
                                trigger="hover"
                                :content=service_dictionary[144]>
                                <el-button type="text"  slot="reference"><span class="myTip">{{service_dictionary[90]}}</span></el-button>
                                </el-popover> 
                                {{item.features.dry_running}}</p>                                
                                <a class="download" :href="url+'assets/'+item.features.OM+'.pdf'" download><i class="el-icon-document"></i>{{service_dictionary[82]}}</a>                                                          
                            </el-collapse-item>
                            </el-collapse>
                            <p><span class="stronge-price">{{item.price*exchangeRates | aroundPrice}}</span>{{service_dictionary[59]}}</p> 
                            <el-radio-group  v-model="selectedAccessories.item1.idController" @change="$emit('handleChange', item.id)">
                                <el-radio-button v-show="item.id!=selectedAccessories.item1.idController" type="primary" :label="item.id">{{service_dictionary[80]}}</el-radio-button>
                            </el-radio-group> 
                            <el-button v-show="item.id==selectedAccessories.item1.idController" type="primary" @click="$emit('ClearControllerSelect')">{{service_dictionary[81]}}</el-button>  
                    </el-card>
                </el-col>
            </div> 
        </el-row>
</div>
</template>
 
<script>
  export default {
    props: ['url', 'selectedAccessories', "service_dictionary", 'controllers', 'paramOfSelectedPump', 'exchangeRates' ],
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
<style>
.image {
    display: block;
    height: 100px;
    padding: 0 0 0 14%;
    margin: 0 auto;
    }
</style>
