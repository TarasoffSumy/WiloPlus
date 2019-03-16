<template>
<div>                
    <h3>Підібраний насос</h3>    
    <el-row>
        <el-col  :span="4" >                    
            <el-button @click="$emit('onDeletePump')" type="text" class="delete"><i style="font-size:22px" class="el-icon-circle-close-outline"></i></el-button> 
            <img class="img-pump" width="65" :src="url+'assets/wilo-spu4.jpg'"/>   
        </el-col>
        <el-col  :offset="1"  :span="19" >                    
            <h4 style="margin: 10px 0 15px 0;">ACTUN {{objSelectedPump.shortName}}</h4>
            <p>Тип живлення:</p>                
            <div v-for="item in objPump" :value="item" :key="item.id" class="radio-item-phasa" >
             <el-radio v-model="objPump.id" :label="item.id" @change="$emit('handleChangePhase', item.id)">
                <span v-if="item.features.phase=='1'"> 
                    <el-popover
                        placement="top-start"
                        width="250"
                        trigger="hover"
                        :content=dictionary[5].full_text>
                        <span type="text" class="myTip" slot="reference">однофазний</span>
                    </el-popover>                                            
                </span>
                <span v-if="item.features.phase=='3'">                                                    
                    <el-popover
                        placement="top-start"
                        width="250"
                        trigger="hover"
                        :content=dictionary[6].full_text>
                        <span type="text" class="myTip" slot="reference">трифазний</span>
                    </el-popover> 
                </span>           
            </el-radio>       
            </div>
            <p class="sub-title">Насосний агрегат {{objSelectedPump.name}}</p> 
            <p class="sub-title price">Ціна <span class="stronge-price">{{objSelectedPump.price | aroundPrice}}</span>грн з пдв</p>
            <p><span class="sub-title">Номінальна потужність двигуна</span> {{objSelectedPump.n_power}} kW </p>                               
            <el-collapse accordion> 
                <el-collapse-item>
                <template slot="title">
                    <p class="sub-title">Конструкція</p><i class="header-icon el-icon-info"></i>
                </template>                                        
                    <p>Багатоступеневий насос 4" із занурюваним двигуном, виконання з кожухом, для вертикальної або горизонтальної установки</p>                    
                </el-collapse-item>
            </el-collapse>
            <a class="download" :href="url+'assets/'+objSelectedPump.article+'.pdf'" download><i class="el-icon-document"></i> Завантажити лист даних насоса</a>                   
        </el-col>                
     </el-row>
     <el-row style="margin: 20px 0;">
        <el-col :offset=1 :span="5">                       
            <p><span class="sub-title point"></span></p>                        
            <p><span class="sub-title">Витрата</span></p> 
            <p><span class="sub-title">Напір</span></p>   
        </el-col>
        <el-col :span="10">                        
            <p><span class="sub-title point">Робоча точка отримана від користувача</span></p>                        
            <p> {{volumeFlow | aroundNumber}} м<sup>3</sup>/год</p> 
            <p>{{deliveryHead | aroundNumber}} м</p>                          
        </el-col>
        <el-col :span="6">                        
            <p><span class="sub-title point">Робоча точка фактична</span></p>                        
            <p> {{dataChart.CalcPoint[0].x | aroundNumber}} м<sup>3</sup>/год </p> 
            <p> {{dataChart.CalcPoint[0].y | aroundNumber}} м</p>                          
        </el-col>
    </el-row>
    <el-row>                    
        <Chart :key="id" :dataChart="dataChart" style="height: auto;width: 100%;"/>                 
    </el-row>
</div>
</template>
 
<script>
  export default {
    props: ['url', 'objSelectedPump', 'dataChart', 'volumeFlow', 'deliveryHead', 'objPump', 'dictionary' ],
    data() {        
      return {
        id: 0
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
.radio-item-phasa {
    display: inline-block;
    padding: 5px;
}
.sub-title {
    font-weight: 600
}
p.sub-title.price {
    margin: 15px 5px;
}
</style>