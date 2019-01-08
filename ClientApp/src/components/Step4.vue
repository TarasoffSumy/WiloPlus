<template>
    <div id="print">
        <el-row>
        <div class="circle_numder">
            <svg height="55" width="53" class="circle">
            <circle cx="26" cy="26" r="24" stroke="" stroke-width="2" fill="" />
            </svg> <span>4 </span>            
        </div>
        <h2 class="title">Комерційна пропозиція</h2>       
        </el-row>
        <div class="alert-step4" v-if="message" >
            <h4> Прпозиція не сформована!</h4>
       
        Скористайтеся кроком 3 для підбору насоса

        </div>
        <div v-else>     
        <table  id="pump">
            <thead>
                <colgroup span="4"></colgroup>
                <tr>
                    <th>Найменування</th>
                    <th>Кількість, шт</th>
                    <th>Ціна, грн з ПДВ</th>
                    <th>Всього, грн з ПДВ</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="tableData.pump.selected" >
                    <td style="text-align:left: paddin-left:10px"><el-button type="text"
                    @click="handleDelete(0)"><i class="el-icon-error"></i></el-button>
                    Насас {{tableData.pump.name}}</td>
                    <td><el-input-number v-model="tableData.pump.amount" @change="handleChange()" :min="1" :max="10"></el-input-number></td>
                    <td>{{tableData.pump.price}}</td>
                    <td>{{tableData.pump.price*tableData.pump.amount}}</td>
                </tr>
                <tr v-if="tableData.controller.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(1)"><i class="el-icon-error"></i></el-button>
                    Коннтрелер {{tableData.controller.name}}</td>
                    <td><el-input-number v-model="tableData.controller.amount" @change="handleChange()" :min="1" :max="10"></el-input-number></td>
                    <td>{{tableData.controller.price}}</td>
                    <td>{{tableData.controller.price*tableData.controller.amount}}</td>
                </tr>
                <tr v-if="tableData.cable.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(2)"><i class="el-icon-error"></i></el-button>
                    {{tableData.cable.name}}</td>
                    <td><el-input-number v-model="tableData.cable.amount" @change="handleChange()" :min="1" :max="10"></el-input-number></td>
                    <td>{{tableData.cable.price}}</td>
                    <td>{{tableData.cable.price*tableData.cable.amount}}</td>
                </tr>
                <tr v-if="tableData.mufta.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(3)"><i class="el-icon-error"></i></el-button>
                    {{tableData.mufta.name}}</td>
                    <td><el-input-number v-model="tableData.mufta.amount" @change="handleChange()" :min="1" :max="10"></el-input-number></td>
                    <td>{{tableData.mufta.price}}</td>
                    <td>{{tableData.mufta.price*tableData.mufta.amount}}</td>
                </tr>
                <tr v-if="tableData.vessel.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(4)"><i class="el-icon-error"></i></el-button>
                    {{tableData.vessel.name}}</td>
                    <td><el-input-number v-model="tableData.vessel.amount" @change="handleChange()" :min="1" :max="10"></el-input-number></td>
                    <td>{{tableData.vessel.price}}</td>
                    <td>{{tableData.vessel.price*tableData.vessel.amount}}</td>
                </tr>
                <tr v-if="tableData.jecket.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(5)"><i class="el-icon-error"></i></el-button>
                    {{tableData.jecket.name}}</td>
                    <td><el-input-number v-model="tableData.jecket.amount" @change="handleChange()" :min="1" :max="10"></el-input-number></td>
                    <td>{{tableData.jecket.price}}</td>
                    <td>{{tableData.jecket.price*tableData.jecket.amount}}</td>
                </tr>
            </tbody>
        </table> 
        <h4>
            Всього: <span style="color:#222">{{amount}} грн з ПДВ</span> 
        </h4>
        </div>
    </div>   
</template>

<script>
  export default {
    props: ['url', 'pump', 'selectedPumpId', 'selectedAccessories'],
    data() {
      return {
        pumpId: this.selectedPumpId,
        objSelectedAccessories: this.selectedAccessories,
        message: false,
        tableData: {
            pump: {
                name: '',
                price: 0, 
                amount: 1,
                selected:true,
                id:''
                },
            controller:
            {
                name: 'Cabel 123',
                price: 0, 
                amount: 1,
                selected:false
            }, 
            cable:
            {
                name: 'Cabel 123',
                price: 0, 
                amount: 1,
                selected:false
            },
            mufta:
            {
                name: 'Cabel 123',
                price: 0, 
                amount: 1,
                selected:false
            },
            vessel:
            {
                name: 'Cabel 123',
                price: 0, 
                amount: 1,
                selected:false
            },
            jecket:
            {
                name: 'Cabel 123',
                price: 0, 
                amount: 1,
                selected:false
            },
        }
      }
    },
    created:function() {
         console.log(this.pumpId)
         if (this.pumpId) {
            this.message=false
            let sourse=this.pump
            let id=this.pumpId
            let pumpSelected=sourse.filter( function(el) {
                return el.id==id
                })   
            this.tableData.pump.name=pumpSelected[0].pump_name
            this.tableData.pump.price=pumpSelected[0].price
            console.log(this.objSelectedAccessories)
            if (this.objSelectedAccessories!=undefined) {
                if (this.objSelectedAccessories.item1.selected==true) {
                this.tableData.controller.name=this.objSelectedAccessories.item1.name
                this.tableData.controller.selected=this.objSelectedAccessories.item1.selected
                this.tableData.controller.price=this.objSelectedAccessories.item1.price
                }
                if (this.objSelectedAccessories.item2.selected==true) {
                this.tableData.cable.name=this.objSelectedAccessories.item2.name
                this.tableData.cable.selected=this.objSelectedAccessories.item2.selected
                this.tableData.cable.price=this.objSelectedAccessories.item2.price
                }
                if (this.objSelectedAccessories.item3.selected==true) {
                this.tableData.mufta.name=this.objSelectedAccessories.item3.name
                this.tableData.mufta.selected=this.objSelectedAccessories.item3.selected
                this.tableData.mufta.price=this.objSelectedAccessories.item3.price
                }
                if (this.objSelectedAccessories.item4.selected==true) {
                this.tableData.vessel.name=this.objSelectedAccessories.item4.name
                this.tableData.vessel.selected=this.objSelectedAccessories.item4.selected
                this.tableData.vessel.price=this.objSelectedAccessories.item4.price
                }
                if (this.objSelectedAccessories.item5.selected==true) {
                this.tableData.jecket.name=this.objSelectedAccessories.item5.name
                this.tableData.jecket.selected=this.objSelectedAccessories.item5.selected
                this.tableData.jecket.price=this.objSelectedAccessories.item5.price
                }  
            }             
         }
         else {
             this.message=true
         }

    },
    computed: {
    amount: function() {
       let sum =this.tableData.pump.price*this.tableData.pump.amount+
                this.tableData.jecket.price*this.tableData.jecket.amount+ 
                this.tableData.vessel.price*this.tableData.vessel.amount+
                this.tableData.mufta.price*this.tableData.mufta.amount+
                this.tableData.cable.price*this.tableData.cable.amount+
                this.tableData.controller.price*this.tableData.controller.amount  
      return sum.toFixed(1);
    }
    },
    methods: {
      handleChange() {

      },
      handleDelete(id) {
          if (id==0) {
               this.tableData.pump.selected=false
               this.tableData.pump.amount=0
          }
          if (id==1) {
               this.tableData.controller.selected=false
               this.tableData.controller.amount=0
          }
          if (id==2) {
               this.tableData.cable.selected=false
               this.tableData.cable.amount=0
          }
          if (id==3) {
               this.tableData.mufta.selected=false
               this.tableData.mufta.amount=0
          }
          if (id==4) {
               this.tableData.vessel.selected=false
               this.tableData.vessel.amount=0
          }
          if (id==5) {
               this.tableData.jecket.selected=false
               this.tableData.jecket.amount=0
          }
         
      }
    }
  }
</script>

<style scoped>
#pump {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
#pump td:first-child {
    text-align:left;
    padding-left:10px  
}


#pump td, #pump th {
  border: 1px solid #ddd;
  padding: 8px;
}

#pump tr:nth-child(even){background-color: #f2f2f2;}

#pump tr:hover {background-color: #ddd;}

#pump th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #f1f1f1;
  color: #4b4b4b;
  text-align: center;
}
.el-alert--warning {
    background-color: #fdf6ec;
    color: #e6a23c;
    padding: 20px 0 50px 35%;
    font-size: 18px;
}
.alert-step4 {
    background: #eee;
    padding: 20px;
    min-height: 50vh;
}
</style>

