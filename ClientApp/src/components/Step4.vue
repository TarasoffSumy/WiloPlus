<template>
    <div v-loading="loading">      
        <p class="hidden-xs-only" ></p>
        <el-dialog title="" 
                :visible.sync="dialogFormVisible"
                :send="send"
                :fullscreen="fullscreenOpen"
                width="35%"                
                top="5vh">
            <h3>Ви можете зазначити свою особисту інформацію для відображення у верхньому колонтитулі</h3>
            <el-form :model="form" label-position="left" padding="25px">
                <el-form-item label="ПІБ" >
                    <el-input v-model="form.name" autocomplete="off"></el-input>            
                </el-form-item>

                <el-form-item label="Фірма" >
                <el-input v-model="form.company" autocomplete="off"></el-input>
                </el-form-item>

                <el-form-item label="Телефон" >
                <el-input v-model="form.tel" autocomplete="off"></el-input>
                </el-form-item>

                <el-form-item label="Email"> 
                <el-input v-model="form.email" autocomplete="off"></el-input>
                </el-form-item>

                <el-form-item label="Картка Wiloexpert">
                <el-input v-model="form.wiloexpertCard" autocomplete="off"></el-input>
                </el-form-item>

                <el-form-item label="">
                    <el-checkbox v-model="form.condition" @change="$v.form.condition.$touch()">   
                        <el-popover
                        placement="right-start"
                        width="500"
                        trigger="click">
                        <div style="background:#efeded; padding: 1px 20px;">
                            <p>Заповненням цієї форми  я надаю згоду на обробку моїх персональних даних з метою організації системи управління взаємовідносин з партнерами та контрагентами, зберігання в базах  даних ТОВ «ВІЛО УКРАЇНА»: 1С, CRM; на web-сайті  wiloexpert.ua; CRM-системі Групи компаній Wilo та на web-сайті <a href="https://wilo.com/en/Legal.html#.WbaDk9NJalM"></a>https://wilo.com</p>
                            <p>Під обробкою моїх персональних даних, згоду на яку я надаю добровільно, мається на увазі будь-яка дія та/або сукупність дій, таких як збирання, реєстрація, накопичення, зберігання, адаптування, зміна, поновлення, використання і поширення (розповсюдження, реалізація, передача), знеособлення, знищення персональних даних, у тому числі з використанням інформаційних (автоматизованих) систем.</p>
                            <p>Я підтверджую, що ознайомлений зі змістом ЗУ «Про захист персональних даних» та основними положеннями Регламенту (ЄС) 2016/679 Європейського парламенту та Європейської ради від 27 квітня 2016 року «Про захист фізичних осіб стосовно обробки персональних даних та про вільне переміщення таких даних та скасування Директиви 95/46 / ЄС (Загальний порядок захисту персональних даних)»</p>    
                        </div>                        
                        <el-button type="text"  slot="reference"><span>Згода на обробку моїх персональних даних</span></el-button>
                    </el-popover>                                
                    </el-checkbox> 
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Відмінити</el-button>
                <el-button  type="primary" @click="dialogSendForm(send)">Зберегти</el-button>
            </span>

                <div  v-show="showValidationMesseges">
                    <span v-show="send" class="exeption-validation" v-if="!$v.form.email.required">
                    Email обов'язковий </span>
                    <span v-show="send" class="exeption-validation" v-if="!$v.form.email.email">
                    Невірний формат email адреси </span>
                    <span class="exeption-validation" v-if="!$v.form.condition.sameAs">
                    Підтвердіть умову про обробку персональних данних </span>
                </div>
            </el-dialog>
        <el-row>
        <div class="circle_number">
            <svg height="55" width="53" class="circle">
            <circle cx="26" cy="26" r="24" stroke="" stroke-width="2" fill="" />
            </svg> <span>4 </span>            
        </div>
        <h2 class="title">Комерційна пропозиція</h2>       
        </el-row>
        <div class="alert-step4" v-if="message" >
            <h4> Пропозиція не сформована!</h4>       
        Скористайтеся кроком 3 для підбору насоса
        </div>
        <div v-else>  
        <table  id="pumps-accessorias">
            <thead>
                <colgroup span="4"></colgroup>
                <tr>
                    <th>{{thead.name}}</th>
                    <th>{{thead.article}}</th>
                    <th>{{thead.qty}}</th>                    
                    <th>{{thead.price}}</th>
                    <th>{{thead.total}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="tableData.pump.selected" >
                    <td style="text-align:left: paddin-left:10px">
                        
                        <el-button type="text"  @click="handleDelete(0)"><i class="el-icon-error"></i></el-button>
                        <span class="name-equipment">Насос {{tableData.pump.name}}</span>
                    </td>
                    <td :data-label='thead.article'>{{tableData.pump.article}}</td>
                    <td :data-label='thead.qty'><el-input-number v-model="tableData.pump.qty" :min="1" ></el-input-number></td>
                    
                    <td :data-label='thead.price'>{{tableData.pump.price | aroundNumber}}</td>
                    <td :data-label='thead.total'>{{tableData.pump.price*tableData.pump.qty | aroundNumber}}</td>
                </tr>
                <tr v-if="tableData.controller.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(1)"><i class="el-icon-error"></i></el-button>
                    <span class="name-equipment">{{tableData.controller.name}}</span></td>
                    <td :data-label='thead.article'>{{tableData.controller.article}}</td>
                    <td :data-label='thead.qty'><el-input-number v-model="tableData.controller.qty" :min="1" ></el-input-number></td>
                    <td :data-label='thead.price'>{{tableData.controller.price | aroundNumber}}</td>
                    <td :data-label='thead.total'>{{tableData.controller.price*tableData.controller.qty | aroundNumber}}</td>
                </tr>
                <tr v-if="tableData.cable.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(2)"><i class="el-icon-error"></i></el-button>
                    <span class="name-equipment">{{tableData.cable.name}}</span></td>
                    <td :data-label='thead.article'>{{tableData.cable.article}}</td>
                    <td :data-label='thead.qty'>
                        <el-tooltip content="Зміна можлива через вибір приладдя" placement="top">
                        <el-input-number  @change="handleChangeCable()" :disabled="true" v-model="tableData.cable.qty" :min="1" ></el-input-number>
                        </el-tooltip>
                    </td>
                    <td :data-label='thead.price'>{{tableData.cable.price | aroundNumber}}</td>
                    <td :data-label='thead.total'>{{tableData.cable.price*tableData.cable.qty | aroundNumber}}</td>
                </tr>
                <tr v-if="tableData.mufta.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(3)"><i class="el-icon-error"></i></el-button>
                    <span class="name-equipment">{{tableData.mufta.name}}</span></td>
                    <td :data-label='thead.article'>{{tableData.mufta.article}}</td>
                    <td :data-label='thead.qty'><el-input-number v-model="tableData.mufta.qty" :min="1"></el-input-number></td>
                    <td :data-label='thead.price'>{{tableData.mufta.price | aroundNumber}}</td>
                    <td :data-label='thead.total'>{{tableData.mufta.price*tableData.mufta.qty | aroundNumber}}</td>
                </tr>
                <tr v-if="tableData.vessel.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(4)"><i class="el-icon-error"></i></el-button>
                    <span class="name-equipment">{{tableData.vessel.name}}</span></td>
                    <td :data-label='thead.article'>{{tableData.vessel.article}}</td>
                    <td :data-label='thead.qty'><el-input-number v-model="tableData.vessel.qty" :min="1"></el-input-number></td>
                    <td :data-label='thead.price'>{{tableData.vessel.price | aroundNumber}}</td>
                    <td :data-label='thead.total'>{{tableData.vessel.price*tableData.vessel.qty | aroundNumber}}</td>
                </tr>
                <tr v-if="tableData.jacket.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(5)"><i class="el-icon-error"></i></el-button>
                    <span class="name-equipment">{{tableData.jacket.name}}</span></td>
                    <td :data-label='thead.article'>{{tableData.jacket.article}}</td>
                    <td :data-label='thead.qty'><el-input-number v-model="tableData.jacket.qty" :min="1"></el-input-number></td>
                    <td :data-label='thead.price'>{{tableData.jacket.price | aroundNumber}}</td>
                    <td :data-label='thead.total'>{{tableData.jacket.price*tableData.jacket.qty | aroundNumber}}</td>
                </tr>
            </tbody>
        </table> 
        <p style="text-align:center" class="sub-title price">Ціна <span class="stronge-price">{{qty | aroundNumber}}</span>грн з пдв</p>  
        <el-row>
          <el-button  @click="dialogOpenEmail" type="info" icon="el-icon-message">Надіслати </el-button>
          <el-button  @click="dialogOpenPrint" type="info" icon="el-icon-printer">Друк пропозиції </el-button>           
        </el-row>
        </div>
    </div>   
</template>

<script>
import Axios from 'axios';
import { required, minLength, between, email, sameAs } from 'vuelidate/lib/validators';
  export default {
    props: ['url', 'pump', 'qtyPump', 'selectedPumpId', 'selectedAccessories', "exchangeRates", "volumeFlow", "deliveryHead"],
    data() {
      return {
        loading: false,
        thead: {
            name :'Найменування',
            article:'Артикул',
            qty:'Кількість, од/м',
            price:'Ціна, грн з пдв',
            total:'Всього, грн з пдв'
        },
        showValidationMesseges:false,
        pumpId: this.selectedPumpId,
        objSelectedAccessories: this.selectedAccessories,
        message: false,
        fullscreenIf: false,
        send:'',
        dialogFormVisible: false,
        formLabelWidth: '130px',
        sendObj:'',
        form: {
            company:'',
            name:'',
            tel:'',
            email:'',
            wiloexpertCard:'',
            condition: false
        },
        tableData: {
            pump: {
                name: '',
                article:'',
                price: 0, 
                qty: 1,
                selected:true,
                id:0
                },
            controller:
            {
                name: 'Cabel 123',
                article:'',
                price: 0, 
                qty: 1,
                selected:false,
                id:0
            }, 
            cable:
            {
                name: 'Cabel 123',
                article:'',
                price: 0, 
                qty: 1,
                selected:false,
                id:0
            },
            mufta:
            {
                name: 'Cabel 123',
                article:'',
                price: 0, 
                qty: 1,
                selected:false,
                id:0
            },
            vessel:
            {
                name: 'Cabel 123',
                article:'',
                price: 0, 
                qty: 1,
                selected:false,
                id:0
            },
            jacket:
            {
                name: 'Cabel 123',
                article:'',
                price: 0, 
                qty: 1,
                selected:false,
                id:0
            }
        }
      }
    },
    validations: {
        form: {
            email: {
                required,
                email
                },
            condition: {
                sameAs: sameAs( () => true )
            }
        },
        validationGroupEmail: ['form.email', 'form.condition'],
        validationGroupPrint: ['form.condition']
    },
    filters: {
    aroundNumber: function (value) {
        let val = (value/1).toFixed(0)
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")+',- '
    }
    },
    created:function() {     
         if (this.pumpId) {
            this.message=false
            let sourse=this.pump
            let id=this.pumpId
            let pumpSelected=sourse.filter( function(el) {
                return el.id==id
            })  
            this.tableData.pump.id=pumpSelected[0].id 
            this.tableData.pump.qty=this.qtyPump
            this.tableData.pump.name=pumpSelected[0].pump_name
            this.tableData.pump.article=pumpSelected[0].article
            this.tableData.pump.price=(pumpSelected[0].price*this.exchangeRates).toFixed(2)
            if (this.objSelectedAccessories!=undefined) {
                if (this.objSelectedAccessories.item1.selected==true) {
                this.tableData.controller.name=this.objSelectedAccessories.item1.name
                this.tableData.controller.article=this.objSelectedAccessories.item1.article
                this.tableData.controller.selected=this.objSelectedAccessories.item1.selected
                this.tableData.controller.price=this.objSelectedAccessories.item1.price
                this.tableData.controller.id=this.objSelectedAccessories.item1.idController
                this.tableData.controller.qty=this.objSelectedAccessories.item1.qty
                }
                if (this.objSelectedAccessories.item2.selected==true) {
                this.tableData.cable.name=this.objSelectedAccessories.item2.name
                this.tableData.cable.article=this.objSelectedAccessories.item2.article
                this.tableData.cable.qty=this.objSelectedAccessories.item2.length
                this.tableData.cable.selected=this.objSelectedAccessories.item2.selected
                this.tableData.cable.price=this.objSelectedAccessories.item2.price
                this.tableData.cable.id=this.objSelectedAccessories.item2.idCable
                }
                if (this.objSelectedAccessories.item3.selected==true) {
                this.tableData.mufta.name=this.objSelectedAccessories.item3.name
                this.tableData.mufta.article=this.objSelectedAccessories.item3.article
                this.tableData.mufta.selected=this.objSelectedAccessories.item3.selected
                this.tableData.mufta.price=this.objSelectedAccessories.item3.price
                this.tableData.mufta.id=this.objSelectedAccessories.item3.idMufta
                this.tableData.mufta.qty=this.objSelectedAccessories.item3.qty
                }
                if (this.objSelectedAccessories.item4.selected==true) {
                this.tableData.vessel.name=this.objSelectedAccessories.item4.name
                this.tableData.vessel.article=this.objSelectedAccessories.item4.article
                this.tableData.vessel.selected=this.objSelectedAccessories.item4.selected
                this.tableData.vessel.price=this.objSelectedAccessories.item4.price
                this.tableData.vessel.id=this.objSelectedAccessories.item4.idVessel
                this.tableData.vessel.qty=this.objSelectedAccessories.item4.qty
                }
                if (this.objSelectedAccessories.item5.selected==true) {
                this.tableData.jacket.name=this.objSelectedAccessories.item5.name
                this.tableData.jacket.article=this.objSelectedAccessories.item5.article
                this.tableData.jacket.selected=this.objSelectedAccessories.item5.selected
                this.tableData.jacket.price=this.objSelectedAccessories.item5.price
                this.tableData.jacket.id=this.objSelectedAccessories.item5.idJacket
                this.tableData.jacket.qty=this.objSelectedAccessories.item5.qty
                }  
            }             
         }
         else {
             this.message=true
        }
    },
    computed: {
        fullscreenOpen: function(){
            if (window.innerWidth < 600) 
                return true
            else
                return false
            },
        qty: function() {
            let sum =this.tableData.pump.price*this.tableData.pump.qty+
                    this.tableData.jacket.price*this.tableData.jacket.qty+ 
                    this.tableData.vessel.price*this.tableData.vessel.qty+
                    this.tableData.mufta.price*this.tableData.mufta.qty+
                    this.tableData.cable.price*this.tableData.cable.qty+
                    this.tableData.controller.price*this.tableData.controller.qty  
            return sum.toFixed(1);
            }  
    },
    methods: {
        dialogOpenEmail(){
            this.send=true
            this.dialogFormVisible=true
            },
        dialogOpenPrint(){
            this.send=false
            this.dialogFormVisible=true
            },
        onCreateSendObj() {
            let source=this.tableData
            let idArr=[]
            let gtyArr=[]
            for(let key in source)
            {
                if (source[key].id!=0 && source[key].qty!=0)  {
                idArr.push(source[key].id)
                gtyArr.push(source[key].qty)
                }
            }
            this.sendObj= {
                            id: idArr,  
                            qty:gtyArr, 
                            volumeFlow: this.volumeFlow, 
                            deliveryHead: this.deliveryHead,
                            form: {
                                company: this.form.company,
                                name: this.form.name,
                                tel: this.form.tel,
                                email: this.form.email,
                                wiloexpertCard:this.form.wiloexpertCard,
                                condition: this.form.condition
                            }
                            }
            },  
        dialogSendForm(send){
            if (send==true) {
                this.dialogSendFormEmail()
            }
            else
            {
                this.dialogSendFormPrint()
            }
            },
        dialogSendFormEmail(){
            this.showValidationMesseges=true
            this.loading=true
            if (!this.$v.validationGroupEmail.$invalid){
                this.onCreateSendObj()
                this.sendObj.sendEmail=true
                let jsonObj=JSON.stringify(this.sendObj)
                this.dialogFormVisible=false            
                
                const getPromise = Axios.post(this.url+'db/printOffer', jsonObj);                
                    getPromise.then(response => {
                        this.loading=false
                        this.$notify({
                            title: response.data['status'].title,
                            message: response.data['status'].message,
                            type: response.data['status'].priority
                        });
                    });             
            }
            },
        dialogSendFormPrint(){
            this.showValidationMesseges=true
            if (!this.$v.validationGroupPrint.$invalid){
                this.onCreateSendObj()            
                this.sendObj.sendEmail=false
                let jsonObj=JSON.stringify(this.sendObj)
                this.dialogFormVisible=false
                    const getPromise = Axios.post(this.url+'db/printOffer', jsonObj);                
                    getPromise.then(response => {
                        var allUrl=this.url+'db/printOffer'
                        function OpenPdf() {
                            window.open(allUrl, '_blank');
                        }
                        setTimeout(OpenPdf, 1000);
                        
                    });               
            }
            },
      handleDelete(id) {
            if (id==0) {
                this.tableData.pump.selected=false
                this.tableData.pump.qty=0
            }
            if (id==1) {
                    this.tableData.controller.selected=false
                    this.tableData.controller.qty=0
                    this.selectedAccessories.item1.idController=undefined
                    this.selectedAccessories.item1.selected=false
                    this.selectedAccessories.item1.qty=0
            }
            if (id==2) {
                    this.tableData.cable.selected=false
                    this.tableData.cable.qty=0
                    this.selectedAccessories.item2.idCable=undefined
                    this.selectedAccessories.item2.selected=false
                    this.selectedAccessories.item2.qty=0
            }
            if (id==3) {
                    this.tableData.mufta.selected=false
                    this.tableData.mufta.qty=0
                    this.selectedAccessories.item3.idMufta=undefined
                    this.selectedAccessories.item3.selected=false
                    this.selectedAccessories.item3.qty=0
            }
            if (id==4) {
                this.tableData.vessel.selected=false
                this.tableData.vessel.qty=0
                this.selectedAccessories.item4.idVessel=undefined
                this.selectedAccessories.item4.selected=false
                this.selectedAccessories.item4.qty=0
            }
            if (id==5) {
                    this.tableData.jacket.selected=false
                    this.tableData.jacket.qty=0
                    this.selectedAccessories.item5.idJacket=undefined
                    this.selectedAccessories.item5.selected=false
                    this.selectedAccessories.item5.qty=0
            }         
        }
    }
  }
</script>

<style scoped>
.exeption-validation {
    text-align: center;
    display: block
}
form.el-form.el-form--label-left {
    padding: 0 20px;
}
.el-form--label-left .el-form-item {
    margin-bottom: 5px;
}
.starposition{
    top: -27px;
    position: relative;
    left: -11px;
    line-height: 0px;
    float: left;
}
.condition {
    top: 8px;
}
#pumps-accessorias {
  border-collapse: collapse;
}
#pumps-accessorias td:first-child {
    text-align:left;
    padding-left:10px  
}
#pumps-accessorias td, #pumps-accessoriasth {
  border: 1px solid #ddd;
  padding: 8px;
}
#pumps-accessorias tr:nth-child(even){background-color: #f2f2f2;}
#pumps-accessorias tr:hover {background-color: #ddd;}
#pumps-accessorias th {
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
div#el-popover {
    background:  #f2f2f2;
    padding: 10px;
}

table {
    width: 100%;
    margin: 0;
    padding: 0;
    border-collapse: collapse;
    border-spacing: 0;
    }

table tr {
    border: 1px solid #ddd;
    padding: 5px;
    }

table th,    table td {
    padding: 10px;
    text-align: center;
    }
@media screen and (max-width: 600px) {
    table {
        border: 0;
    }
    table thead {
        display: none;
    }
    table tr {
        margin-bottom: 10px;
        display: block;
        border-bottom: 2px solid #ddd;
    }
    table td {
        display: block;
        text-align: right;
        font-size: 13px;
        border-bottom: 1px dotted #ccc;
    }
    table td:last-child {
        border-bottom: 0;
    }
    table td:before {
        content: attr(data-label);
        float: left;
        text-transform: uppercase;
        font-weight: bold;
    }
    }
</style>

