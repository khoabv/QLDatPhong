<template>
  <div class="main-content add-users">
    <div class="page-header">
      <h3 class="page-title">Thêm mới Phòng họp</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Quản lý phòng họp</a></li>
        <li class="breadcrumb-item active">Thêm mới</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h6>Thông tin phòng</h6>
          </div>
          <div class="card-body">
            <form @submit.prevent="validateBeforeSubmit" class="form">
              <div :class="{'form-group' : true}">
                <label class="required">Tên phòng</label>
                <input
                  v-model.trim="dataAdd.ten_phong"
                  type="text"
                  class="form-control"
                  name="ten_phong"
                  placeholder="Nhập tên phòng"
                >
                <div class="message_invalid">
                  {{ message.ten_phong }}
                </div>
              </div>

              <!--<div :class="{'form-group' : true}">
                <label class="required">Mô tả</label>
                <input
                  v-model.trim="dataAdd.mo_ta"
                  type="text"
                  class="form-control"
                  name="mo_ta"
                  placeholder="Nhập mô tả phòng"
                >
                <div class="message_invalid">
                  {{ message.mo_ta }}
                </div>
              </div>-->

              <div  class="form-group">
                <label class="">Mô tả</label>
                <textarea rows="3" class="form-control"
                          v-model="dataAdd.mo_ta"></textarea>
              </div>

              <div class="form-group">
                <select v-model = "dataAdd.trang_thai" class="custom-select">
                  <option value="">Chọn trạng thái phòng</option>
                  <option value="0">Đang bảo trì</option>
                  <option value="1">Đang sử dụng</option>
                </select>
                <div class="message_invalid">
                  {{ message.trang_thai }}
                </div>
              </div>
              <div class="form-group">
                <select v-model = "dataAdd.loai_phong" class="custom-select">
                  <option value="">Loại phòng</option>
                  <option value="0">Hội thảo</option>
                  <option value="1">Phỏng vấn</option>
                  <option value="2">Họp</option>
                  <option value="3">Đào tạo</option>
                  <option value="4">Khác</option>
                </select>
                <div class="message_invalid">
                  {{ message.loai_phong }}
                </div>
              </div>
              <div class="form-group">
                <label class="required">Sức chứa</label>
                <input
                  v-model.trim="dataAdd.soluong"
                  type="number"
                  class="form-control"
                  name="mo_ta"
                  placeholder="Sức chứa"
                  min="1"
                >
                <div class="message_invalid">
                  {{ message.soluong }}
                </div>
              </div>

              <div class="form-group">
                <button class="btn btn-success">
                  Lưu
                </button>
                <router-link to="/admin/rooms/all">
                  <a class="btn btn-secondary">
                    Hủy
                  </a>
                </router-link>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  /* name: 'UsersAdd', */
  data () {
    return {
      dataAdd: {
        ten_phong: '',
        mo_ta: '',
        trang_thai: '',
        loai_phong:'',
        soluong:'',
      },
      message: {
        ten_phong: '',
        mo_ta: '',
        trang_thai: '',
        loai_phong:'',
        soluong:'',
      }
    }
  },
  methods: {
    async validateBeforeSubmit () {
      if (this.validate() === true) {
        // eslint-disable-next-line no-unused-vars,no-undef
        let response = await axios.post('/api/admin/rooms/create', this.dataAdd)
        if (response.data.result === true) {
          window.toastr['success'](response.data.message, 'Success')
          window.location.href = '/admin/rooms/all'
        } else window.toastr['error'](response.data.message, 'Error')

      }

    },
    validate () {
      this.message.ten_phong = ''
      this.message.loai_phong = ''
      this.message.mo_ta = ''
      this.message.trang_thai = ''
      let resultCheck = true;
      if (this.dataAdd.ten_phong === '' || this.dataAdd.ten_phong === null || typeof (this.dataAdd.ten_phong) === 'undefined') {
        this.message.ten_phong = 'Trường không được để trống!'
        resultCheck = false
      }

      if (this.dataAdd.trang_thai === '' || this.dataAdd.trang_thai === null || typeof (this.dataAdd.trang_thai) === 'undefined') {
        this.message.trang_thai = 'Trường không được để trống!'
        resultCheck = false
      }
      if (this.dataAdd.loai_phong === '' || this.dataAdd.loai_phong === null || typeof (this.dataAdd.loai_phong) === 'undefined') {
        this.message.loai_phong = 'Trường không được để trống!'
        resultCheck = false
      }
      if (this.dataAdd.soluong === '' || this.dataAdd.soluong === null || typeof (this.dataAdd.soluong) === 'undefined') {
        this.message.soluong = 'Trường không được để trống!'
        resultCheck = false
      }

      return resultCheck
    }
  }
}
</script>

<!--<style scoped>

</style>-->
