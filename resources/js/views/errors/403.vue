<template>
  <div class="error-box">
    <div class="row">
      <div class="col-sm-12 text-sm-center">
        <h1>403</h1>
        <h5>Bạn không có quyền truy cập trang này!</h5>
        <router-link class="btn btn-lg bg-yellow" to="/">
          <i class="icon-fa icon-fa-arrow-left"/> Đi đến trang chủ
        </router-link>
      </div>
    </div>
  </div>
</template>

<!--<script>
  export default {
    mounted () {
      this.setLayoutClasses()
    },
    destroyed () {
      document.body.classList.remove('page-error-404')
    },
    methods: {
      setLayoutClasses () {
        let body = document.body
        body.classList.add('page-error-404')
      }
    }
  }
</script>-->
