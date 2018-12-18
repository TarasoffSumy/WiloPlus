<template>
<div>
    <h2>Підібране приладдя</h2>
    
    <el-row>       
            <div v-for="item in selectedAccessories" :key="item.id" class="item" >
                <el-row v-if="item.selected"> 
                    <h3>
                        {{item.title}}
                    </h3>
                    <el-col :span="2" :offset="6"><el-button @click="onDelete(item.id)" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="5"><img :src="url+item.img" width="100px" alt=""></el-col>
                    <el-col :span="5">
                        <div>{{item.price}}</div>
                        
                        </el-col>                    
                </el-row>                            
            </div>  
    </el-row> 
    <el-row >    
    </el-row> 
</div>
</template>

<script>
  export default {
    props: ['url', 'selectedAccessories' ],
    data() {
      return {
        HeadValTotal: 0,
        focusInput: 0
      }
    },
    computed: {
        reloadData:  function() {
            return
            this.selectedAccessories.item1.idController="5445"
        }
        
    },
    created:  function(){
    },
    methods: {
    onDelete(id){
        this.selectedAccessories['item'+id].selected=false
        this.selectedAccessories['item'+id].idController=undefined

        }
    }
  };
</script>
<style scoped >
.item {
    width: 50%;
    float: left;
    text-align: left
}
</style>

