<template>
<div>
    <el-col :span="5">
                    <img :src="url+'assets/controller.jpg'" width="100px" alt="">
    </el-col>
    <el-col :span="12" :offset="2">
                        <p>Ціна <strong>{{item.price}} грн</strong></p>                           
                        <p>Ток мінімальний  <strong>{{item.features.current_min}}</strong> </p>
                        <p>Ток максимальний <strong>{{item.features.current_max}}</strong> </p>
                        <el-button type="primary">Детальніше</el-button>                       
    </el-col>                    
</div>
</template>