<template>
<div>
    <h2>Помічник визначення витрати насоса</h2>
    <p class="sub-title">
        Вкажіть кількість точок водозбору
    </p>
    <el-row>
        <el-col :span="12" class="side-side1-helper">

        </el-col>
        <el-col :span="10" class="side-side1-helper">

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
        this.$emit('onComputevolumeFlow', this.volumeFlowValTotal)
        console.log(value)
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
.side-side1-helper span {
    min-width: 200px;
    text-align: left;
    display: inline-table;
    margin: 15px 0;
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
</style>

