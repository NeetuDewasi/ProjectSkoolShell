<template>
  <tr>
    <td>{{index+1}}</td>
    <td>{{other_downloads.content_title}}</td>
    <td>{{other_downloads.type}}</td>
    <td>{{other_downloads.date}}</td>
    <td>{{other_downloads.available_for}}</td>
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
export default{
    props:['other_downloads','index'],
    data(){
        return{

        }
    }
}
</script>
