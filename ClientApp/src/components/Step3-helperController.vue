<template>
<div>
    {{controllers}}
    <p>4546546</p>
              <el-row class="accesorias-item" :gutter="20">
                <div v-for="item in controllers" :key="item.id">                
                <el-col v-if="!(paramOfSelectedPump.phase==3 && item.features.phase==1)">            
                    <el-card style="min-width:300px">                                   
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
                                Більше<i class="header-icon el-icon-info"></i>
                                </template>
                            <p class="text" v-html="item.features.description"></p>
                            <p><strong>Максимальний струм:</strong> {{item.features.current_max}} A </p>
                            <p><strong>Розміри:</strong> {{item.features.dim}}  </p>
                            <p><strong>Тип пуску насоса:</strong> {{item.features.start}}</p>
                            <p>
                              <strong>Управління:</strong> {{item.features.operation}}    
                            </p>                                                  
                            <p><el-popover
                                placement="top-start"
                                width="250"
                                trigger="hover"
                                :content=dictionary[7].full_text>
                                <el-button type="text"  slot="reference"><span class="myTip">Захист від сухого ходу:</span></el-button>
                                </el-popover> 
                                {{item.features.dry_running}}</p> 
                                
                                <a class="download" :href="url+'assets/'+item.features.OM+'.pdf'" download><i class="el-icon-document"></i> Завантажити інструкцію з експлуатації</a>
                                                                                        
                            </el-collapse-item>
                            </el-collapse>
                            <p >Ціна <span class="stronge-price">{{item.price*exchangeRates | aroundPrice}}</span>грн з пдв</p> 
                            <el-radio-group  v-model="selectedAccessories.item1.idController" @change="handleChange(item.id)">
                                <el-radio-button v-show="item.id!=selectedAccessories.item1.idController" type="primary" :label="item.id">Вибрати</el-radio-button>
                            </el-radio-group> 
                            <el-button v-show="item.id==selectedAccessories.item1.idController" type="primary" @click="ClearControllerSelect()">Відмінити</el-button>  
                    </el-card>
                </el-col>
                </div> 
            </el-row>
</div>
</template>
 
<script>
  export default {
    props: ['url', 'selectedAccessories', 'dictionary', 'controllers', 'paramOfSelectedPump' ],
    data() {        
      return {
        focusInput: 0
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
    },
    computed: {        
    },
    created:  function(){
    },
    methods: {       
    }
  };
</script>
<style >

</style>