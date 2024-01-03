<template>
  <tr>
    <td>{{index+1}}</td>
    <td>{{study_material.content_title}}</td>
    <td>{{study_material.type}}</td>
    <td>{{study_material.date}}</td>
    <td>{{study_material.available_for}}</td>
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
    props:['study_material','index'],
    data(){
        return{

        }
    }
}
</script>
