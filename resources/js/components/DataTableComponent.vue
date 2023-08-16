<script setup lang="ts">
import DataTable from 'datatables.net-vue3';
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';
import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.html5';
import jszip from 'jszip';
import pdfmake from 'pdfmake';
import pdfFonts from "pdfmake/build/vfs_fonts";


DataTable.use(DataTablesLib);
DataTablesLib.Buttons.jszip(jszip);
pdfMake.vfs = pdfFonts.pdfMake.vfs;
DataTablesLib.Buttons.pdfMake(pdfmake);



const options = {
  dom: 'Bftip',
  select: true,
  buttons: [
        'copy', 'excel', 'pdf'
    ]
};

let props = defineProps(
  {
    form : Object,
    games : Object,
    columns : Object,
  }
);

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
        order:[],
        buttons: [
        'copy', 'excel', 'pdf'
    ]
        }"
    >
      <thead>
        <tr >
          <th v-for="column in columns" >{{column.data}}</th>
        </tr>
      </thead>

    </DataTable>
</template>

<style>
@import 'datatables.net-dt';
@import 'datatables.net-buttons-dt';
</style>
