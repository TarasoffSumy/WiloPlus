<template>
<div>
    <el-dialog 
        class="helper-access"
        title=""
        :visible.sync="dialogVisible"
        width="80%"
        top="5vh">
        <Step3-helper 
            :url="url"
            :paramOfSelectedPump="paramOfSelectedPump"
            :selectedAccessories="selectedAccessories"
            :dataChart="dataChart"
            :volumeFlow="volumeFlow"
            :deliveryHead="deliveryHead"
            :exchangeRates="exchangeRates"
            :dictionary="dictionary"
            @onSelectController="onSelectController"
            @onSelectCable="onSelectCable"
            @onSelectMufta="onSelectMufta"
            @onSelectVessel="onSelectVessel"
            @onSelectJacket="onSelectJacket"
            @onCloseHelper="onCloseHelper"
            /> 
        <div slot="footer" class="dialog-footer-helper-access">       
            <el-row class="navigation-footer">
            <el-col :span="24">

            </el-col>
            </el-row>   
        </div>
    </el-dialog>
    <el-row>
        <div class="circle_number">
            <svg height="55" width="53" class="circle">
            <circle cx="26" cy="26" r="24" stroke="" stroke-width="2" fill="" />
            </svg> <span>3 </span>            
        </div>
        <h2 class="title">Підбір насоса та приладдя </h2>
    </el-row> 

    <el-tabs class="mobile" v-model="activeTab">
        <el-tab-pane label="Підібраний насос" name="first">
                    <div class="greyBox">               
            <div class="" v-if="refresh || isZeroHeadAndVolume">
                <el-card >
                    FIRST SPU4. <el-autocomplete
                    class="inline-input"
                        v-model="itemSelect"
                        :fetch-suggestions="querySearch"
                        placeholder="введіть серію насосу"
                        :trigger-on-focus="false"
                        @select="handleSelect"
                        ></el-autocomplete>                        
                </el-card>                                                
            </div>                 
            <ChartOut :dataOut="dataOut" v-show="!selectedPumpId" />             
            <div v-if="selectedPumpId">
                    <Step3-selectedPump
                    @onDeletePump="onDeletePump"
                    @handleChangePhase="handleChangePhase"
                    :url="url"
                    :dictionary="dictionary"
                    :objPump="objPump"
                    :objSelectedPump="objSelectedPump"
                    :dataChart="dataChart"
                    :volumeFlow="volumeFlow"
                    :deliveryHead="deliveryHead"
                    />
            </div>
        </div>
        <div v-show="!selectedPumpId" class="greyBox">
            <h3 style="text-align:left">Неможливо підібрати насос на введені параметри </h3>
            <p><i class="el-icon-info"></i>Спробуйте змінити напір та витрату</p>
        </div>
        </el-tab-pane>
        <el-tab-pane label="Приладдя" name="second">
           <span slot="label"><i class="el-icon-date"></i> Приладдя</span>
                <Step3-accessoreis
                    :selectedAccessories="selectedAccessories"
                    :url="url"
                    @onDeleteAccessories="onDeleteAccessories"
                />
        </el-tab-pane>
        <el-tab-pane label="Підібрати приладдя" name="third">
           <span slot="label"><i class="el-icon-date"></i> Підібрати приладдя</span>
            <Step3-helper 
            :url="url"
            :paramOfSelectedPump="paramOfSelectedPump"
            :selectedAccessories="selectedAccessories"
            :dataChart="dataChart"
            :volumeFlow="volumeFlow"
            :deliveryHead="deliveryHead"
            :exchangeRates="exchangeRates"
            :dictionary="dictionary"
            @onSelectController="onSelectController"
            @onSelectCable="onSelectCable"
            @onSelectMufta="onSelectMufta"
            @onSelectVessel="onSelectVessel"
            @onSelectJacket="onSelectJacket"
            @onCloseHelper="onCloseHelper"
            /> 
        </el-tab-pane>
    </el-tabs> 
    <div class="desktop">
        <div class="greyBoxes-container" v-loading="loading">        
            <div class="greyBox">               
                <div class="" v-if="refresh || isZeroHeadAndVolume">
                    <el-card >
                        FIRST SPU4. <el-autocomplete
                        class="inline-input"
                            v-model="itemSelect"
                            :fetch-suggestions="querySearch"
                            placeholder="введіть серію насосу"
                            :trigger-on-focus="false"
                            @select="handleSelect"
                            ></el-autocomplete>                        
                    </el-card>                                                
                </div>                 
                <ChartOut :dataOut="dataOut" v-show="!selectedPumpId" />             
                <div v-if="selectedPumpId">
                        <Step3-selectedPump
                        @onDeletePump="onDeletePump"
                        @handleChangePhase="handleChangePhase"
                        :url="url"
                        :dictionary="dictionary"
                        :objPump="objPump"
                        :objSelectedPump="objSelectedPump"
                        :dataChart="dataChart"
                        :volumeFlow="volumeFlow"
                        :deliveryHead="deliveryHead"
                        />
                </div>
            </div>
            <div v-show="!selectedPumpId" class="greyBox">
                <h3 style="text-align:left">Неможливо підібрати насос на введені параметри </h3>
                <p><i class="el-icon-info"></i>Спробуйте змінити напір та витрату</p>
            </div>
            <div v-show="selectedPumpId" class="greyBox last-box">
                <div class="box-helper-info">
                        <font-awesome-icon icon="lightbulb" />
                        <h3 style="text-align:left">Підібрати приладдя до насосу!</h3>                    
                        <div class="container-button">
                        <el-button class="calc-btn" style="margin-top: -20px;"  type="primary" @click="dialogVisible = true">
                        <img  width="20" :src="url+'assets/calc.png'">Підібрати</el-button> 
                        </div>                                    
                </div>             
                <div  v-if="existAccessories" class="item-selected">
                    <h3>Підібране приладдя</h3>
                    <Step3-accessoreis
                        :selectedAccessories="selectedAccessories"
                        :url="url"
                        @onDeleteAccessories="onDeleteAccessories"
                    />
                    <div style="margin:10px" v-if="allAccessoriesSelected"> Всі приладдя підбрані!</div>        
                </div>
            </div>         
        </div>
    </div>

</div> 
</template>

<script>
import Axios from "axios";
export default {
  props: [
    "volumeFlow",
    "deliveryHead",
    "dataChart",
    "pump",
    "allPumps",
    "selectedPumpId",
    "url",
    "selectedAccessories",
    "exchangeRates",
    "dictionary"
  ],
  data() {
    return {
      activeTab:'first',
      id: 1 ,
      idPump: this.selectedPumpId,
      objPump:this.pump,
      objDataChart:this.dataChart,
      refresh:false,
      loading: false,
      selectedAccessoriesRefresh:this.selectedAccessories,
      deliveryHeadInput: this.deliveryHead,
      deliveryHeadComputed: null,
      dialogVisible: false,
      itemSelect:'',
      paramOfSelectedPump: {
        phase: 0,
        current: 0,
        cosf: 0,
        U: 0,
        H2: 0
      }
    };
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
    mounted: function(){
       this.onSaveSelectedAccessories()      
    },
    computed: {
        dataOut: function() {
                let obj
                obj={
                    x: this.volumeFlow,
                    y: this.deliveryHead
                }
                return obj
        },
        objSelectedPump: function() {
            this.onSaveSelectedPumpId(this.selectedPumpId)
            this.objPump=this.pump
            let source=this.pump
            if (this.selectedPumpId) {
                let obj = {};
                for (let key in source) {
                    if (source[key].id == this.selectedPumpId) {        
                    obj.name = source[key].pump_name;
                    obj.price = (source[key].price*this.exchangeRates).toFixed(2);
                    obj.id = source[key].id;
                    this.objPump.id=obj.id;
                    obj.current = source[key].features.current;
                    obj.shortName = obj.name.split("/")[0];
                    obj.n_power = source[key].features.n_power;
                    obj.cosf = source[key].features.cosf;
                    obj.phase = source[key].features.phase;
                    obj.dim_H2 = source[key].features.dim_H2;
                    obj.article = source[key].article;
                    }
                }   
                this.paramOfSelectedPump=obj
                this.paramOfSelectedPump.U = obj.phase == 1 ? 230 : 400; 
                return obj             
            }
            else 
            {   
                return 
            }

        
        },
    existAccessories: function() {
      if (
        this.selectedAccessoriesRefresh.item1.selected != false ||
        this.selectedAccessoriesRefresh.item2.selected != false ||
        this.selectedAccessoriesRefresh.item3.selected != false ||
        this.selectedAccessoriesRefresh.item4.selected != false ||
        this.selectedAccessoriesRefresh.item5.selected != false  ) 
        {
            return true;
        }
    },
    allAccessoriesSelected: function() {
      if (
            this.selectedAccessoriesRefresh.item1.selected  &&
            this.selectedAccessoriesRefresh.item2.selected  &&
            this.selectedAccessoriesRefresh.item4.selected  &&
            this.selectedAccessoriesRefresh.item5.selected 
        ) 
        {
           //this.onDialogAccept()
            return true;
        }
    },

    isZeroHeadAndVolume: function() {
        if (this.deliveryHead==0 && this.volumeFlow==0) {
        return true
        }
    }

  },
  
  methods: {
    onDeletePump(){ 
        this.refresh=!this.refresh 
       // this.selectedPumpId=0
    },
    onCloseHelper: function(){
        this.onDialogAccept()
    },
    handleSelect(itemSelect) {
        this.loading=true
        this.idPump=itemSelect.id
        this.postDataGetDetail(itemSelect.id)
        this.onSaveSelectedPumpId(itemSelect.id)         
        this.onClearAccessories()         
        this.refresh=true 
          
    },              
    querySearch(queryString, cb) {
        var links = this.allPumps;
        var results = queryString ? links.filter(this.createFilter(queryString)) : links;
        cb(results);
        },
    createFilter(queryString) {
        return (link) => {
        return (link.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
        };
        },
    onSaveSelectedPumpId(id) {
      this.$emit("onSaveSelectedPumpId", id);
    },
    onRefreshDataPump(obj) {
      this.$emit("onRefreshDataPump", obj);
      
    },
    onClearItemAccessoriesDependetCurrent() {
        this.onDeleteAccessories(1)
        this.onDeleteAccessories(2)
        this.onDeleteAccessories(3)
    },
    onClearAccessories() {
      if (  this.selectedAccessoriesRefresh.item1.selected != false ||
            this.selectedAccessoriesRefresh.item2.selected != false ||
            this.selectedAccessoriesRefresh.item3.selected != false)
         {
             this.$notify({
                title: 'Увага',
                message: 'Обрані приладдя, залежні від струму, видалені!',
                type: 'warning'
                });
                this.onClearItemAccessoriesDependetCurrent()        
      }  
    },
    handleChangePhase(id) {
      this.idPump=id
      this.onSaveSelectedPumpId(id)
      this.onClearAccessories()   
    },
    onSelectController(id, dataControlBox) {
      this.selectedAccessoriesRefresh.item1.idController = id;
      this.selectedAccessoriesRefresh.item1.name = dataControlBox[0].name;
      this.selectedAccessoriesRefresh.item1.article = dataControlBox[0].article;
      this.selectedAccessoriesRefresh.item1.price = (dataControlBox[0].price*this.exchangeRates).toFixed(2);
      this.selectedAccessoriesRefresh.item1.current_max = dataControlBox[0].features.current_max;
      this.selectedAccessoriesRefresh.item1.description = dataControlBox[0].features.description;
      this.selectedAccessoriesRefresh.item1.dim = dataControlBox[0].features.dim;
      this.selectedAccessoriesRefresh.item1.img = dataControlBox[0].features.img;
      this.selectedAccessoriesRefresh.item1.selected = true;
      this.onSaveSelectedAccessories()
    },
    onSelectCable(cable, id) {
      this.selectedAccessoriesRefresh.item2.idCable = id
      this.selectedAccessoriesRefresh.item2.name = cable.name
      this.selectedAccessoriesRefresh.item2.article = cable.article
      this.selectedAccessoriesRefresh.item2.price = (cable.price*this.exchangeRates).toFixed(2)
      this.selectedAccessoriesRefresh.item2.length = cable.length
      this.selectedAccessoriesRefresh.item2.selected = true
      this.onSaveSelectedAccessories()
    },
    onSelectMufta(id, mufta) {
      this.selectedAccessoriesRefresh.item3.idMufta = id
      this.selectedAccessoriesRefresh.item3.name = mufta[0].name
      this.selectedAccessoriesRefresh.item3.article =mufta[0].article 
      this.selectedAccessoriesRefresh.item3.price = (mufta[0].price*this.exchangeRates).toFixed(2)
      this.selectedAccessoriesRefresh.item3.type = mufta[0].features.type
      this.selectedAccessoriesRefresh.item3.section = mufta[0].features.section
      this.selectedAccessoriesRefresh.item3.selected = true
      this.onSaveSelectedAccessories()
    },
    onSelectVessel(id, vessel) {
      this.selectedAccessoriesRefresh.item4.idVessel = id
      this.selectedAccessoriesRefresh.item4.volume = vessel.features.volume
      this.selectedAccessoriesRefresh.item4.name = vessel.name
      this.selectedAccessoriesRefresh.item4.article = vessel.article
      this.selectedAccessoriesRefresh.item4.price = (vessel.price*this.exchangeRates).toFixed(2)
      this.selectedAccessoriesRefresh.item4.selected = true
      this.onSaveSelectedAccessories()
    },
    onSelectJacket(id, jacket, type) {
      this.selectedAccessoriesRefresh.item5.idJacket = id;
      this.selectedAccessoriesRefresh.item5.length = jacket.features.length;
      this.selectedAccessoriesRefresh.item5.name = jacket.name;
      this.selectedAccessoriesRefresh.item5.article = jacket.article;
      this.selectedAccessoriesRefresh.item5.price = (jacket.price*this.exchangeRates).toFixed(2);
      this.selectedAccessoriesRefresh.item5.typeInstallationjackets=type
      this.selectedAccessoriesRefresh.item5.selected = true;      
      this.onSaveSelectedAccessories()
    },
    onSaveSelectedAccessories(){
      let obj=this.selectedAccessoriesRefresh
      this.$emit("onSaveSelectedAccessories", obj);
    },
    onDialogAccept() {
      this.dialogVisible = false;
    },
    onDeleteAccessories(id) {
      this.selectedAccessoriesRefresh['item'+id].selected = false;
      if (id==1) {
          this.selectedAccessoriesRefresh['item'+id].idController=undefined;
      }
      if (id==2) {
          this.selectedAccessoriesRefresh['item'+id].idCable=undefined;
          this.selectedAccessoriesRefresh['item'+id].length=0;                    
      }
      if (id==3) {
          this.selectedAccessoriesRefresh['item'+id].idMufta=undefined;
      }
      if (id==4) {
          this.selectedAccessoriesRefresh['item'+id].idVessel=undefined;
      }
      if (id==5) {
          this.selectedAccessoriesRefresh['item'+id].idJacket=undefined;
          this.selectedAccessories['item'+id].typeInstallationjackets=0;
      }
    },
    postDataGetDetail: function(id) {
                const getPromise = Axios.post(this.url+'db/getDetails', {"id":id});
                getPromise.then(response => {
                    this.objPump = response.data;
                    if (this.objPump!=undefined) {
                     this.onRefreshDataPump(this.objPump)
                     this.$emit("onGetDataChart", this.objPump);  
                     this.id ++    
                     this.loading=false              
                }
                else {
                    this.refreshDataSearch=false 
                    this.loading=false 
                } 
                });
    }
  }
};
</script>

<style>
.img-pump{
    width: 65px;
    float: right;
    margin: 40px 0 0 -15px;
}
.el-button.delete.el-button--text {
    position: relative;
    top: 119px;
}
i.el-icon-circle-close-outline.delete-accessories {
    position: relative;
    top: 15px;
}
span.el-alert__title.is-bold {
    color: #555;
}
.greyBox {
  text-align: left;
  min-height: 100px;
}
.greyBox p {
  margin: 5px;
}
.box-helper-info {
    background: #f6f6f6;
    margin-top: -20px;
    height: 139px;
    padding: 20px 20px 10px 20px;
    width: 99%;
}
.last-box {
    background: none
}
.accessories img {
    padding-bottom: 30px
}
.item-selected {
    text-align: left;
    background: #f6f6f6;
    padding: 20px 23px;
    margin-top: 25px;
    width: 98%;
}
.item-selected i {
    font-size: 20px;
}
.item-selected .expand-view {
    display: none
} 
.el-card.box-card.is-always-shadow {
    margin-bottom: 5px;
    padding-bottom: 20px;
}
.sub-title {
    font-weight: 600
}
p.sub-title.price {
    margin: 15px 5px;

}
span.sub-title.point {
    min-height: 40px;
    padding: 5px 0;
    display: block;
    margin-top: 0;
    border-bottom: solid 1px #c4c0c0;
}
.navigation-footer.el-row {
    margin-bottom: 20px;
}
</style>

