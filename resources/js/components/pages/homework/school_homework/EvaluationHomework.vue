<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb pageTitle="Evaluate Homework" :breadcrumbList="breadcrumbList" >
        <template v-slot:button>
                <button type="submit" class="btn btn-primary btn-sm text-white"  @click="$router.push({name: 'school.homework.homework'})">
                    <i class="fa fa-eye"></i> All View Homework
                </button>
        </template>
      </Breadcrumb>
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card height-auto">
          </div>
        </div>
      </div>
      <!-- Add Homework End Here -->
      <Footer />
    </div>
  </div>
</template>

<script>

</script>


<style>

</style>
