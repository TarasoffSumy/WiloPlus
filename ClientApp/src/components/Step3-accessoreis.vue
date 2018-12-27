<template>
<div>
    <h2>Підібране приладдя</h2>
    <el-row>       
        <div class="item">    
                <el-row v-if="selectedAccessories.selected"> 
                    <h3>
                        {{selectedAccessories.title}}
                    </h3>
 
                    <el-col :span="2" :offset="1"><el-button @click="onDelete()" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="20">
                         <ControlBox 
                        :controllers="selectedAccessories"
                        :url="url"
                        />                       
                    </el-col>                   
                </el-row> 
        </div>
    </el-row> 
</div>
</template>

<script>
  export default {
    props: ['url', 'selectedAccessories' ],
    data() {        
      return {
        newData: this.selectedAccessories,
        HeadValTotal: 0,
        focusInput: 0
      }
    },
    computed: {
        
    },
    created:  function(){
    },
    methods: {
    onDelete(){
        // this.selectedAccessories['item'+id].selected=false
        // this.selectedAccessories['item'+id].idController=undefined

        }
    }
  };
</script>
<style scoped >
.item {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left
}
.item i {
    font-size: 20px;
}
</style>

