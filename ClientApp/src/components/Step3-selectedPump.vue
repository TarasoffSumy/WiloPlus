<template>
<div>                
    <h3>{{service_dictionary[54]}}</h3>    
    <el-row>
        <el-col  :span="4" >                    
            <el-button @click="$emit('onDeletePump')" type="text" class="delete"><i style="font-size:22px" class="el-icon-circle-close-outline"></i></el-button> 
            <img class="img-pump" width="65" :src="url+'assets/wilo-spu4.jpg'"/>   
        </el-col>
        <el-col  :offset="1"  :span="19" >                    
            <h4 style="margin: 10px 0 15px 0;">ACTUN {{objSelectedPump.shortName}}</h4>
            <p>{{service_dictionary[132]}}</p>                
            <div v-for="item in objPump" :value="item" :key="item.id" class="radio-item-phasa" >
             <el-radio v-model="objPump.id" :label="item.id" @change="$emit('handleChangePhase', item.id)">
                <span v-if="item.features.phase=='1'"> 
                    <el-popover
                        placement="top-start"
                        width="250"
                        trigger="hover"
                        :content=service_dictionary[142]>
                        <span type="text" class="myTip" slot="reference">{{service_dictionary[55]}}</span>
                    </el-popover>                                            
                </span>
                <span v-if="item.features.phase=='3'">                                                    
                    <el-popover
                        placement="top-start"
                        width="250"
                        trigger="hover"
                        :content=service_dictionary[143]>
                        <span type="text" class="myTip" slot="reference">{{service_dictionary[56]}}</span>
                    </el-popover> 
                </span>           
            </el-radio>       
            </div>
            <p class="sub-title">{{service_dictionary[57]}} {{objSelectedPump.name}}</p> 
            <p class="sub-title price">{{service_dictionary[58]}} <span class="stronge-price">{{objSelectedPump.price | aroundPrice}}</span>{{service_dictionary[59]}} </p>
            <p><span class="sub-title">{{service_dictionary[60]}}</span> {{objSelectedPump.n_power}} kW </p>                               
            <el-collapse accordion> 
                <el-collapse-item>
                <template slot="title">
                    <p class="sub-title">{{service_dictionary[61]}}</p><i class="header-icon el-icon-info"></i>
                </template>                                        
                    <p>{{service_dictionary[62]}}</p>                    
                </el-collapse-item>
            </el-collapse>
            <a class="download" :href="url+'assets/'+objSelectedPump.article+'.pdf'" download><i class="el-icon-document"></i>{{service_dictionary[63]}} </a>                   
        </el-col>                
     </el-row>
     <el-row style="margin: 20px 0;">
        <el-col :offset=1 :span="5">                       
            <p><span class="sub-title point"></span></p>                        
            <p><span class="sub-title">{{service_dictionary[64]}}</span></p> 
            <p><span class="sub-title">{{service_dictionary[65]}}</span></p>   
        </el-col>
        <el-col :span="10">                        
            <p><span class="sub-title point">{{service_dictionary[66]}}</span></p>                        
            <p> {{volumeFlow | aroundNumber}} м<sup>3</sup>/{{service_dictionary[7]}}</p> 
            <p>{{deliveryHead | aroundNumber}} м</p>                          
        </el-col>
        <el-col :span="6">                        
            <p><span class="sub-title point">{{service_dictionary[68]}}</span></p>                        
            <p> {{dataChart.CalcPoint[0].x | aroundNumber}} м<sup>3</sup>/{{service_dictionary[7]}} </p> 
            <p> {{dataChart.CalcPoint[0].y | aroundNumber}} м</p>                          
        </el-col>
    </el-row>
    <el-row>                    
        <Chart :key="id" :dataChart="dataChart" :service_dictionary="service_dictionary" style="height: auto;width: 100%;"/>                 
    </el-row>
</div>
</template>
 
<script>
  export default {
    props: ['url', 'objSelectedPump', 'dataChart', 'volumeFlow', 'deliveryHead', 'objPump', "service_dictionary" ],
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
    margin: 15px 0px;
}
</style>