<template>
<div>
    <h2>Помічник визначення витрати насоса</h2>
    <p class="sub-title">
        Вкажіть кількість точок водозбору
    </p>
    <el-row>
        <el-col :span="12" class="side-side1-helper">
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Мийка кухні/умивальник </span>    
                <el-input-number v-model="volumeFlow.Val1" @change="handleChange(volumeFlow.Val1, 1)" :min="0" ></el-input-number>
                шт 
            </p>
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Ванна/душова кабіна </span>   
                <el-input-number v-model="volumeFlow.Val2" @change="handleChange(volumeFlow.Val2, 2)" :min="0" ></el-input-number>
                шт 
            </p>
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Посудомийна машина </span>  
                <el-input-number v-model="volumeFlow.Val3" @change="handleChange(volumeFlow.Val3, 3)" :min="0" ></el-input-number>
                шт 
            </p>
            <p><span class="additional-volume-flow"><el-button type="text" @click="open">Додаткові витарти<i type="info" class="el-icon-question"></i> </el-button></span>  
                <el-input-number v-model="volumeFlow.Val7" @change="handleChange(volumeFlow.Val7, 7)" :min="0" ></el-input-number>
                м<sup>3</sup>/ч              
            </p>
        </el-col>
        <el-col :span="10" class="side-side1-helper">
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Пральна машина</span>   
                <el-input-number v-model="volumeFlow.Val4" @change="handleChange(volumeFlow.Val4, 4)" :min="0" ></el-input-number>
                шт 
            </p>
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Биде</span> 
                <el-input-number v-model="volumeFlow.Val5" @change="handleChange(volumeFlow.Val5, 5)" :min="0" ></el-input-number>
                шт 
            </p>
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Унитаз  </span>  
                <el-input-number v-model="volumeFlow.Val6" @change="handleChange(volumeFlow.Val7, 6)" :min="0" ></el-input-number>
                шт 
            </p>
        </el-col>
    </el-row> 
    <el-row class="row-before-nav">
        <p class="computed-volumeFlow">
          <span class="label">Розрахована витрата</span>
          <span class="number"> {{compTotal}}</span> м<sup>3</sup>/ч 
       </p>
        <span class="exeption-validation" v-if="!$v.volumeFlowValTotal.between">Нажаль серія насосів Actun SPU4 не може задовільнити ваші потреби, 
                 витрата не повинна перевищувати <strong>17 м<sup>3</sup>/ч</strong></span> 
     
    </el-row>
     
</div>
</template>
<script>
import { required, minLength, between } from 'vuelidate/lib/validators';
  export default {
    props: ['maxVolumeFlow', 'modelFlowItems'],
    data() {
      return {
          volumeFlow: {
            Val1: this.modelFlowItems.val1,
            Val2: this.modelFlowItems.val2,
            Val3: this.modelFlowItems.val3,
            Val4: this.modelFlowItems.val4,
            Val5: this.modelFlowItems.val5,
            Val6: this.modelFlowItems.val6,
            Val7: this.modelFlowItems.val7                
          },         
        volumeFlowValTotal: 0
      }
    },
    validations: {
        volumeFlowValTotal: {
        required,
        between: between(0, 17)
        }
    },
    computed: {
        compTotal: function() {
            var source=Object.values(this.volumeFlow);
            var result=source.reduce(function(sum, current) {
            return sum + current ;
            });
            this.volumeFlowValTotal=result
            this.$emit('onComputeVolumeFlow', this.volumeFlowValTotal)
            return result
        }
    },
    methods: {
      handleChange(value, id) {
        this.$emit('onInputFlowItems', id ,value)
      },
      open() {
        this.$alert('This is a message', 'Title', {
          confirmButtonText: 'OK',
          callback: action => {
            this.$message({
              type: 'info',
              message: `action: ${ action }`
            });
          }
        });
      }
    }
  };
</script>
<style scoped>
.row-before-nav {
    height: 100px;
}
.side-side1-helper .item {
    min-width: 250px;
    text-align: left;
    display: inline-table;
    margin: 3px 0;
}
.computed-volumeFlow {
    font-size: 16px;
}
.computed-volumeFlow .label, .computed-volumeFlow .number {    
    font-weight: 600;
    font-size: 18px;
}
.computed-volumeFlow .number {
    border-bottom: 1px solid #b9b8b8;
    padding: 2PX 15px;
    font-size: 18px;
}
.el-dialog__body {
    padding: 0;
}
.el-dialog__body h2 {
    color: #009c82;
}
p.sub-title {
    text-align: left;
    padding-left: 94px;
    font-size: 16px;
    font-weight: 600;
}
.side-side1-helper p {
    text-align: center
}
.side-side1-helper img {
    vertical-align: middle;
    display: inline-block;
}
.additional-volume-flow {
    padding: 0 28px 0 64px
}
.additional-volume-flow button {
    color: #363640
}
</style>

