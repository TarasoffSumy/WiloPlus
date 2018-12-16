<template>
    <div>
        <el-row>
        <div class="circle_numder">
            <svg height="55" width="53" class="circle">
            <circle cx="26" cy="26" r="24" stroke="" stroke-width="2" fill="" />
            </svg> <span>4 </span>            
        </div>
        <h2 class="title">Комерційна пропозиція</h2> 
        </el-row>
        <table id="pump">
            <thead>
                <colgroup span="4"></colgroup>
                <tr>
                    <th>Найменування</th>
                    <th>Кількість</th>
                    <th>ціна</th>
                    <th>Всього</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="tableData.pump.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(1)"><i class="el-icon-error"></i></el-button>
                    {{tableData.pump.name}}</td>
                    <td><el-input-number v-model="tableData.pump.amount" @change="handleChange()" :min="1" :max="10"></el-input-number></td>
                    <td>{{tableData.pump.price}}</td>
                    <td>{{tableData.pump.price*tableData.pump.amount}}</td>
                </tr>
                <tr v-if="tableData.cuble.selected" >
                    <td><el-button type="text"
                    @click="handleDelete(2)"><i class="el-icon-error"></i></el-button>
                    {{tableData.cuble.name}}</td>
                    <td><el-input-number v-model="tableData.cuble.amount" @change="handleChange()" :min="1" :max="10"></el-input-number></td>
                    <td>{{tableData.cuble.price}}</td>
                    <td>{{tableData.cuble.price*tableData.cuble.amount}}</td>
                </tr>
            </tbody>
        </table>

        
 
   
    </div>


    
</template>

<script>
  export default {
    data() {
      return {
        tableData: {
            pump: {
                name: 'FIRST SPU4.01-10-B/XI4-50-1-230',
                price: 2500, 
                amount: 1,
                selected:true
                }, 
            cuble:
            {
                name: 'Cabel 123',
                price: 2500, 
                amount: 1,
                selected:true
            }
        }
      }
    },
    methods: {
      handleChange() {
        // console.log(index, row);
      },
      handleDelete() {
          this.tableData.pump.selected=false
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
</style>

