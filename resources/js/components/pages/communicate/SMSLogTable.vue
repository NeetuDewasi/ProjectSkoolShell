<template>
  <tr>
    <td>{{index+1}}</td>
    <td>{{emailSMSLog.title}}</td>
    <td>{{emailSMSLog.date}}</td>
    <td>{{emailSMSLog.email}}</td>
    <td>{{emailSMSLog.sms}}</td>
    <td>{{emailSMSLog.group}}</td>
    <td>{{emailSMSLog.individual}}</td>
    <td>{{emailSMSLog.class}}</td>
    <td>
      <div class="form-group">
        <button type="submit" class="btn btn-success btn-hover-bluedark mx-2">
          <i class="fas fa-pen text-white"></i>
        </button>
        <button type="submit" class="btn btn-danger btn-hover-bluedark">
          <i class="fas fa-trash text-white"></i>
        </button>
      </div>
    </td>
  </tr>
</template>

<script>

export default {
    props: ['index','emailSMSLog']
}
</script>
