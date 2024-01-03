<template>
  <table class="table display data-table text-nowrap">
    <thead>
      <tr>
        <th v-for="{item, index} in theads" :key="index">{{item}}</th>
      </tr>
    </thead>
    <tbody>{{tbody}}</tbody>
  </table>
</template>

<script>
export default {
    props: ['theads', 'tbody']

}
</script>

<style>

</style>
