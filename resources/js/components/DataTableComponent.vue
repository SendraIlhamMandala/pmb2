<script setup>
import DataTable from "datatables.net-vue3";
import DataTablesLib from "datatables.net";
import "datatables.net-select";
import "datatables.net-buttons";
import "datatables.net-buttons/js/buttons.html5";
import jszip from "jszip";
import pdfmake from "pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";

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
});
</script>

<template>

  
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
            
            buttons: ['copy', 'excel', 'pdf',
            {
                
                        text: 'Toggle action',
                        action: function ( e, dt, node, config ) {
                            dt.column( -2 ).visible( ! dt.column( -2 ).visible() );
                            dt.column( -1 ).visible( ! dt.column( -1 ).visible() );
                        }
                 
            },{
            extend: 'excelHtml5',
            customize: function ( xlsx ){
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
 
                // jQuery selector to add a border
                $('row c[r*="10"]', sheet).attr( 's', '25' );
            }}
          ],
        }"
    >
        <thead>
            <tr>
                <th v-for="column in columns">{{ column.data }}</th>
            </tr>
        </thead>
    </DataTable>
</template>

<style>
@import "datatables.net-dt";
@import "datatables.net-buttons-dt";
</style>
