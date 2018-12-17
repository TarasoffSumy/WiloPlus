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
                        <p>detail</p>
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
    props: ['url'],
    data() {
      return {
        selectedAccessories: {
            item1: {
                id:1,
                title: 'Прилад керування і захисту насоса',
                img:'assets/controller.jpg',
                price: '2500 грн',
                selected:true,
            },
            item2: {
                id:2,
                title: 'Кабель',
                img:'assets/cable.jpg',
                price: '2500 грн',
                selected:true
            },
            item3: {
                id:3,
                title: 'З’єднання насоса',
                img:'assets/mufta.jpg',
                price: '2500 грн',
                selected:true
            },
            item4: {
                id:4,
                title: 'Мембранний напірний бак',
                img:'assets/bak.jpg',
                price: '2500 грн',
                selected:true
            }
        },

        HeadValTotal: 0,
        focusInput: 0
      }
    },
    computed: {
    },
    created:  function(){
    },
    methods: {
    onDelete(id){
        this.selectedAccessories['item'+id].selected=false

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

