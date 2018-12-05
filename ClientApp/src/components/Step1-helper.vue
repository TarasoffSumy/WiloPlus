<template>
<div>
    <h2>Помічник визначення витрати насоса</h2>
    <p class="sub-title">
        Вкажіть кількість точок водозбору
    </p>
    <el-row>
        <el-col :span="12" class="side-side1-helper">
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Мийка кухні/умивальник </span>    
                <el-input-number v-model="volumeFlow.Val1" @change="handleChange" :min="0" :max="17"></el-input-number>
                шт 
            </p>
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Ванна/душова кабіна </span>   
                <el-input-number v-model="volumeFlow.Val2" @change="handleChange" :min="0" :max="17"></el-input-number>
                шт 
            </p>
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Посудомийна машина </span>  
                <el-input-number v-model="volumeFlow.Val3" @change="handleChange" :min="0" :max="17"></el-input-number>
                шт 
            </p>
            <p><span class="additional-volume-flow"><el-button type="text" @click="open">Додаткові витарти<i type="info" class="el-icon-question"></i> </el-button></span>  
                <el-input-number v-model="volumeFlow.Val7" @change="handleChange" :min="0" :max="17"></el-input-number>
                м<sup>3</sup>/ч              
            </p>
        </el-col>
        <el-col :span="10" class="side-side1-helper">
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Пральна машина</span>   
                <el-input-number v-model="volumeFlow.Val4" @change="handleChange" :min="10" :max="17"></el-input-number>
                шт 
            </p>
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Биде</span> 
                <el-input-number v-model="volumeFlow.Val5" @change="handleChange" :min="0" :max="17"></el-input-number>
                шт 
            </p>
            <p><span class="item"> <img src="assets/itemVolumeFlow1.png" alt=""> Унитаз  </span>  
                <el-input-number v-model="volumeFlow.Val6" @change="handleChange" :min="0" :max="17"></el-input-number>
                шт 
            </p>
        </el-col>
    </el-row> 
    <el-row >
        <p class="computed-volumeFlow">
          <span class="label">Розрахована витрата</span>
          <span class="number"> {{volumeFlowValTotal}}</span> м<sup>3</sup>/ч 
        </p>     
    </el-row>
     
</div>
</template>
<script>
  export default {
    data() {
      return {
          volumeFlow: {
            Val1: 0,
            Val2: 0,
            Val3: 0,
            Val4: 0,
            Val5: 0,
            Val6: 0,
            Val7: 0                
          },         
        volumeFlowValTotal: 0
      };
    },
    methods: {
      handleChange(value) {
        var source=Object.values(this.volumeFlow);
        var result=source.reduce(function(sum, current) {
            return sum + current ;
        });
        this.volumeFlowValTotal=result
        this.$emit('onComputeVolumeFlow', this.volumeFlowValTotal)
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

