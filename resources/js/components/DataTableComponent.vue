<script setup>
import DataTable from "datatables.net-vue3";
import DataTablesLib from "datatables.net";
import "datatables.net-select";
import "datatables.net-buttons";
import "datatables.net-buttons/js/buttons.html5";
import jszip from "jszip";
import pdfmake from "pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
import axios from "axios";
import {ref,onMounted} from "vue";
import { router } from '@inertiajs/vue3'


DataTable.use(DataTablesLib);
DataTablesLib.Buttons.jszip(jszip);
pdfMake.vfs = pdfFonts.pdfMake.vfs;
DataTablesLib.Buttons.pdfMake(pdfmake);

const options = {
    dom: "Bftip",
    select: true,
    buttons: ["copy", "excel", "pdf"],
};

let props = defineProps({
    form: Object,
    games: Object,
    columns: Object,
    dataExcel: Object,
});

function exportHTML(){
      
       
       
    axios.get('/gethtmlpage').then(response => {
        var sourceHTML = '';
           sourceHTML = response.data;
           console.log(response.data);
           var fileDownload = document.createElement("a");
           var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
           
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = 'document.doc';
       fileDownload.click();
       })
       
    }
    let dt;
const table = ref();
 
onMounted(function () {
  dt = table.value.dt;
});

    function remove() {
    if(confirm("delete ?")){
        let datax = [];
let i = 0;

dt.rows({ selected: true }).every(function () {
    
    datax.push(this.data().id);
    
});
console.log(datax);
    //create alert delete or no
    router.get(route(`deleteMultiple`,datax),{
    preserveScroll: true,
    })
  
}else {
        return false;
    }
}
</script>

<template>
<button @click="remove" class="mb-12">Delete selected rows</button>

  
    <DataTable
        :columns="columns"
        ref="table"
        :data="games"
        class="display"
        width="100%"
        :options="{
            dom: 'Bfrtip',
            select: true,
            order: [],
            
            buttons: ['copy', props.dataExcel , 'pdf',
            {
                
                        text: 'Toggle action',
                        action: function ( e, dt, node, config ) {
                            dt.column( -2 ).visible( ! dt.column( -2 ).visible() );
                            dt.column( -1 ).visible( ! dt.column( -1 ).visible() );
                        }
            },{
                text: 'Export doc',
                action: function (){
                    exportHTML();
                }
            }
          ],
        }"
    >
        <thead>
            <tr>
                <th v-for="column in columns">{{ column.data }}</th>
            </tr>
        </thead>
        <tbody>
            <td>
            </td>
        </tbody>
    </DataTable>
</template>

<style>
@import "datatables.net-dt";
@import "datatables.net-buttons-dt";
</style>
